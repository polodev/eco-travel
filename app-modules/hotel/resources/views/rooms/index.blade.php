<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Hotel Rooms</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage hotel room types and configurations</p>
                </div>
                <a href="{{ route('admin-dashboard.hotel.rooms.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Room
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Filter Section -->
            <div class="mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Search Text -->
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" 
                               id="search_text" 
                               name="search_text"
                               class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                               placeholder="Search rooms...">
                    </div>

                    <!-- Hotel Filter -->
                    <div>
                        <label for="hotel_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Hotel</label>
                        <select id="hotel_filter" name="hotel_id" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Hotels</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Room Type Filter -->
                    <div>
                        <label for="room_type_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Room Type</label>
                        <select id="room_type_filter" name="room_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Types</option>
                            @foreach(\Modules\Hotel\Models\HotelRoom::getAvailableRoomTypes() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bed Type Filter -->
                    <div>
                        <label for="bed_type_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Bed Type</label>
                        <select id="bed_type_filter" name="bed_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Bed Types</option>
                            @foreach(\Modules\Hotel\Models\HotelRoom::getAvailableBedTypes() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="status_filter" name="is_active" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Refundable Filter -->
                    <div>
                        <label for="refundable_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Refundable</label>
                        <select id="refundable_filter" name="is_refundable" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All</option>
                            <option value="1">Refundable</option>
                            <option value="0">Non-refundable</option>
                        </select>
                    </div>
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex items-center space-x-3 mt-4">
                    <button type="button" id="apply-filters" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 21v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <button type="button" id="clear-filters" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                </div>
            </div>

            <!-- DataTable Container -->
            <div class="overflow-hidden">
                <table id="rooms-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- DataTables will handle thead and tbody -->
                </table>
            </div>
        </div>
    </div>


    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $('#rooms-table').DataTable({
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
                    url: '{{ route("admin-dashboard.hotel.rooms.json") }}',
                    type: 'POST',
                    data: function(d) {
                        d.search_text = $('#search_text').val();
                        d.hotel_id = $('#hotel_filter').val();
                        d.room_type = $('#room_type_filter').val();
                        d.bed_type = $('#bed_type_filter').val();
                        d.is_active = $('#status_filter').val();
                        d.is_refundable = $('#refundable_filter').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        title: 'ID',
                        searchable: true,
                        className: 'text-center w-16'
                    },
                    {
                        data: 'room_info',
                        name: 'name',
                        title: 'Room Info',
                        searchable: true,
                        className: 'font-medium min-w-64'
                    },
                    {
                        data: 'room_type_badge',
                        name: 'room_type',
                        title: 'Type',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-32'
                    },
                    {
                        data: 'occupancy_info',
                        name: 'max_occupancy',
                        title: 'Occupancy',
                        searchable: false,
                        orderable: true,
                        className: 'min-w-40'
                    },
                    {
                        data: 'price_display',
                        name: 'base_price',
                        title: 'Price',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-28'
                    },
                    {
                        data: 'room_details',
                        name: 'room_size',
                        title: 'Details',
                        searchable: false,
                        orderable: false,
                        className: 'w-32'
                    },
                    {
                        data: 'amenities_display',
                        name: 'amenities',
                        title: 'Amenities',
                        searchable: false,
                        orderable: false,
                        className: 'min-w-56'
                    },
                    {
                        data: 'status_badges',
                        name: 'is_active',
                        title: 'Status',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-32'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        title: 'Created At',
                        searchable: false,
                        orderable: true,
                        className: 'w-32'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    }
                ],
                order: [[8, 'desc']],
                language: {
                    processing: '<div class="flex items-center justify-center p-4"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div><span class="ml-2">Loading...</span></div>',
                    emptyTable: '<div class="text-center py-8"><div class="text-gray-400 text-lg mb-2"><i class="fas fa-bed"></i></div><div class="text-gray-500">No hotel rooms found</div></div>',
                    zeroRecords: '<div class="text-center py-8"><div class="text-gray-400 text-lg mb-2"><i class="fas fa-search"></i></div><div class="text-gray-500">No matching rooms found</div></div>'
                }
            });

            // Navigation helper
            window.dataTableNavigate(table);

            // Apply filters
            $('#apply-filters').on('click', function() {
                table.ajax.reload();
            });

            // Clear filters
            $('#clear-filters').on('click', function() {
                $('#search_text').val('');
                $('#hotel_filter').val('');
                $('#room_type_filter').val('');
                $('#bed_type_filter').val('');
                $('#status_filter').val('');
                $('#refundable_filter').val('');
                table.ajax.reload();
            });

            // Enter key support for search
            $('#search_text').on('keypress', function(e) {
                if (e.which === 13) {
                    table.ajax.reload();
                }
            });

            // Auto-reload on filter change
            $('#hotel_filter, #room_type_filter, #bed_type_filter, #status_filter, #refundable_filter').on('change', function() {
                table.ajax.reload();
            });

            // Auto-apply hotel filter if hotel_id is present in URL
            @if(request('hotel_id'))
                table.ajax.reload();
            @endif
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>