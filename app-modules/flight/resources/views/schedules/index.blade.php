<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Flight Schedules Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage flight schedules and availability</p>
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
                    <a href="{{ route('admin-dashboard.flight.flight-schedules.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Schedule
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                    <div>
                        <label for="status_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="status_filter" id="status_filter">
                            <option value="">All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="delayed">Delayed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="departed">Departed</option>
                            <option value="arrived">Arrived</option>
                            <option value="diverted">Diverted</option>
                        </select>
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by flight number, airline...">
                    </div>
                    <div>
                        <label for="flight_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Flight</label>
                        <select name="flight_filter" id="flight_filter" 
                                class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Flights</option>
                            @foreach($flights as $flight)
                                <option value="{{ $flight->id }}">{{ $flight->airline->name }} {{ $flight->flight_number }} ({{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" 
                               class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" 
                               class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DataTable Info -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div id="datatable-info-custom" class="text-xs text-gray-600 dark:text-gray-400"></div>
        </div>
        
        <!-- DataTable Container -->
        <div class="overflow-hidden">
            <table id="schedules-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- DataTables will handle thead and tbody -->
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        const current_route_name = 'admin-dashboard.flight.flight-schedules.index';
        
        $(document).ready(function() {
            // DataTable configuration
            var schedulesTable = $('#schedules-table').DataTable({
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
                    url: '{{ route('admin-dashboard.flight.flight-schedules.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.status = $('#status_filter').val();
                        d.search_text = $('#search_text').val();
                        d.flight_id = $('#flight_filter').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    {
                        data: 'flight_info',
                        name: 'flight.flight_number',
                        title: 'Flight',
                        searchable: true,
                        className: 'font-medium min-w-48'
                    },
                    {
                        data: 'schedule_info',
                        name: 'scheduled_departure',
                        title: 'Schedule',
                        searchable: false,
                        orderable: true,
                        className: 'min-w-32'
                    },
                    {
                        data: 'pricing',
                        name: 'economy_price',
                        title: 'Pricing',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-32'
                    },
                    {
                        data: 'availability',
                        name: 'available_economy_seats',
                        title: 'Availability',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-32'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        title: 'Status',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    }
                ],
                order: [[1, 'desc']],
                language: {
                    search: "Search by flight, airline:",
                    lengthMenu: "Show _MENU_ items per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ items",
                    infoEmpty: "No flight schedules found",
                    infoFiltered: "(filtered from _MAX_ total items)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>ertip',
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#schedules-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#schedules-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#schedules-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#schedules-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#schedules-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
                    // Fix column alignment after draw
                    setTimeout(function() {
                        schedulesTable.columns.adjust();
                    }, 100);
                }
            });
            
            // Filter change listeners
            var filterElements = ['#status_filter', '#flight_filter', '#start_date', '#end_date'];
            
            filterElements.forEach(function(element) {
                $(element).change(function(e) {
                    schedulesTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    schedulesTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val('').trigger('change');
                });
                $('#search_text').val('');
                schedulesTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                $filter_area.toggle();
            });
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            schedulesTable.on('draw', function() {
                updateDataTableInfo();
            });
            
            updateDataTableInfo();
        });

        function deleteSchedule(id) {
            if (confirm('Are you sure you want to delete this flight schedule?')) {
                $.ajax({
                    url: "{{ route('admin-dashboard.flight.flight-schedules.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#schedules-table').DataTable().ajax.reload();
                            showSuccessMessage(response.message);
                        } else {
                            showErrorMessage(response.message);
                        }
                    },
                    error: function(xhr) {
                        showErrorMessage('Error deleting flight schedule.');
                    }
                });
            }
        }
    </script>
    @endpush
    
    @push('styles')
    <style>
        /* DataTables Tailwind Integration */
        .dataTables_wrapper {
            @apply text-gray-700 dark:text-gray-300;
        }
        .dataTables_length {
            @apply mb-0 flex-shrink-0;
        }
        
        .dataTables_length label {
            @apply flex items-center text-sm font-medium text-gray-700 dark:text-gray-300;
        }
        
        .dataTables_length select {
            @apply mx-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }
        
        .dataTables_filter {
            @apply mb-0 flex-shrink-0;
        }
        
        .dataTables_filter label {
            @apply flex items-center text-sm font-medium text-gray-700 dark:text-gray-300;
        }
        
        .dataTables_filter input {
            @apply ml-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500;
        }
        
        .dataTables_paginate {
            @apply flex justify-center items-center space-x-1 mt-3;
        }
        
        .dataTables_paginate .paginate_button {
            @apply inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 !important;
            text-decoration: none !important;
            margin: 0 2px !important;
            min-width: 2rem;
            text-align: center;
        }
        
        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 shadow-md !important;
        }
        
        .dataTables_paginate .paginate_button.disabled {
            @apply opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-gray-200 dark:border-gray-800 !important;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>