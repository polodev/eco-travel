<?php

use Livewire\Volt\Component;
use Modules\Booking\Models\Booking;

new class extends Component {
    public Booking $booking;
    public bool $showModal = false;
    public $discount_type = 'fixed'; // 'fixed' or 'percentage'
    public $discount_value = '';
    public $discount_reason = '';

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
        $this->setCurrentDiscount();
    }

    protected $listeners = ['paymentUpdated' => 'refreshBooking'];

    public function refreshBooking()
    {
        $this->booking->refresh();
    }

    public function setCurrentDiscount()
    {
        if ($this->booking->discount > 0) {
            $this->discount_value = $this->booking->discount;
            // Try to determine if it's a percentage or fixed amount
            $percentageDiscount = ($this->booking->discount / $this->booking->total_amount) * 100;
            if ($percentageDiscount == round($percentageDiscount) && $percentageDiscount <= 100) {
                $this->discount_type = 'percentage';
                $this->discount_value = round($percentageDiscount);
            } else {
                $this->discount_type = 'fixed';
                $this->discount_value = $this->booking->discount;
            }
        }
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->setCurrentDiscount();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['discount_value', 'discount_reason']);
        $this->discount_type = 'fixed';
    }

    public function calculateDiscount()
    {
        if (!$this->discount_value) return 0;

        if ($this->discount_type === 'percentage') {
            return ($this->booking->total_amount * $this->discount_value) / 100;
        } else {
            return (float) $this->discount_value;
        }
    }

    public function getPreviewNetReceivable()
    {
        $calculatedDiscount = $this->calculateDiscount();
        return $this->booking->total_amount - $calculatedDiscount;
    }

    public function applyDiscount()
    {
        $this->validate([
            'discount_value' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_reason' => 'nullable|string|max:255'
        ]);

        $calculatedDiscount = $this->calculateDiscount();

        // Validate discount doesn't exceed total amount
        if ($calculatedDiscount > $this->booking->total_amount) {
            $this->addError('discount_value', 'Discount cannot exceed the total amount.');
            return;
        }

        // Validate percentage doesn't exceed 100%
        if ($this->discount_type === 'percentage' && $this->discount_value > 100) {
            $this->addError('discount_value', 'Percentage discount cannot exceed 100%.');
            return;
        }

        // Update booking
        $this->booking->update([
            'discount' => $calculatedDiscount,
            'net_receivable_amount' => $this->booking->total_amount - $calculatedDiscount,
            'notes' => $this->discount_reason ? 
                ($this->booking->notes ? $this->booking->notes . "\n\nDiscount Applied: " . $this->discount_reason : "Discount Applied: " . $this->discount_reason) :
                $this->booking->notes
        ]);

        $this->booking->refresh();
        $this->closeModal();
        session()->flash('message', 'Discount applied successfully.');
        $this->dispatch('discountUpdated');
    }

    public function removeDiscount()
    {
        $this->booking->update([
            'discount' => 0,
            'net_receivable_amount' => $this->booking->total_amount
        ]);

        $this->booking->refresh();
        session()->flash('message', 'Discount removed successfully.');
        $this->dispatch('discountUpdated');
    }

    public function getDiscountPercentage()
    {
        if ($this->booking->total_amount > 0) {
            return round(($this->booking->discount / $this->booking->total_amount) * 100, 2);
        }
        return 0;
    }
}; ?>

<div>
    <!-- Discount Information Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Discount Information</h3>
                @hasAnyRole(['admin', 'developer'])
                <div class="flex space-x-2">
                    @if($booking->discount > 0)
                        <button wire:click="removeDiscount" 
                                wire:confirm="Are you sure you want to remove the discount?"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove Discount
                        </button>
                    @endif
                    <button wire:click="openModal" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ $booking->discount > 0 ? 'Update Discount' : 'Apply Discount' }}
                    </button>
                </div>
                @endhasAnyRole
            </div>

            <!-- Discount Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Amount</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-gray-100">৳{{ number_format($booking->total_amount, 2) }}</div>
                </div>
                
                <div class="bg-{{ $booking->discount > 0 ? 'red' : 'gray' }}-50 dark:bg-{{ $booking->discount > 0 ? 'red' : 'gray' }}-900 p-4 rounded-lg">
                    <div class="text-sm font-medium text-{{ $booking->discount > 0 ? 'red' : 'gray' }}-700 dark:text-{{ $booking->discount > 0 ? 'red' : 'gray' }}-300">
                        Discount 
                        @if($booking->discount > 0)
                            ({{ $this->getDiscountPercentage() }}%)
                        @endif
                    </div>
                    <div class="text-xl font-bold text-{{ $booking->discount > 0 ? 'red' : 'gray' }}-800 dark:text-{{ $booking->discount > 0 ? 'red' : 'gray' }}-100">
                        @if($booking->discount > 0)
                            -৳{{ number_format($booking->discount, 2) }}
                        @else
                            ৳0.00
                        @endif
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-700 p-4 rounded-lg">
                    <div class="text-sm font-medium text-blue-600 dark:text-blue-400">Net Receivable</div>
                    <div class="text-xl font-bold text-blue-900 dark:text-blue-100">৳{{ number_format($booking->net_receivable_amount, 2) }}</div>
                </div>

                <div class="bg-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-50 dark:bg-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-900 p-4 rounded-lg">
                    <div class="text-sm font-medium text-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-700 dark:text-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-300">Payment Status</div>
                    <div class="text-sm font-bold text-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-800 dark:text-{{ $booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount') ? 'green' : 'orange' }}-100">
                        @if($booking->net_receivable_amount == $booking->payments->where('status', 'completed')->sum('amount'))
                            Fully Paid
                        @else
                            ৳{{ number_format($booking->net_receivable_amount - $booking->payments->where('status', 'completed')->sum('amount'), 2) }} Due
                        @endif
                    </div>
                </div>
            </div>

            @if($booking->discount > 0)
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-sm text-blue-800 dark:text-blue-200">
                        <strong>Discount Applied:</strong> 
                        @if($this->getDiscountPercentage() == round($this->getDiscountPercentage()))
                            {{ $this->getDiscountPercentage() }}% discount
                        @else
                            Fixed discount of ৳{{ number_format($booking->discount, 2) }}
                        @endif
                        applied to the total amount.
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Discount Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" wire:ignore.self>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white/70 dark:bg-gray-800/80 backdrop-blur-md rounded-lg px-6 pt-6 pb-6 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full sm:p-8 border border-gray-200/50 dark:border-gray-700/50">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                                {{ $booking->discount > 0 ? 'Update Discount' : 'Apply Discount' }}
                            </h3>
                            
                            <form wire:submit="applyDiscount" class="space-y-4">
                                <!-- Discount Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount Type</label>
                                    <div class="flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="discount_type" value="fixed" class="form-radio h-4 w-4 text-blue-600">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Fixed Amount (৳)</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" wire:model.live="discount_type" value="percentage" class="form-radio h-4 w-4 text-blue-600">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Percentage (%)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div>
                                    <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        @if($discount_type === 'percentage')
                                            Discount Percentage (%)
                                        @else
                                            Discount Amount (৳)
                                        @endif
                                    </label>
                                    <input type="number" wire:model.live="discount_value" id="discount_value" 
                                           step="{{ $discount_type === 'percentage' ? '0.1' : '0.01' }}" 
                                           min="0" 
                                           max="{{ $discount_type === 'percentage' ? '100' : $booking->total_amount }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('discount_value') border-red-500 @enderror">
                                    @error('discount_value')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Discount Reason -->
                                <div>
                                    <label for="discount_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Discount (Optional)</label>
                                    <input type="text" wire:model="discount_reason" id="discount_reason" 
                                           placeholder="e.g., Early bird discount, Loyalty customer, Promotional offer"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('discount_reason') border-red-500 @enderror">
                                    @error('discount_reason')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Preview -->
                                @if($discount_value)
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview</h4>
                                        <div class="space-y-1 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Total Amount:</span>
                                                <span class="font-medium">৳{{ number_format($booking->total_amount, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    Discount ({{ $discount_type === 'percentage' ? $discount_value . '%' : '৳' . number_format($discount_value, 2) }}):
                                                </span>
                                                <span class="font-medium text-red-600">-৳{{ number_format($this->calculateDiscount(), 2) }}</span>
                                            </div>
                                            <div class="flex justify-between border-t pt-1">
                                                <span class="text-gray-700 dark:text-gray-300 font-medium">Net Receivable:</span>
                                                <span class="font-bold text-blue-600">৳{{ number_format($this->getPreviewNetReceivable(), 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Form Actions -->
                                <div class="flex justify-end space-x-3 pt-4">
                                    <button type="button" wire:click="closeModal"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $booking->discount > 0 ? 'Update Discount' : 'Apply Discount' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Success Message -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg">
            {{ session('message') }}
        </div>
    @endif
</div>