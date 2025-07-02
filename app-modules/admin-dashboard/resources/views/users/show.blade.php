<x-admin-dashboard-layout::layout>
    <div class="container-fluid">
        <div class="bg-white rounded shadow-sm">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">User Details</h2>
                    <div>
                        <a href="{{ route('admin-dashboard.users.edit', $user) }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('admin-dashboard.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">User Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>ID:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->id }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Name:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Role:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        @if($user->role)
                                            <span class="badge bg-primary me-1">{{ Str::headline($user->role) }}</span>
                                        @else
                                            <span class="text-muted">No role assigned</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Email Verified:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                            <small class="text-muted">{{ $user->email_verified_at->format('Y-m-d H:i:s') }}</small>
                                        @else
                                            <span class="badge bg-warning">Not Verified</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Created:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->created_at->format('Y-m-d H:i:s') }}
                                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Last Updated:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->updated_at->format('Y-m-d H:i:s') }}
                                        <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>