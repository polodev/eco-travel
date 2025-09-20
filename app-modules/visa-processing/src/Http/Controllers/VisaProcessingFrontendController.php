<?php

namespace Modules\VisaProcessing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\VisaProcessing\Models\VisaProcessing;
use Modules\VisaProcessing\Models\VisaApplication;
use Modules\Payment\Models\Payment;

class VisaProcessingFrontendController extends Controller
{
    /**
     * Display a listing of published visa processings.
     */
    public function index(Request $request)
    {
        $query = VisaProcessing::published()
            ->orderBy('is_featured', 'desc')
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc');

        // Filter by country if provided
        if ($request->filled('country')) {
            $query->byCountry($request->country);
        }

        // Filter by visa type if provided
        if ($request->filled('visa_type')) {
            $query->byVisaType($request->visa_type);
        }

        // Filter by difficulty if provided
        if ($request->filled('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('english_title', 'like', "%{$searchTerm}%")
                  ->orWhere('title->en', 'like', "%{$searchTerm}%")
                  ->orWhere('title->bn', 'like', "%{$searchTerm}%")
                  ->orWhere('country_name', 'like', "%{$searchTerm}%");
            });
        }

        // Sort by price if provided
        if ($request->filled('sort_price')) {
            $query->orderBy('price', $request->sort_price === 'high' ? 'desc' : 'asc');
        }

        $visaProcessings = $query->paginate(12);

        // Get filter options
        $countries = VisaProcessing::published()->select('country')->distinct()->get();
        $visaTypes = VisaProcessing::getAvailableVisaTypes();
        $difficultyLevels = VisaProcessing::getAvailableDifficultyLevels();

        return view('visa-processing::frontend.index', compact(
            'visaProcessings', 
            'countries', 
            'visaTypes', 
            'difficultyLevels'
        ));
    }

    /**
     * Display the specified visa processing.
     */
    public function show(VisaProcessing $visaProcessing)
    {
        // Check if visa processing is published
        if (!$visaProcessing->isLive()) {
            abort(404);
        }

        // Get related visa processings (same country or visa type)
        $relatedVisas = VisaProcessing::published()
            ->where('id', '!=', $visaProcessing->id)
            ->where(function ($query) use ($visaProcessing) {
                $query->where('country', $visaProcessing->country)
                      ->orWhere('visa_type', $visaProcessing->visa_type);
            })
            ->limit(4)
            ->get();

        return view('visa-processing::frontend.show', compact('visaProcessing', 'relatedVisas'));
    }

    /**
     * Show visa processing purchase form.
     */
    public function showPurchaseForm(VisaProcessing $visaProcessing)
    {
        // Check if visa processing is published
        if (!$visaProcessing->isLive()) {
            abort(404);
        }

        $gatewayCharges = [
            'sslcommerz_regular' => config('global.sslcommerz_payment_gateway_charge', 2.00),
            'sslcommerz_premium' => config('global.sslcommerz_payment_gateway_charge_for_premium_card', 3.00),
            'bkash' => config('global.bkash_payment_gateway_charge', 1.5)
        ];

        return view('visa-processing::frontend.purchase', compact('visaProcessing', 'gatewayCharges'));
    }

    /**
     * Submit visa processing purchase form.
     */
    public function submitPurchase(Request $request, VisaProcessing $visaProcessing)
    {
        // Check if visa processing is published
        if (!$visaProcessing->isLive()) {
            abort(404);
        }

        // Get client IP address for rate limiting
        $ipAddress = $request->ip();
        
        // Rate limiting: Check if more than 5 visa processing payments from same IP within 10 minutes
        $recentPayments = Payment::where('payment_type', 'visa-processing')
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count();
            
        if ($recentPayments >= 5) {
            return back()->withErrors([
                'rate_limit' => __('messages.rate_limit_error')
            ])->withInput();
        }

        // Prepare validation rules
        $rules = [
            'payment_method' => 'required|in:sslcommerz',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'passport_number' => 'nullable|string|max:50',
            'travel_date' => 'nullable|date|after:today',
            // Document upload validation
            'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'passport' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'nid_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'trade_licence' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'tin_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'noc' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ];

        $messages = [
            'email.required' => __('messages.email_required'),
            'name.required' => __('messages.name_required'),
            'mobile.required' => __('messages.mobile_required'),
            'travel_date.after' => __('messages.travel_date_must_be_future'),
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
            
            $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
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
            // Create visa application record first
            $visaApplication = VisaApplication::create([
                'visa_processing_id' => $visaProcessing->id,
                'applicant_name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'passport_number' => $request->passport_number,
                'travel_date' => $request->travel_date,
                'customer_notes' => $request->notes,
                'application_status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'submission_date' => now(),
            ]);

            // Handle document uploads
            $documentTypes = ['bank_statement', 'passport', 'nid_card', 'trade_licence', 'tin_certificate', 'noc'];
            
            foreach ($documentTypes as $documentType) {
                if ($request->hasFile($documentType)) {
                    $visaApplication
                        ->addMediaFromRequest($documentType)
                        ->toMediaCollection($documentType);
                }
            }

            // Create payment record for visa processing
            $payment = Payment::create([
                'payment_type' => 'visa-processing',
                'booking_id' => null,
                'visa_processing_id' => $visaProcessing->id,
                'amount' => $visaProcessing->price,
                'email_address' => $request->email,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'purpose' => "Visa Application: {$visaApplication->application_number} - {$visaProcessing->english_title}",
                'payment_method' => $request->payment_method,
                'store_name' => config('sslcommerz.default_store', 'main-store'),
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'form_data' => [
                    'visa_processing_id' => $visaProcessing->id,
                    'visa_application_id' => $visaApplication->id,
                    'application_number' => $visaApplication->application_number,
                    'visa_processing_title' => $visaProcessing->english_title,
                    'country_slug' => $visaProcessing->country_slug,
                    'country_name' => $visaProcessing->country_name,
                    'visa_type' => $visaProcessing->visa_type,
                    'name' => $request->name,
                    'email_address' => $request->email,
                    'mobile' => $request->mobile,
                    'amount' => $visaProcessing->price,
                    'price' => $visaProcessing->price,
                    'visa_fees' => $visaProcessing->visa_fees,
                    'processing_fee' => $visaProcessing->processing_fee,
                    'currency' => 'BDT',
                    'form_type' => 'visa-application',
                    'passport_number' => $request->passport_number,
                    'travel_date' => $request->travel_date,
                    'customer_notes' => $request->notes,
                ],
                'notes' => $request->notes,
                'payment_date' => now(),
            ]);

            // Update visa application with payment ID
            $visaApplication->update(['payment_id' => $payment->id]);

            // Redirect to payment page
            return redirect()->route('payment::payments.show', $payment->id)
                ->with('success', "Your visa application #{$visaApplication->application_number} has been created successfully. Please complete your payment.");

        } catch (\Exception $e) {
            \Log::error('Visa application creation error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'An error occurred while processing your request. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Display featured visa processings for homepage.
     */
    public function featured()
    {
        $featuredVisas = VisaProcessing::published()
            ->featured()
            ->orderBy('position', 'asc')
            ->limit(8)
            ->get();

        return view('visa-processing::frontend.featured', compact('featuredVisas'));
    }

    /**
     * Display visa processings by country.
     */
    public function byCountry(string $countrySlug)
    {
        // Convert URL slug to country key
        $countryKey = VisaProcessing::getCountryKeyFromSlug($countrySlug);
        
        if (!$countryKey) {
            abort(404);
        }

        $visaProcessings = VisaProcessing::published()
            ->byCountry($countryKey)
            ->orderBy('is_featured', 'desc')
            ->orderBy('position', 'asc')
            ->paginate(12);

        if ($visaProcessings->isEmpty()) {
            abort(404);
        }

        $countryName = $visaProcessings->first()->country_name;
        $countryFlag = $visaProcessings->first()->country_flag;

        return view('visa-processing::frontend.by-country', compact(
            'visaProcessings', 
            'countrySlug', 
            'countryName', 
            'countryFlag'
        ));
    }


    /**
     * Display visa processings by visa type.
     */
    public function byVisaType(string $visaType)
    {
        $availableTypes = VisaProcessing::getAvailableVisaTypes();
        
        if (!array_key_exists($visaType, $availableTypes)) {
            abort(404);
        }

        $visaProcessings = VisaProcessing::published()
            ->byVisaType($visaType)
            ->orderBy('is_featured', 'desc')
            ->orderBy('position', 'asc')
            ->paginate(12);

        $visaTypeName = $availableTypes[$visaType];

        return view('visa-processing::frontend.by-visa-type', compact(
            'visaProcessings', 
            'visaType', 
            'visaTypeName'
        ));
    }
}