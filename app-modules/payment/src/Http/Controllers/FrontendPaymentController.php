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
        return view('payment::frontend.custom-payment-form');
    }

    /**
     * Submit custom payment form with reCAPTCHA validation
     */
    public function submitCustomPaymentForm(Request $request)
    {
        // Prepare validation rules
        $rules = [
            'amount' => 'required|numeric|min:1',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'required|string|max:20',
            'purpose' => 'nullable|string|max:500',
        ];

        $messages = [];

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
                'payment_method' => 'sslcommerz',
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

        return view('payment::frontend.payment-page', compact('payment'));
    }

    /**
     * Process payment (for future SSL Commerz integration)
     */
    public function processPayment(Payment $payment, Request $request)
    {
        // Validate payment method
        if ($payment->payment_method !== 'sslcommerz') {
            return back()->withErrors(['error' => 'This payment method is not currently supported.']);
        }

        // Here you would integrate with SSL Commerz API
        // For now, we'll just show a message
        return back()->with('info', 'SSL Commerz integration will be implemented in the next phase.');
    }

    /**
     * Handle successful payment callback
     */
    public function paymentSuccess(Payment $payment, Request $request)
    {
        // Handle SSL Commerz success callback
        // This will be implemented when SSL Commerz integration is added
        
        return view('payment::frontend.payment-success', compact('payment'));
    }

    /**
     * Handle failed payment callback
     */
    public function paymentFail(Payment $payment, Request $request)
    {
        // Handle SSL Commerz fail callback
        
        return view('payment::frontend.payment-failed', compact('payment'));
    }

    /**
     * Handle cancelled payment callback
     */
    public function paymentCancel(Payment $payment, Request $request)
    {
        // Handle SSL Commerz cancel callback
        
        return view('payment::frontend.payment-cancelled', compact('payment'));
    }
}