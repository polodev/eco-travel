<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Flight Bookings Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        @if($booking)
                            Flight bookings for {{ $booking->booking_reference }}
                        @else
                            Manage all flight bookings and ticket status
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($booking)
                        <a href="{{ route('admin-dashboard.booking.bookings.show', $booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            Back to Booking
                        </a>
                    @endif
                    <button type="button" id="toggle-filters" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Toggle Filters
                    </button>
                    <button type="button" id="clear-filters" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div id="filters-section" class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Trip Type Filter -->
                <div>
                    <label for="trip_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trip Type</label>
                    <select id="trip_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">All Types</option>
                        <option value="oneway">One Way</option>
                        <option value="roundtrip">Round Trip</option>
                    </select>
                </div>

                <!-- Cabin Class Filter -->
                <div>
                    <label for="cabin_class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cabin Class</label>
                    <select id="cabin_class" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">All Classes</option>
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first">First Class</option>
                    </select>
                </div>

                <!-- Ticket Status Filter -->
                <div>
                    <label for="ticket_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ticket Status</label>
                    <select id="ticket_status" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="issued">Issued</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>

                <!-- Airline Filter -->
                <div>
                    <label for="airline_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Airline</label>
                    <input type="text" id="airline_code" placeholder="e.g., BG, US, EK" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Route Filter -->
                <div>
                    <label for="route" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Route</label>
                    <input type="text" id="route" placeholder="e.g., DAC-DXB" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Departure Date From -->
                <div>
                    <label for="departure_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Departure From</label>
                    <input type="date" id="departure_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Departure Date To -->
                <div>
                    <label for="departure_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Departure To</label>
                    <input type="date" id="departure_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Amount Range -->
                <div>
                    <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount (৳)</label>
                    <input type="number" id="amount_min" placeholder="0" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <div>
                    <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount (৳)</label>
                    <input type="number" id="amount_max" placeholder="500000" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Quick Search -->
                <div class="md:col-span-2">
                    <label for="quick_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                    <input type="text" id="quick_search" placeholder="Search by PNR, ticket number, flight number, booking reference..." class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
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
                <table id="flight-bookings-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- DataTables will populate this -->
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle filters
            $('#toggle-filters').click(function() {
                $('#filters-section').toggleClass('hidden');
                $(this).find('svg').toggleClass('rotate-180');
            });

            // Clear filters
            $('#clear-filters').click(function() {
                $('#filters-section input, #filters-section select').val('');
                table.draw();
            });

            // Initialize DataTable
            const table = $('#flight-bookings-table').DataTable({
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
                    url: '{{ route('admin-dashboard.booking.booking-flights.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        @if($booking)
                            d.booking_id = {{ $booking->id }};
                        @endif
                        d.trip_type = $('#trip_type').val();
                        d.cabin_class = $('#cabin_class').val();
                        d.ticket_status = $('#ticket_status').val();
                        d.airline_code = $('#airline_code').val();
                        d.route = $('#route').val();
                        d.departure_date_from = $('#departure_date_from').val();
                        d.departure_date_to = $('#departure_date_to').val();
                        d.amount_min = $('#amount_min').val();
                        d.amount_max = $('#amount_max').val();
                        d.quick_search = $('#quick_search').val();
                    }
                },
                columns: [
                    {data: 'booking_info', name: 'booking.booking_reference', title: 'Booking', searchable: true, orderable: true},
                    {data: 'flight_info', name: 'flight_number', title: 'Flight', searchable: true, orderable: true},
                    {data: 'trip_details', name: 'cabin_class', title: 'Trip Details', searchable: false, orderable: true},
                    {data: 'departure_info', name: 'departure_datetime', title: 'Departure', searchable: false, orderable: true},
                    {data: 'arrival_info', name: 'arrival_datetime', title: 'Arrival', searchable: false, orderable: true},
                    {data: 'passengers_info', name: 'adults', title: 'Passengers', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'amount_info', name: 'total_amount', title: 'Amount', searchable: false, orderable: true, className: 'text-right'},
                    {data: 'ticket_info', name: 'ticket_status', title: 'Ticket Status', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'actions', name: 'actions', title: 'Actions', searchable: false, orderable: false, className: 'text-center w-32'}
                ],
                order: [[3, 'desc']], // Order by departure_datetime desc
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading flight bookings...</div>',
                    lengthMenu: "Show _MENU_ flights per page",
                    zeroRecords: "No flight bookings found matching your criteria",
                    info: "Showing _START_ to _END_ of _TOTAL_ flight bookings",
                    infoEmpty: "Showing 0 to 0 of 0 flight bookings",
                    infoFiltered: "(filtered from _MAX_ total flight bookings)",
                    search: "Search flights:",
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
                    $('#flight-bookings-table_wrapper .dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100');
                    $('#flight-bookings-table_wrapper .dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100');
                    $('#flight-bookings-table_wrapper .dataTables_paginate .paginate_button').addClass('px-3 py-1 mx-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-600');
                    $('#flight-bookings-table_wrapper .dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600');

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
            $('#trip_type, #cabin_class, #ticket_status, #airline_code, #route, #departure_date_from, #departure_date_to, #amount_min, #amount_max').change(function() {
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