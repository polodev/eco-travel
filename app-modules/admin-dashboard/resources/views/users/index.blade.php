<x-admin-dashboard-layout::layout>
    <div class="p-4 bg-white dark:bg-gray-800">
        <!-- Filter Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Management</h2>
                <div class="flex space-x-2">
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
                    <a href="{{ route('admin-dashboard.users.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add User
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Role</label>
                        <select multiple class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="role[]" id="role">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ Str::headline($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="email_verified" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Verification</label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="email_verified" id="email_verified">
                            <option value="">All Users</option>
                            <option value="verified">Verified</option>
                            <option value="unverified">Unverified</option>
                        </select>
                    </div>
                    <div>
                        <label for="user_creation_date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Creation Date Range</label>
                        <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="user_creation_date_range" id="user_creation_date_range" placeholder="Select date range">
                    </div>
                    <div>
                        <label for="search_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quick Search</label>
                        <input class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by name, email...">
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded" type="checkbox" id="storing_filter_data" checked>
                        <label class="ml-2 text-sm text-gray-700 dark:text-gray-300" for="storing_filter_data">
                            Remember filter settings
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hidden date inputs for DataTables -->
        <input type="hidden" id="starting_date_of_user_create_at">
        <input type="hidden" id="ending_date_of_user_created_at">
        
        <!-- DataTable Info -->
        <div id="datatable-info-custom" class="mb-4 text-sm text-gray-600 dark:text-gray-400"></div>
        
        <!-- Multi-select Actions -->
        <div id="multi-select-actions" class="mb-4" style="display: none;">
            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 flex justify-between items-center">
                <span class="text-blue-800 dark:text-blue-200">
                    <strong><span id="number_of_row_selected_text">0</span></strong> users selected
                </span>
                <div class="flex space-x-2">
                    <button type="button" class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600" id="remove_selection_button">
                        Clear Selection
                    </button>
                    <button type="button" class="px-3 py-1 text-sm text-white bg-blue-600 border border-transparent rounded hover:bg-blue-700" id="all_selection_button">
                        Select All
                    </button>
                    <button type="button" class="px-3 py-1 text-sm text-white bg-yellow-600 border border-transparent rounded hover:bg-yellow-700" id="bulk_update_role_button">
                        Update Role
                    </button>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table id="user-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-16">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Created At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">Verified</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Last Login</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Go to Page Number -->
        <div class="mt-4">
            <div class="flex items-center space-x-2 max-w-xs">
                <input type="number" value="1" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" id="datatable-page-number">
                <button id="datatable-page-number-button" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600" type="button">
                    Go To Page
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const current_route_name = 'admin-dashboard.users.index';
        
        $(document).ready(function() {
            // DataTable configuration
            var columns = [
                {
                    data: 'id',
                    name: 'id',
                    searchable: true,
                },
                {
                    data: 'created_at_formatted',
                    name: 'created_at',
                    searchable: false,
                    orderable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    searchable: true,
                },
                {
                    data: 'email',
                    name: 'email',
                    searchable: true,
                },
                {
                    data: 'email_verified_badge',
                    name: 'email_verified_at',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'role_badge',
                    name: 'role',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'last_login_formatted',
                    name: 'last_login_at',
                    searchable: false,
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ];
            
            var data_table_args = {
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100, 200],
                ajax: {
                    url: '{{ route('admin-dashboard.users.json') }}',
                    type: "POST",
                    data: function(d) {
                        d.role = $('#role').val();
                        d.email_verified = $('#email_verified').val();
                        d.starting_date_of_user_create_at = $('#starting_date_of_user_create_at').val();
                        d.ending_date_of_user_created_at = $('#ending_date_of_user_created_at').val();
                        d.search_text = $('#search_text').val();
                    }
                },
                "autoWidth": false,
                columns: columns,
                order: [
                    [1, 'desc']
                ],
                "ordering": true,
                "language": {
                    "search": "Search users:",
                    "lengthMenu": "Show _MENU_ users per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ users",
                    "infoEmpty": "No users found",
                    "infoFiltered": "(filtered from _MAX_ total users)"
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer');
                    if (data.role === 'developer') {
                        $(row).addClass('bg-blue-50 dark:bg-blue-900');
                    } else if (data.role === 'admin') {
                        $(row).addClass('bg-yellow-50 dark:bg-yellow-900');
                    }
                }
            };
            
            // Add export buttons for admin users
            @if(auth()->user()->hasAnyRole(['developer', 'admin']))
                data_table_args.buttons = [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ];
                data_table_args.dom = 'Blfrtip';
            @endif
            
            var userTable = $('#user-table').DataTable(data_table_args);
            
            // Multi-select functionality
            $('#user-table tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#remove_selection_button').on('click', function() {
                $('#user-table tbody tr').removeClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#all_selection_button').on('click', function() {
                $('#user-table tbody tr').addClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            function updateTextForNumberOfSelectedRows() {
                var selectedCount = $('#user-table tbody tr.selected').length;
                $('#number_of_row_selected_text').text(selectedCount);
                
                if (selectedCount > 0) {
                    $('#multi-select-actions').show();
                } else {
                    $('#multi-select-actions').hide();
                }
            }
            
            // Initialize date range picker
            $('#user_creation_date_range').flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const startDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        const endDate = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                        $('#starting_date_of_user_create_at').val(startDate);
                        $('#ending_date_of_user_created_at').val(endDate);
                        userTable.draw();
                    }
                },
                onReady: function(dateObj, dateStr, instance) {
                    var $cal = $(instance.calendarContainer);
                    if ($cal.find('.flatpickr-clear').length < 1) {
                        $cal.append('<div class="flatpickr-clear">Clear</div>');
                        $cal.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                            $('#starting_date_of_user_create_at').val('');
                            $('#ending_date_of_user_created_at').val('');
                            userTable.draw();
                        });
                    }
                }
            });
            
            // Page navigation
            function dataTableNavigate(table) {
                $('#datatable-page-number-button').on('click', function() {
                    var pageNumber = parseInt($('#datatable-page-number').val()) - 1;
                    if (pageNumber >= 0) {
                        table.page(pageNumber).draw('page');
                    }
                });
            }
            dataTableNavigate(userTable);
            
            // Filter change listeners
            var filterElements = [
                '#role',
                '#email_verified',
                '#starting_date_of_user_create_at',
                '#ending_date_of_user_created_at'
            ];
            
            // Local storage for filter persistence
            const storingFilterDataCheckbox = $('#storing_filter_data');
            const storing_filter_data_local_forage_key = 'storing_filter_data_users';
            
            // Retrieve checkbox state from localStorage
            if (localStorage.getItem(storing_filter_data_local_forage_key) !== null) {
                storingFilterDataCheckbox.prop('checked', localStorage.getItem(storing_filter_data_local_forage_key) === 'true');
            }
            
            // Save checkbox state
            storingFilterDataCheckbox.on('change', function() {
                localStorage.setItem(storing_filter_data_local_forage_key, storingFilterDataCheckbox.is(':checked'));
            });
            
            filterElements.forEach(function(element) {
                // Load saved filter values
                setTimeout(function() {
                    if (storingFilterDataCheckbox.is(':checked')) {
                        var savedValue = localStorage.getItem(current_route_name + element);
                        if (savedValue) {
                            $(element).val(savedValue).trigger('change');
                        }
                    }
                }, 100);
                
                // Save and apply filters on change
                $(element).change(function(e) {
                    if (storingFilterDataCheckbox.is(':checked')) {
                        localStorage.setItem(current_route_name + element, $(element).val());
                    }
                    userTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    userTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val(null).trigger('change');
                    localStorage.removeItem(current_route_name + element);
                });
                $('#search_text').val('');
                $('#user_creation_date_range').val('');
                userTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                var isVisible = $filter_area.is(':visible');
                
                if (isVisible) {
                    $filter_area.hide();
                    localStorage.setItem('user_filter_area_visibility', 'hidden');
                } else {
                    $filter_area.show();
                    localStorage.setItem('user_filter_area_visibility', 'show');
                }
            });
            
            // Restore filter area visibility
            if (localStorage.getItem('user_filter_area_visibility') === 'hidden') {
                $('#filter_area').hide();
            }
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            userTable.on('draw', function() {
                updateDataTableInfo();
                updateTextForNumberOfSelectedRows();
            });
            
            updateDataTableInfo();
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
        table.dataTable tbody tr.selected {
            background-color: #dbeafe !important;
        }
        
        .dark table.dataTable tbody tr.selected {
            background-color: #1e3a8a !important;
        }
        
        .flatpickr-clear {
            background: #dc2626;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            text-align: center;
            margin-top: 5px;
            border-radius: 3px;
        }
        
        .flatpickr-clear:hover {
            background: #b91c1c;
        }
        
        /* DataTables responsive styles */
        .dataTables_wrapper {
            @apply text-gray-700 dark:text-gray-300;
        }
        
        .dataTables_length select,
        .dataTables_filter input {
            @apply px-3 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100;
        }
        
        .dataTables_paginate .paginate_button {
            @apply px-3 py-1 mx-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded;
        }
        
        .dataTables_paginate .paginate_button:hover {
            @apply bg-gray-50 dark:bg-gray-700;
        }
        
        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>