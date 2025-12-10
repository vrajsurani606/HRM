@extends('layouts.macos')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">🔐 All User Passwords</h2>
            <p class="text-muted mb-0">View all user account passwords</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('system-passwords.employees') }}" class="btn btn-outline-success">
                <i class="fas fa-user-tie me-2"></i>Employee Passwords
            </a>
            <a href="{{ route('system-passwords.companies') }}" class="btn btn-outline-info">
                <i class="fas fa-building me-2"></i>Company Passwords
            </a>
            <a href="{{ route('passwords.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-lock me-2"></i>Password Vault
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('system-passwords.index') }}" class="row g-3">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Plain Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile_no ?? '-' }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->plain_password)
                                <div class="input-group input-group-sm" style="max-width: 250px;">
                                    <input type="password" class="form-control form-control-sm password-field-{{ $user->id }}" value="{{ $user->plain_password }}" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword({{ $user->id }})">
                                        <i class="fas fa-eye" id="icon-{{ $user->id }}"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyPassword('{{ $user->plain_password }}', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @else
                                <span class="text-muted">Not stored</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="View User">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No users found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Info Alert -->
    <div class="alert alert-warning mt-4">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Security Warning:</strong> Plain passwords are stored for administrative purposes only. Keep this information secure and only accessible to authorized administrators.
    </div>
</div>

@push('scripts')
<script>
function togglePassword(userId) {
    const field = document.querySelector('.password-field-' + userId);
    const icon = document.getElementById('icon-' + userId);
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function copyPassword(password, button) {
    navigator.clipboard.writeText(password).then(function() {
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-primary');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(function(err) {
        alert('Failed to copy: ' + err);
    });
}
</script>
@endpush
@endsection
