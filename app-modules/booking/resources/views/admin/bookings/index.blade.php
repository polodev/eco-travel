<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Booking Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage all booking records and track payment status</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" id="clear-filters" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                    <a href="{{ route('admin-dashboard.booking.bookings.create') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div id="filters-section" class="p-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Booking Type Filter -->
                <div>
                    <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Type</label>
                    <select id="booking_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($bookingTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="status" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Status</label>
                    <select id="payment_status" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Payment Status</option>
                        <option value="pending">Pending</option>
                        <option value="partial">Partially Paid</option>
                        <option value="paid">Fully Paid</option>
                    </select>
                </div>

                <!-- User Filter -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                    <select id="user_id" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 select2-single">
                        <option value="">All Customers</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Booking Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Date From</label>
                    <input type="date" id="date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Booking Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Date To</label>
                    <input type="date" id="date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Travel Date From -->
                <div>
                    <label for="travel_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Travel Date From</label>
                    <input type="date" id="travel_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Travel Date To -->
                <div>
                    <label for="travel_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Travel Date To</label>
                    <input type="date" id="travel_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Amount Range -->
                <div>
                    <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount (৳)</label>
                    <input type="number" id="amount_min" placeholder="0" min="0" step="100" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount (৳)</label>
                    <input type="number" id="amount_max" placeholder="1000000" min="0" step="100" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Quick Search -->
                <div class="md:col-span-2">
                    <label for="quick_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                    <input type="text" id="quick_search" placeholder="Search by booking reference, customer name, email..." class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-sm">
                    <div class="text-blue-700 dark:text-blue-300">
                        <span class="font-medium">Total Records:</span>
                        <span id="total-records">Loading...</span>
                    </div>
                    <div class="text-blue-700 dark:text-blue-300">
                        <span class="font-medium">Filtered:</span>
                        <span id="filtered-records">Loading...</span>
                    </div>
                </div>
                <div class="text-xs text-blue-600 dark:text-blue-400">
                    Last updated: <span id="last-updated">{{ now()->format('M j, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table id="bookings-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- DataTables will populate this -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-single').select2({
                theme: 'default',
                width: '100%',
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: false
            });

            // Clear filters
            $('#clear-filters').click(function() {
                $('#filters-section input, #filters-section select').val('');
                $('.select2-single').val(null).trigger('change');
                table.draw();
            });

            // Initialize DataTable
            const table = $('#bookings-table').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                ajax: {
                    url: '{{ route('admin-dashboard.booking.bookings.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.booking_type = $('#booking_type').val();
                        d.status = $('#status').val();
                        d.payment_status = $('#payment_status').val();
                        d.user_id = $('#user_id').val();
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.travel_date_from = $('#travel_date_from').val();
                        d.travel_date_to = $('#travel_date_to').val();
                        d.amount_min = $('#amount_min').val();
                        d.amount_max = $('#amount_max').val();
                        d.quick_search = $('#quick_search').val();
                    }
                },
                columns: [
                    {
                        data: 'booking_details', 
                        name: 'booking_reference', 
                        title: '<div class="px-2 py-1">Booking<br><span class="text-xs font-normal text-gray-500">Reference & Type</span></div>', 
                        searchable: true, 
                        orderable: true,
                        width: '140px',
                        className: 'px-4 py-3'
                    },
                    {
                        data: 'customer_info', 
                        name: 'customer_details', 
                        title: '<div class="px-2 py-1">Customer<br><span class="text-xs font-normal text-gray-500">Name & Email</span></div>', 
                        searchable: false, 
                        orderable: false,
                        width: '160px',
                        className: 'px-4 py-3'
                    },
                    {
                        data: 'user_info', 
                        name: 'user.name', 
                        title: '<div class="px-2 py-1">User Account<br><span class="text-xs font-normal text-gray-500">System User</span></div>', 
                        searchable: true, 
                        orderable: true,
                        width: '140px',
                        className: 'px-4 py-3'
                    },
                    {
                        data: 'travel_info', 
                        name: 'travel_date', 
                        title: '<div class="px-2 py-1">Travel<br><span class="text-xs font-normal text-gray-500">Start & End</span></div>', 
                        searchable: false, 
                        orderable: true,
                        width: '120px',
                        className: 'px-4 py-3'
                    },
                    {
                        data: 'passengers_info', 
                        name: 'adults', 
                        title: '<div class="px-2 py-1 text-center">Passengers<br><span class="text-xs font-normal text-gray-500">Adults, Children</span></div>', 
                        searchable: false, 
                        orderable: true,
                        width: '110px',
                        className: 'px-4 py-3 text-center'
                    },
                    {
                        data: 'amount_info', 
                        name: 'total_amount', 
                        title: '<div class="px-2 py-1 text-right">Amount<br><span class="text-xs font-normal text-gray-500">Total & Net</span></div>', 
                        searchable: false, 
                        orderable: true,
                        width: '130px',
                        className: 'px-4 py-3 text-right'
                    },
                    {
                        data: 'payment_info', 
                        name: 'payments', 
                        title: '<div class="px-2 py-1 text-right">Payment<br><span class="text-xs font-normal text-gray-500">Paid & Due</span></div>', 
                        searchable: false, 
                        orderable: false,
                        width: '130px',
                        className: 'px-4 py-3 text-right'
                    },
                    {
                        data: 'status', 
                        name: 'status', 
                        title: '<div class="px-2 py-1 text-center">Status<br><span class="text-xs font-normal text-gray-500">Booking</span></div>', 
                        searchable: false, 
                        orderable: true,
                        width: '90px',
                        className: 'px-4 py-3 text-center'
                    },
                    {
                        data: 'dates', 
                        name: 'booking_date', 
                        title: '<div class="px-2 py-1">Dates<br><span class="text-xs font-normal text-gray-500">Booked & Confirmed</span></div>', 
                        searchable: false, 
                        orderable: true,
                        width: '130px',
                        className: 'px-4 py-3'
                    },
                    {
                        data: 'actions', 
                        name: 'actions', 
                        title: '<div class="px-2 py-1 text-center">Actions<br><span class="text-xs font-normal text-gray-500">View & Edit</span></div>', 
                        searchable: false, 
                        orderable: false,
                        width: '120px',
                        className: 'px-4 py-3 text-center'
                    }
                ],
                order: [[8, 'desc']], // Order by booking_date desc
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading bookings...</div>',
                    lengthMenu: "Show _MENU_ bookings per page",
                    zeroRecords: "No bookings found matching your criteria",
                    info: "Showing _START_ to _END_ of _TOTAL_ bookings",
                    infoEmpty: "Showing 0 to 0 of 0 bookings",
                    infoFiltered: "(filtered from _MAX_ total bookings)",
                    search: "Search bookings:",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                dom: '<"flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rtip',
                drawCallback: function(settings) {
                    // Apply Tailwind classes after table draw
                    $('#bookings-table_wrapper .dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100');
                    $('#bookings-table_wrapper .dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100');
                    $('#bookings-table_wrapper .dataTables_paginate .paginate_button').addClass('px-3 py-1 mx-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-600');
                    $('#bookings-table_wrapper .dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600');

                    // Style table headers
                    $('#bookings-table thead th').addClass('bg-gray-50 dark:bg-gray-800 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700');
                    
                    // Style table rows
                    $('#bookings-table tbody tr').addClass('bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150');
                    $('#bookings-table tbody tr:not(:last-child)').addClass('border-b border-gray-200 dark:border-gray-700');

                    // Update info counters
                    const info = settings.json;
                    if (info) {
                        $('#total-records').text(info.recordsTotal.toLocaleString());
                        $('#filtered-records').text(info.recordsFiltered.toLocaleString());
                        $('#last-updated').text(new Date().toLocaleString());
                    }
                }
            });

            // Filter change events
            $('#booking_type, #status, #payment_status, #user_id, #date_from, #date_to, #travel_date_from, #travel_date_to, #amount_min, #amount_max').change(function() {
                table.draw();
            });

            // Quick search with debounce
            let searchTimeout;
            $('#quick_search').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    table.draw();
                }, 500);
            });

            // Delete functionality
            $(document).on('click', '.delete-booking', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const bookingRef = $(this).data('booking-ref');
                
                if (confirm(`Are you sure you want to delete booking ${bookingRef}?`)) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                table.draw();
                                alert('Booking deleted successfully.');
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the booking.');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>