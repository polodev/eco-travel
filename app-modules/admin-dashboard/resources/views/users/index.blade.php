<x-admin-dashboard-layout::layout>
    <div class="container-fluid">
        <div class="bg-white rounded shadow-sm">
            <div class="p-4">
                <h2 class="h4 mb-4">User Management</h2>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="role" class="form-label">Filter by Role</label>
                        <select multiple class="form-select" name="role[]" id="role">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ Str::headline($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="starting_date_of_user_create_at" class="form-label">Creation Date Start</label>
                        <input class="form-control" type="date" name="starting_date_of_user_create_at" id="starting_date_of_user_create_at">
                    </div>
                    <div class="col-md-3">
                        <label for="ending_date_of_user_created_at" class="form-label">Creation Date End</label>
                        <input class="form-control" type="date" name="ending_date_of_user_created_at" id="ending_date_of_user_created_at">
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="user-table" class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            var userTable = $('#user-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: {
                    url: '{{ route('admin-dashboard.users.json') }}',
                    data: function(d) {
                        d.role = $('#role').val();
                        d.starting_date_of_user_create_at = $('#starting_date_of_user_create_at').val();
                        d.ending_date_of_user_created_at = $('#ending_date_of_user_created_at').val();
                    }
                },
                columns: [
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
                        data: 'role',
                        name: 'role',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                "ordering": true,
                "language": {
                    "search": "Search users:",
                    "lengthMenu": "Show _MENU_ users per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ users",
                    "infoEmpty": "No users found",
                    "infoFiltered": "(filtered from _MAX_ total users)"
                }
            });

            // Filter change listeners
            var filterElements = [
                '#role',
                '#starting_date_of_user_create_at',
                '#ending_date_of_user_created_at'
            ];

            filterElements.forEach(function(element) {
                $(element).change(function(e) {
                    userTable.draw();
                    e.preventDefault();
                });
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>