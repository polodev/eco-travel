<?php

use Livewire\Volt\Component;
use Modules\Payment\Models\CustomPayment;
use Modules\Payment\Models\Payment;

new class extends Component {
    public CustomPayment $customPayment;
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?Payment $editingPayment = null;
    
    // Form fields
    public $amount = '';
    public $payment_method = '';
    public $status = 'pending';
    public $payment_date = '';
    public $transaction_id = '';
    public $bank_name = '';
    public $notes = '';
    public $receipt_number = '';

    public function mount(CustomPayment $customPayment)
    {
        $this->customPayment = $customPayment->load('payments');
        $this->calculateRemainingAmount();
    }

    public function calculateRemainingAmount()
    {
        if (!$this->isEditing) {
            $totalPaid = $this->customPayment->payments->sum('amount');
            $remaining = $this->customPayment->amount - $totalPaid;
            
            // If overpaid (negative remaining), show 0. If underpaid, show the remaining amount
            if ($remaining <= 0) {
                $this->amount = '0.00';
            } else {
                $this->amount = number_format($remaining, 2, '.', '');
            }
        }
    }

    public function openAddModal()
    {
        $this->reset(['payment_method', 'status', 'payment_date', 'transaction_id', 'bank_name', 'notes', 'receipt_number']);
        $this->status = 'pending';
        $this->payment_method = 'sslcommerz'; // Set SSL Commerz as default
        $this->editingPayment = null;
        $this->isEditing = false;
        $this->calculateRemainingAmount();
        $this->showModal = true;
    }

    public function openEditModal($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $this->editingPayment = $payment;
        $this->isEditing = true;
        $this->amount = $payment->amount;
        $this->payment_method = $payment->payment_method;
        $this->status = $payment->status;
        $this->payment_date = $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '';
        $this->transaction_id = $payment->transaction_id ?? '';
        $this->bank_name = $payment->bank_name ?? '';
        $this->notes = $payment->notes ?? '';
        $this->receipt_number = $payment->receipt_number ?? '';
        $this->showModal = true;
    }

    public function savePayment()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:' . implode(',', array_keys(Payment::getAvailablePaymentMethods())),
            'status' => 'required|in:' . implode(',', array_keys(Payment::getAvailableStatuses())),
            'payment_date' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'receipt_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $data = [
            'custom_payment_id' => $this->customPayment->id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'payment_date' => $this->payment_date ?: now(),
            'transaction_id' => $this->transaction_id,
            'bank_name' => $this->bank_name,
            'receipt_number' => $this->receipt_number,
            'notes' => $this->notes,
        ];

        if ($this->isEditing && $this->editingPayment) {
            $this->editingPayment->update($data);
            session()->flash('message', 'Payment updated successfully.');
        } else {
            Payment::create($data);
            session()->flash('message', 'Payment added successfully.');
        }

        $this->customPayment->refresh();
        $this->closeModal();
        $this->dispatch('paymentUpdated');
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['amount', 'payment_method', 'status', 'payment_date', 'transaction_id', 'bank_name', 'notes', 'receipt_number']);
        $this->status = 'pending';
        $this->editingPayment = null;
        $this->isEditing = false;
    }

    public function getTotalPaidAmount()
    {
        return $this->customPayment->payments->where('status', 'completed')->sum('amount');
    }

    public function getRemainingAmount()
    {
        return $this->customPayment->amount - $this->getTotalPaidAmount();
    }
}; ?>

<div>
    <!-- Payment Management Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Payment Management</h3>
                <button wire:click="openAddModal" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Payment
                </button>
            </div>

            <!-- Payment Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <div class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Amount</div>
                    <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $customPayment->formatted_amount }}</div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Total Paid</div>
                    <div class="text-2xl font-bold text-green-900 dark:text-green-100">৳{{ number_format($this->getTotalPaidAmount(), 2) }}</div>
                </div>
                <div class="bg-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-50 dark:bg-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-900/20 p-4 rounded-lg">
                    <div class="text-sm font-medium text-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-600 dark:text-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-400">Remaining</div>
                    <div class="text-2xl font-bold text-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-900 dark:text-{{ $this->getRemainingAmount() > 0 ? 'red' : 'gray' }}-100">৳{{ number_format($this->getRemainingAmount(), 2) }}</div>
                </div>
            </div>

            <!-- Payment Records -->
            @if($customPayment->payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($customPayment->payments as $payment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <!-- Actions Column (First) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3 justify-center">
                                            <!-- Edit Button -->
                                            <button wire:click="openEditModal({{ $payment->id }})" 
                                                    title="Edit Payment"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-full transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            
                                            <!-- View Button -->
                                            <a href="{{ route('payment::admin.payments.show', $payment->id) }}" 
                                               title="View Payment Details"
                                               class="inline-flex items-center justify-center w-8 h-8 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-full transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    <!-- Amount Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        ৳{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <!-- Method Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {!! $payment->payment_method_badge !!}
                                    </td>
                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {!! $payment->status_badge !!}
                                    </td>
                                    <!-- Date Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $payment->payment_date ? $payment->payment_date->format('M j, Y') : 'Pending' }}
                                    </td>
                                    <!-- Transaction ID Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600 dark:text-gray-400">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No payments</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a payment record.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" wire:ignore.self>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white/70 dark:bg-gray-800/80 backdrop-blur-md rounded-lg px-6 pt-6 pb-6 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full sm:p-8 border border-gray-200/50 dark:border-gray-700/50">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                                {{ $isEditing ? 'Edit Payment' : 'Add Payment' }}
                            </h3>
                            
                            <form wire:submit="savePayment" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (৳)</label>
                                    <input type="number" wire:model="amount" id="amount" name="amount" step="0.01" min="0.01"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-500 @enderror">
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                                    <select wire:model="payment_method" id="payment_method" name="payment_method"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('payment_method') border-red-500 @enderror">
                                        <option value="">Select Payment Method</option>
                                        @foreach(\Modules\Payment\Models\Payment::getAvailablePaymentMethods() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select wire:model="status" id="status" name="status"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                        @foreach(\Modules\Payment\Models\Payment::getAvailableStatuses() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Date -->
                                <div>
                                    <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Date</label>
                                    <input type="date" wire:model="payment_date" id="payment_date" name="payment_date"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('payment_date') border-red-500 @enderror">
                                    @error('payment_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Transaction ID -->
                                <div>
                                    <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction ID</label>
                                    <input type="text" wire:model="transaction_id" id="transaction_id" name="transaction_id"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('transaction_id') border-red-500 @enderror">
                                    @error('transaction_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bank Name -->
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name (for Bank Transfers)</label>
                                    <input type="text" wire:model="bank_name" id="bank_name" name="bank_name"
                                           placeholder="Enter bank name (e.g., Dutch Bangla Bank, BRAC Bank)"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('bank_name') border-red-500 @enderror">
                                    @error('bank_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Receipt Number -->
                                <div>
                                    <label for="receipt_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Receipt Number</label>
                                    <input type="text" wire:model="receipt_number" id="receipt_number" name="receipt_number"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('receipt_number') border-red-500 @enderror">
                                    @error('receipt_number')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                </div>

                                <!-- Notes (full width) -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                    <textarea wire:model="notes" id="notes" name="notes" rows="3"
                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"></textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

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
                                        {{ $isEditing ? 'Update Payment' : 'Add Payment' }}
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