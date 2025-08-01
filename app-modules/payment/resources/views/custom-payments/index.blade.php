<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Custom Payment Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage custom payment requests and submissions</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600" id="filter_area_controller">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Toggle Filters
                    </button>
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700" id="clear_all_filter_button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                    <a href="{{ route('payment::admin.custom-payments.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Custom Payment
                    </a>
                </div>
            </div>

            <!-- Filter Area -->
            <div class="hidden" id="filter_area">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Text -->
                    <div>
                        <label for="search_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" id="search_text" placeholder="Name, email, mobile, purpose..." class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="status" class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Statuses</option>
                            <option value="submitted">Submitted</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Status</label>
                        <select id="payment_status" class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Payment Status</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="partially_paid">Partially Paid</option>
                            <option value="fully_paid">Fully Paid</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table id="customPaymentsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Purpose</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Info -->
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Go to page:</span>
                    <input type="number" id="datatable-page-number" min="1" class="w-16 px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <button id="datatable-page-number-button" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Go</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let customPaymentsTable = $('#customPaymentsTable').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                ajax: {
                    url: '{{ route("payment::admin.custom-payments.json") }}',
                    type: "POST",
                    data: function(d) {
                        d.search_text = $('#search_text').val();
                        d.status = $('#status').val();
                        d.payment_status = $('#payment_status').val();
                    }
                },
                columns: [
                    { data: 'customer_info', name: 'name', orderable: true, searchable: false },
                    { data: 'purpose_info', name: 'purpose', orderable: true, searchable: false },
                    { data: 'amount_info', name: 'amount', orderable: true, searchable: false },
                    { data: 'payment_status', name: 'payment_status', orderable: false, searchable: false },
                    { data: 'status_badge', name: 'status', orderable: true, searchable: false },
                    { data: 'created_at_formatted', name: 'created_at', orderable: true, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[5, 'desc']], // Order by created_at descending
                pageLength: 25,
                responsive: true,
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...</div>',
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No custom payments found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            // Setup navigation helper
            window.dataTableNavigate(customPaymentsTable);

            // Filter functionality
            $('#filter_area_controller').click(function() {
                $('#filter_area').toggle();
            });

            $('#clear_all_filter_button').click(function() {
                $('#search_text').val('');
                $('#status').val('');
                $('#payment_status').val('');
                customPaymentsTable.ajax.reload();
            });

            // Apply filters on change
            $('#search_text, #status, #payment_status').on('keyup change', function() {
                customPaymentsTable.ajax.reload();
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>