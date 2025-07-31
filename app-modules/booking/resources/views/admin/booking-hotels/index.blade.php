<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Hotel Bookings Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        @if($booking)
                            Hotel bookings for {{ $booking->booking_reference }}
                        @else
                            Manage all hotel bookings and reservations
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($booking)
                        <a href="{{ route('admin-dashboard.booking.bookings.show', $booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Back to Booking
                        </a>
                    @endif
                    <button type="button" id="clear-filters" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div id="filters-section" class="p-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Booking Status Filter -->
                <div>
                    <label for="booking_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Booking Status</label>
                    <select id="booking_status" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                        <option value="no_show">No Show</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Rate Plan Filter -->
                <div>
                    <label for="rate_plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rate Plan</label>
                    <select id="rate_plan" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Plans</option>
                        <option value="room_only">Room Only</option>
                        <option value="breakfast_included">Breakfast Included</option>
                        <option value="half_board">Half Board</option>
                        <option value="full_board">Full Board</option>
                        <option value="all_inclusive">All Inclusive</option>
                    </select>
                </div>

                <!-- Hotel Filter -->
                <div>
                    <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hotel ID</label>
                    <input type="number" id="hotel_id" placeholder="Enter hotel ID" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Nights Range -->
                <div>
                    <label for="nights_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Nights</label>
                    <input type="number" id="nights_min" placeholder="1" min="1" max="365" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="nights_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Nights</label>
                    <input type="number" id="nights_max" placeholder="30" min="1" max="365" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Check-in Date Range -->
                <div>
                    <label for="checkin_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-in From</label>
                    <input type="date" id="checkin_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="checkin_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-in To</label>
                    <input type="date" id="checkin_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Check-out Date Range -->
                <div>
                    <label for="checkout_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-out From</label>
                    <input type="date" id="checkout_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="checkout_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-out To</label>
                    <input type="date" id="checkout_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Amount Range -->
                <div>
                    <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount (৳)</label>
                    <input type="number" id="amount_min" placeholder="0" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount (৳)</label>
                    <input type="number" id="amount_max" placeholder="100000" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Quick Search -->
                <div class="md:col-span-2">
                    <label for="quick_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                    <input type="text" id="quick_search" placeholder="Search by confirmation number, hotel name, booking reference..." class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                <table id="hotel-bookings-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- DataTables will populate this -->
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Clear filters
            $('#clear-filters').click(function() {
                $('#filters-section input, #filters-section select').val('');
                table.draw();
            });

            // Initialize DataTable
            const table = $('#hotel-bookings-table').DataTable({
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
                    url: '{{ route('admin-dashboard.booking.booking-hotels.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        @if($booking)
                            d.booking_id = {{ $booking->id }};
                        @endif
                        d.booking_status = $('#booking_status').val();
                        d.rate_plan = $('#rate_plan').val();
                        d.hotel_id = $('#hotel_id').val();
                        d.nights_min = $('#nights_min').val();
                        d.nights_max = $('#nights_max').val();
                        d.checkin_date_from = $('#checkin_date_from').val();
                        d.checkin_date_to = $('#checkin_date_to').val();
                        d.checkout_date_from = $('#checkout_date_from').val();
                        d.checkout_date_to = $('#checkout_date_to').val();
                        d.amount_min = $('#amount_min').val();
                        d.amount_max = $('#amount_max').val();
                        d.quick_search = $('#quick_search').val();
                    }
                },
                columns: [
                    {data: 'booking_info', name: 'booking.booking_reference', title: 'Booking', searchable: true, orderable: true},
                    {data: 'hotel_info', name: 'hotel.name', title: 'Hotel', searchable: true, orderable: true},
                    {data: 'stay_details', name: 'nights', title: 'Stay Details', searchable: false, orderable: true},
                    {data: 'checkin_info', name: 'checkin_date', title: 'Check-in', searchable: false, orderable: true},
                    {data: 'checkout_info', name: 'checkout_date', title: 'Check-out', searchable: false, orderable: true},
                    {data: 'guests_info', name: 'adults', title: 'Guests', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'amount_info', name: 'total_amount', title: 'Amount', searchable: false, orderable: true, className: 'text-right'},
                    {data: 'booking_info_status', name: 'booking_status', title: 'Status', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'actions', name: 'actions', title: 'Actions', searchable: false, orderable: false, className: 'text-center w-32'}
                ],
                order: [[3, 'desc']], // Order by checkin_date desc
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading hotel bookings...</div>',
                    lengthMenu: "Show _MENU_ hotels per page",
                    zeroRecords: "No hotel bookings found matching your criteria",
                    info: "Showing _START_ to _END_ of _TOTAL_ hotel bookings",
                    infoEmpty: "Showing 0 to 0 of 0 hotel bookings",
                    infoFiltered: "(filtered from _MAX_ total hotel bookings)",
                    search: "Search hotels:",
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
                    $('#hotel-bookings-table_wrapper .dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100');
                    $('#hotel-bookings-table_wrapper .dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100');
                    $('#hotel-bookings-table_wrapper .dataTables_paginate .paginate_button').addClass('px-3 py-1 mx-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-600');
                    $('#hotel-bookings-table_wrapper .dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600');

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
            $('#booking_status, #rate_plan, #hotel_id, #nights_min, #nights_max, #checkin_date_from, #checkin_date_to, #checkout_date_from, #checkout_date_to, #amount_min, #amount_max').change(function() {
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
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>