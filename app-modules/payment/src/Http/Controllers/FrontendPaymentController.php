<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Models\CustomPayment;
use Modules\Payment\Models\Payment;

class FrontendPaymentController extends Controller
{
    /**
     * Show custom payment form
     */
    public function showCustomPaymentForm()
    {
        $gatewayCharges = [
            'sslcommerz' => config('global.sslcommerz_payment_gateway_charge', 2.10),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];

        return view('payment::frontend.custom-payment-form', compact('gatewayCharges'));
    }

    /**
     * Submit custom payment form with reCAPTCHA validation
     */
    public function submitCustomPaymentForm(Request $request)
    {
        // Get client IP address for rate limiting
        $ipAddress = $request->ip();
        
        // Rate limiting: Check if more than 3 custom payments from same IP within 2 minutes
        // future if statement  if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'developer'])) 
        $recentPayments = CustomPayment::where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();
            
        if ($recentPayments >= 3) {
            return back()->withErrors([
                'rate_limit' => __('messages.rate_limit_error')
            ])->withInput();
        }

        // Prepare validation rules
        $rules = [
            'amount' => 'required|numeric|min:100',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'purpose' => 'nullable|string|max:500',
        ];

        $messages = [
            'amount.min' => __('messages.amount_minimum_required'),
        ];

        // Add reCAPTCHA validation if enabled
        if (env('RECAPTCHA_ENABLED', false)) {
            $rules['g-recaptcha-response'] = 'required';
            $messages['g-recaptcha-response.required'] = 'Please complete the reCAPTCHA verification.';
        }

        // Validate form input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify reCAPTCHA if enabled
        if (env('RECAPTCHA_ENABLED', false)) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $recaptchaSecret = config('services.recaptcha.secret_key');
            
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);

            $recaptchaData = $response->json();

            if (!$recaptchaData['success']) {
                return back()
                    ->withErrors(['recaptcha' => 'reCAPTCHA verification failed. Please try again.'])
                    ->withInput();
            }
        }

        try {
            // Create custom payment record
            $customPayment = CustomPayment::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'amount' => $request->amount,
                'purpose' => $request->purpose,
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'reference_number' => 'CP-' . strtoupper(uniqid()),
            ]);

            // Create initial payment record with SSL Commerz
            $payment = Payment::create([
                'custom_payment_id' => $customPayment->id,
                'amount' => $request->amount,
                'email_address' => $request->email, // Store email directly in payment
                'payment_method' => 'sslcommerz',
                'store_name' => config('sslcommerz.default_store', 'main-store'),
                'status' => 'pending',
                'payment_date' => now(),
            ]);

            // Redirect to payment page
            return redirect()->route('payment::payments.show', $payment->id)
                ->with('success', 'Payment request created successfully. Please complete your payment.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'An error occurred while processing your request. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show payment page
     */
    public function showPayment(Payment $payment)
    {
        // Load related data
        $payment->load(['customPayment', 'booking']);

        // Get gateway charges
        $gatewayCharges = [
            'sslcommerz' => config('global.sslcommerz_payment_gateway_charge', 2.10),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];

        // Calculate gateway fees using trait methods
        $sslcommerzCalculation = \App\Helpers\Helpers::calculateSSLCommerzTotal($payment->amount);
        // Temporarily commented out until bKash integration
        // $bkashCalculation = \App\Helpers\Helpers::calculateBkashTotal($payment->amount);

        return view('payment::frontend.payment-page', compact('payment', 'gatewayCharges', 'sslcommerzCalculation' /*, 'bkashCalculation'*/));
    }

    /**
     * Process payment - redirect to appropriate payment gateway
     */
    public function processPayment(Payment $payment, Request $request)
    {
        // Route to appropriate payment gateway based on payment method
        switch ($payment->payment_method) {
            case 'sslcommerz':
                $sslController = new \Modules\Payment\Http\Controllers\SslCommerzController();
                return $sslController->processPayment($payment, $request);
                
            default:
                return back()->withErrors(['error' => __('messages.payment_method_not_supported', ['method' => $payment->payment_method])]);
        }
    }

    /**
     * Show payment confirmation page
     */
    public function showPaymentConfirmation(Payment $payment)
    {
        // Load related data
        $payment->load(['customPayment', 'booking']);

        return view('payment::frontend.payment-confirmation', compact('payment'));
    }
}