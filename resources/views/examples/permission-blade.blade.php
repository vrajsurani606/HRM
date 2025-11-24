@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Employee Management</h3>
                    
                    {{-- Show create button only if user has create permission --}}
                    @can('employees.create')
                    <a href="{{ route('employees.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                    @endcan
                </div>
                
                <div class="card-body">
                    {{-- Show different content based on role --}}
                    @role('super-admin')
                        <div class="alert alert-info">
                            <strong>Super Admin View:</strong> You have full access to all features.
                        </div>
                    @endrole

                    @role('admin')
                        <div class="alert alert-warning">
                            <strong>Admin View:</strong> You have administrative access.
                        </div>
                    @endrole

                    @role('hr')
                        <div class="alert alert-success">
                            <strong>HR View:</strong> You can manage employees and payroll.
                        </div>
                    @endrole

                    {{-- Check multiple roles --}}
                    @hasanyrole('admin|hr')
                        <div class="mb-3">
                            <button class="btn btn-info">HR Functions Available</button>
                        </div>
                    @endhasanyrole

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>IT</td>
                                    <td>
                                        {{-- Show view button if user can view --}}
                                        @can('employees.view')
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endcan

                                        {{-- Show edit button if user can edit --}}
                                        @can('employees.edit')
                                        <a href="#" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @endcan

                                        {{-- Show delete button if user can delete --}}
                                        @can('employees.delete')
                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        @endcan

                                        {{-- Show special actions for specific roles --}}
                                        @hasrole('hr')
                                        <a href="#" class="btn btn-sm btn-success">
                                            <i class="fas fa-dollar-sign"></i> Payroll
                                        </a>
                                        @endhasrole
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Show advanced features only for certain permissions --}}
                    @canany(['employees.manage', 'payroll.manage'])
                    <div class="mt-4">
                        <h5>Advanced Features</h5>
                        <div class="btn-group">
                            @can('employees.manage')
                            <button class="btn btn-outline-primary">Bulk Import</button>
                            <button class="btn btn-outline-primary">Export Data</button>
                            @endcan
                            
                            @can('payroll.manage')
                            <button class="btn btn-outline-success">Generate Payroll</button>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    {{-- Show message if user has no permissions --}}
                    @cannot('employees.view')
                    <div class="alert alert-danger">
                        You do not have permission to view employee data.
                    </div>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    Swal.fire({
        title: 'Delete Employee?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform delete action here
            toastr.success('Employee deleted successfully!');
        }
    });
}
</script>
@endsection