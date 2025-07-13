<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Modules\UserData\Helpers\CountryListWithCountryCode;
use Modules\UserData\Services\UserNotificationService;
use Illuminate\Validation\Rule;

new class extends Component {
    public string $country = '';
    public string $country_code = '';
    public string $mobile = '';
    public string $verification_code = '';
    public bool $verification_sent = false;
    public bool $is_verified = false;
    public string $generated_code = '';
    public array $countries = [];
    public bool $edit_mode = false;
    public string $current_country = '';
    public string $current_country_code = '';
    public string $current_mobile = '';
    public ?int $cooldown_until = null;
    
    public function mount()
    {
        $this->countries = CountryListWithCountryCode::getCountryOptions();
        
        $user = Auth::user();
        $this->current_country = $user->country ?? '';
        $this->current_country_code = $user->country_code ?? '';
        $this->current_mobile = $user->mobile ?? '';
        
        $this->country = $this->current_country;
        $this->country_code = $this->current_country_code;
        $this->mobile = $this->current_mobile;
        
        // Set initial country code if country is selected
        if ($this->country) {
            $this->country_code = CountryListWithCountryCode::getCountryCode($this->country) ?? '';
        }
        
        $this->checkCooldown();
    }
    
    public function startEdit()
    {
        $this->edit_mode = true;
        $this->country = $this->current_country;
        $this->country_code = $this->current_country_code;
        $this->mobile = $this->current_mobile;
        
        // Set country code if country is selected
        if ($this->country) {
            $this->country_code = CountryListWithCountryCode::getCountryCode($this->country) ?? '';
        }
        
        $this->reset(['verification_sent', 'is_verified', 'verification_code', 'generated_code']);
    }
    
    public function cancelEdit()
    {
        $this->edit_mode = false;
        $this->country = $this->current_country;
        $this->country_code = $this->current_country_code;
        $this->mobile = $this->current_mobile;
        $this->reset(['verification_sent', 'is_verified', 'verification_code', 'generated_code']);
    }
    
    public function getMobileChangedProperty()
    {
        return $this->country !== $this->current_country || 
               $this->country_code !== $this->current_country_code || 
               $this->mobile !== $this->current_mobile;
    }
    
    public function checkCooldown()
    {
        $cacheKey = 'mobile_verification_cooldown_' . Auth::id();
        $this->cooldown_until = cache($cacheKey);
        
        if (!$this->cooldown_until || $this->cooldown_until <= time()) {
            $this->cooldown_until = null;
        }
    }
    
    public function getCooldownActiveProperty()
    {
        return $this->cooldown_until && $this->cooldown_until > time();
    }
    
    public function updatedCountry()
    {
        if ($this->country) {
            $this->country_code = CountryListWithCountryCode::getCountryCode($this->country) ?? '';
        } else {
            $this->country_code = '';
        }
    }
    
    public function saveMobile()
    {
        $this->validate([
            'country' => 'required|string',
            'country_code' => 'required|string',
            'mobile' => 'required|string|min:7|max:15'
        ]);
        
        // Check if mobile exists for another user
        $existingUser = User::where('country_code', $this->country_code)
                          ->where('mobile', $this->mobile)
                          ->where('id', '!=', Auth::id())
                          ->first();
        
        if ($existingUser) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => "Mobile number already exists for User ID: {$existingUser->id}"
            ]);
            return;
        }
        
        // Check if mobile data is the same as current
        if (!$this->mobile_changed) {
            // No change, just save without verification
            $this->edit_mode = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Mobile information saved successfully!'
            ]);
            return;
        }
        
        // Mobile data is different, proceed with OTP verification
        $this->sendVerification();
    }
    
    public function sendVerification()
    {
        // Check cooldown first
        $this->checkCooldown();
        
        if ($this->cooldown_active) {
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => 'Please wait 1 minute before requesting another verification code.'
            ]);
            return;
        }
        
        // Generate 4-digit verification code
        $this->generated_code = UserNotificationService::generateVerificationCode(4);
        
        // Send SMS verification using custom service
        $smsSent = UserNotificationService::sendSmsVerification(
            Auth::id(),
            $this->country_code,
            $this->mobile,
            $this->generated_code,
            $this->country
        );
        
        if ($smsSent) {
            // Set cooldown for 1 minute (60 seconds)
            $cacheKey = 'mobile_verification_cooldown_' . Auth::id();
            $this->cooldown_until = time() + 60;
            cache([$cacheKey => $this->cooldown_until], 60);
            
            $this->verification_sent = true;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Verification code sent to your mobile. Check logs for code.'
            ]);
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Failed to send verification SMS. Please try again.'
            ]);
        }
    }
    
    public function verifyCode()
    {
        $this->validate([
            'verification_code' => 'required|string|size:4'
        ]);
        
        if ($this->verification_code === $this->generated_code) {
            // Update user mobile
            $user = Auth::user();
            $user->update([
                'country' => $this->country,
                'country_code' => $this->country_code,
                'mobile' => $this->mobile,
                'mobile_verified_at' => now()
            ]);
            
            // Update current values and exit edit mode
            $this->current_country = $this->country;
            $this->current_country_code = $this->country_code;
            $this->current_mobile = $this->mobile;
            $this->edit_mode = false;
            $this->is_verified = true;
            $this->verification_sent = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Mobile number verified and updated successfully!'
            ]);
            
            // Reset form
            $this->reset(['verification_code', 'generated_code', 'is_verified']);
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Invalid verification code. Please try again.'
            ]);
        }
    }
    
    public function cancelVerification()
    {
        $this->reset(['verification_code', 'verification_sent', 'generated_code']);
        
        $user = Auth::user();
        $this->country = $user->country ?? '';
        $this->country_code = $user->country_code ?? '';
        $this->mobile = $user->mobile ?? '';
    }
    
    public function resendVerification()
    {
        $this->sendVerification();
    }
}; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            <i class="fas fa-mobile-alt mr-2 text-green-500"></i>
            Mobile Management
        </h3>
        @if(!$edit_mode && !$verification_sent)
            <button 
                wire:click="startEdit"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="startEdit">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </span>
                <span wire:loading wire:target="startEdit">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Loading...
                </span>
            </button>
        @endif
    </div>
    
    @if(!$edit_mode && !$verification_sent)
        <!-- View Mode -->
        <div class="space-y-4">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Mobile:</span>
                <div class="mt-1 flex items-center">
                    @if($current_mobile && $current_country_code)
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-l text-gray-600 dark:text-gray-300 text-sm border-r">
                                {{ $current_country_code }}
                            </span>
                            <span class="px-3 py-1 bg-gray-50 dark:bg-gray-600 rounded-r text-sm text-gray-900 dark:text-white">
                                {{ $current_mobile }}
                            </span>
                            @if(Auth::user()->mobile_verified_at)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Verified
                                </span>
                            @else
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Not Verified
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-900 dark:text-white">Not provided</p>
                    @endif
                </div>
            </div>
            @if($current_country)
                <div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Country:</span>
                    <p class="text-sm text-gray-900 dark:text-white mt-1">
                        {{ CountryListWithCountryCode::getCountryName($current_country) }}
                    </p>
                </div>
            @endif
        </div>
    @elseif($edit_mode && !$verification_sent && !$is_verified)
        <form wire:submit="saveMobile" class="space-y-4">
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Country <span class="text-red-500">*</span>
                </label>
                <select 
                    id="country"
                    wire:model.live="country"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror"
                    required
                >
                    <option value="">Select Country</option>
                    @foreach($countries as $alpha3 => $countryOption)
                        <option value="{{ $alpha3 }}">{{ $countryOption }}</option>
                    @endforeach
                </select>
                @error('country')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mobile Number <span class="text-red-500">*</span>
                </label>
                <div class="flex">
                    <input 
                        type="text" 
                        wire:model="country_code"
                        class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-gray-50 dark:bg-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="+880" 
                        readonly
                    >
                    <input 
                        type="text" 
                        id="mobile"
                        wire:model.live="mobile"
                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror" 
                        placeholder="1234567890"
                        required
                    >
                </div>
                @error('mobile')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                @error('country_code')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                
                @if($this->mobile_changed)
                    <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Mobile information changed - verification will be required
                    </p>
                @endif
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>
                        @if($this->mobile_changed)
                            <i class="fas fa-sms mr-2"></i>
                            Send Verification
                        @else
                            <i class="fas fa-save mr-2"></i>
                            Save
                        @endif
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        @if($this->mobile_changed)
                            Sending...
                        @else
                            Saving...
                        @endif
                    </span>
                </button>
                
                <button 
                    type="button"
                    wire:click="cancelEdit"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>
            </div>
        </form>
    @endif
    
    @if($verification_sent)
        <div class="space-y-4">
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-green-400 mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="text-sm font-medium text-green-800 dark:text-green-200">
                            Verification Code Sent
                        </h4>
                        <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                            A 4-digit verification code has been sent to: <strong>{{ $country_code }}{{ $mobile }}</strong>
                            <br>
                            <em class="text-xs">Check application logs for the verification code.</em>
                        </p>
                    </div>
                </div>
            </div>
            
            <form wire:submit="verifyCode" class="space-y-4">
                <div>
                    <label for="verification_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Verification Code
                    </label>
                    <input 
                        type="text" 
                        id="verification_code"
                        wire:model="verification_code"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('verification_code') border-red-500 @enderror"
                        placeholder="Enter 4-digit code"
                        maxlength="4"
                        required
                    >
                    @error('verification_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            <i class="fas fa-check mr-2"></i>
                            Verify Code
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Verifying...
                        </span>
                    </button>
                    
                    <button 
                        type="button"
                        wire:click="resendVerification"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="resendVerification">
                            <i class="fas fa-redo mr-2"></i>
                            Resend Code
                        </span>
                        <span wire:loading wire:target="resendVerification">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Sending...
                        </span>
                    </button>
                    
                    <button 
                        type="button"
                        wire:click="cancelVerification"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    @if($is_verified)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
            <div class="flex">
                <i class="fas fa-check-circle text-blue-400 mr-3 mt-0.5"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Mobile Verified Successfully!
                    </h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                        Your mobile number <strong>{{ $country_code }}{{ $mobile }}</strong> has been verified and updated.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>