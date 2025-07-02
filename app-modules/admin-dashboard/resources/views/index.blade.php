<x-admin-dashboard-layout::layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="bg-white rounded shadow-sm p-4">
                    <h1 class="h3 mb-4">Admin Dashboard</h1>
                    <p class="lead">Welcome to the Admin Dashboard. Manage users, roles, and system settings.</p>
                    
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">User Management</h5>
                                    <p class="card-text">Manage system users, roles, and permissions.</p>
                                    <a href="{{ route('admin-dashboard.users.index') }}" class="btn btn-primary">
                                        Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Reports</h5>
                                    <p class="card-text">View system reports and analytics.</p>
                                    <a href="#" class="btn btn-info">
                                        View Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-cog fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Settings</h5>
                                    <p class="card-text">Configure system settings and preferences.</p>
                                    <a href="#" class="btn btn-success">
                                        System Settings
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>
