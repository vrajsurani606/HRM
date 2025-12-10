@extends('layouts.macos')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">🏢 All Company Passwords</h2>
            <p class="text-muted mb-0">View all company account passwords</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('system-passwords.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-2"></i>User Passwords
            </a>
            <a href="{{ route('system-passwords.employees') }}" class="btn btn-outline-success">
                <i class="fas fa-user-tie me-2"></i>Employee Passwords
            </a>
            <a href="{{ route('passwords.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-lock me-2"></i>Password Vault
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('system-passwords.companies') }}" class="row g-3">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Search by company name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Company Email</th>
                            <th>Company Password</th>
                            <th>Employee Email</th>
                            <th>Employee Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td><strong>{{ $company->name }}</strong></td>
                            <td>{{ $company->company_email ?? '-' }}</td>
                            <td>
                                @if($company->company_password)
                                <div class="input-group input-group-sm" style="max-width: 200px;">
                                    <input type="password" class="form-control form-control-sm password-field-company-{{ $company->id }}" value="{{ $company->company_password }}" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword('company', {{ $company->id }})">
                                        <i class="fas fa-eye" id="icon-company-{{ $company->id }}"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyPassword('{{ $company->company_password }}', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $company->company_employee_email ?? '-' }}</td>
                            <td>
                                @if($company->company_employee_password)
                                <div class="input-group input-group-sm" style="max-width: 200px;">
                                    <input type="password" class="form-control form-control-sm password-field-employee-{{ $company->id }}" value="{{ $company->company_employee_password }}" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword('employee', {{ $company->id }})">
                                        <i class="fas fa-eye" id="icon-employee-{{ $company->id }}"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyPassword('{{ $company->company_employee_password }}', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('companies.show', $company) }}" class="btn btn-sm btn-outline-primary" title="View Company">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No companies found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($companies->hasPages())
        <div class="card-footer bg-white">
            {{ $companies->links() }}
        </div>
        @endif
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Note:</strong> Company passwords are stored for reference. These are typically third-party service credentials.
    </div>
</div>

@push('scripts')
<script>
function togglePassword(type, companyId) {
    const field = document.querySelector('.password-field-' + type + '-' + companyId);
    const icon = document.getElementById('icon-' + type + '-' + companyId);
    
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
