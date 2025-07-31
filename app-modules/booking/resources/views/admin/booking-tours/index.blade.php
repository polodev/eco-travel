<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tour Bookings Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        @if($booking)
                            Tour bookings for {{ $booking->booking_reference }}
                        @else
                            Manage all tour bookings and itineraries
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
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Accommodation Type Filter -->
                <div>
                    <label for="accommodation_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Accommodation Type</label>
                    <select id="accommodation_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="shared">Shared</option>
                        <option value="single">Single</option>
                        <option value="twin">Twin</option>
                        <option value="double">Double</option>
                    </select>
                </div>

                <!-- Tour Filter -->
                <div>
                    <label for="tour_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tour ID</label>
                    <input type="number" id="tour_id" placeholder="Enter tour ID" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Duration Range -->
                <div>
                    <label for="duration_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Duration (Days)</label>
                    <input type="number" id="duration_min" placeholder="1" min="1" max="365" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="duration_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Duration (Days)</label>
                    <input type="number" id="duration_max" placeholder="30" min="1" max="365" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Tour Start Date Range -->
                <div>
                    <label for="tour_start_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tour Start From</label>
                    <input type="date" id="tour_start_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="tour_start_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tour Start To</label>
                    <input type="date" id="tour_start_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Tour End Date Range -->
                <div>
                    <label for="tour_end_date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tour End From</label>
                    <input type="date" id="tour_end_date_from" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="tour_end_date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tour End To</label>
                    <input type="date" id="tour_end_date_to" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Amount Range -->
                <div>
                    <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount (৳)</label>
                    <input type="number" id="amount_min" placeholder="0" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount (৳)</label>
                    <input type="number" id="amount_max" placeholder="500000" min="0" step="1000" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Quick Search -->
                <div class="md:col-span-2">
                    <label for="quick_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                    <input type="text" id="quick_search" placeholder="Search by voucher, guide, tour name, booking reference..." class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                <table id="tour-bookings-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
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
            const table = $('#tour-bookings-table').DataTable({
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
                    url: '{{ route('admin-dashboard.booking.booking-tours.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        @if($booking)
                            d.booking_id = {{ $booking->id }};
                        @endif
                        d.booking_status = $('#booking_status').val();
                        d.accommodation_type = $('#accommodation_type').val();
                        d.tour_id = $('#tour_id').val();
                        d.duration_min = $('#duration_min').val();
                        d.duration_max = $('#duration_max').val();
                        d.tour_start_date_from = $('#tour_start_date_from').val();
                        d.tour_start_date_to = $('#tour_start_date_to').val();
                        d.tour_end_date_from = $('#tour_end_date_from').val();
                        d.tour_end_date_to = $('#tour_end_date_to').val();
                        d.amount_min = $('#amount_min').val();
                        d.amount_max = $('#amount_max').val();
                        d.quick_search = $('#quick_search').val();
                    }
                },
                columns: [
                    {data: 'booking_info', name: 'booking.booking_reference', title: 'Booking', searchable: true, orderable: true},
                    {data: 'tour_info', name: 'tour.name', title: 'Tour', searchable: true, orderable: true},
                    {data: 'tour_details', name: 'tour_start_date', title: 'Tour Details', searchable: false, orderable: true},
                    {data: 'tour_start_info', name: 'tour_start_date', title: 'Start Date', searchable: false, orderable: true},
                    {data: 'tour_end_info', name: 'tour_end_date', title: 'End Date', searchable: false, orderable: true},
                    {data: 'participants_info', name: 'adults', title: 'Participants', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'amount_info', name: 'total_amount', title: 'Amount', searchable: false, orderable: true, className: 'text-right'},
                    {data: 'booking_info_status', name: 'booking_status', title: 'Status', searchable: false, orderable: true, className: 'text-center'},
                    {data: 'actions', name: 'actions', title: 'Actions', searchable: false, orderable: false, className: 'text-center w-32'}
                ],
                order: [[3, 'desc']], // Order by tour_start_date desc
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading tour bookings...</div>',
                    lengthMenu: "Show _MENU_ tours per page",
                    zeroRecords: "No tour bookings found matching your criteria",
                    info: "Showing _START_ to _END_ of _TOTAL_ tour bookings",
                    infoEmpty: "Showing 0 to 0 of 0 tour bookings",
                    infoFiltered: "(filtered from _MAX_ total tour bookings)",
                    search: "Search tours:",
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
                    $('#tour-bookings-table_wrapper .dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100');
                    $('#tour-bookings-table_wrapper .dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100');
                    $('#tour-bookings-table_wrapper .dataTables_paginate .paginate_button').addClass('px-3 py-1 mx-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-600');
                    $('#tour-bookings-table_wrapper .dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600');

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
            $('#booking_status, #accommodation_type, #tour_id, #duration_min, #duration_max, #tour_start_date_from, #tour_start_date_to, #tour_end_date_from, #tour_end_date_to, #amount_min, #amount_max').change(function() {
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