<x-admin-dashboard-layout::layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Visa Processing Management</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage visa processing services and requirements</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('visa-processing::admin.visa-processings.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Visa Processing
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select id="status-filter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">All Statuses</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                            <select id="country-filter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">All Countries</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Visa Type</label>
                            <select id="visa-type-filter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">All Types</option>
                                <option value="tourist">Tourist</option>
                                <option value="business">Business</option>
                                <option value="student">Student</option>
                                <option value="work">Work</option>
                                <option value="medical">Medical</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured</label>
                            <select id="featured-filter" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">All</option>
                                <option value="1">Featured Only</option>
                                <option value="0">Non-Featured</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="visa-processings-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Country</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visa Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Featured</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                <!-- DataTable will populate this -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#visa-processings-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("visa-processing::admin.visa-processings.json") }}',
                    data: function(d) {
                        d.status = $('#status-filter').val();
                        d.country = $('#country-filter').val();
                        d.visa_type = $('#visa-type-filter').val();
                        d.featured = $('#featured-filter').val();
                    }
                },
                columns: [
                    { data: 'id_formatted', name: 'id', orderable: false, searchable: false },
                    { data: 'english_title', name: 'english_title' },
                    { data: 'country_info', name: 'country', orderable: false, searchable: false },
                    { data: 'visa_type_badge', name: 'visa_type', orderable: false, searchable: false },
                    { data: 'price_display', name: 'visa_fees' },
                    { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                    { data: 'featured_badge', name: 'is_featured', orderable: false, searchable: false },
                    { data: 'author', name: 'user.name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[8, 'desc']],
                pageLength: 25,
                responsive: true,
                language: {
                    search: "Search visa processings:",
                    lengthMenu: "Show _MENU_ visa processings per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ visa processings",
                    infoEmpty: "No visa processings found",
                    infoFiltered: "(filtered from _MAX_ total visa processings)"
                }
            });

            // Filter event handlers
            $('#status-filter, #country-filter, #visa-type-filter, #featured-filter').on('change', function() {
                table.draw();
            });

            // Delete function
            window.deleteRecord = function(id) {
                if (confirm('Are you sure you want to delete this visa processing? This action cannot be undone.')) {
                    $.ajax({
                        url: `/admin-dashboard/visa-processings/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                table.draw();
                                alert('Visa processing deleted successfully.');
                            } else {
                                alert(response.message || 'Failed to delete visa processing.');
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            alert(response?.message || 'An error occurred while deleting the visa processing.');
                        }
                    });
                }
            };
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>