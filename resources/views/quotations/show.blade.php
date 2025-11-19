@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Quotation Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Company Information</h5>
                            <p><strong>Company Name:</strong> {{ $quotation->company_name ?? 'N/A' }}</p>
                            <p><strong>GST No:</strong> {{ $quotation->gst_no ?? 'N/A' }}</p>
                            <p><strong>PAN No:</strong> {{ $quotation->pan_no ?? 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $quotation->address ?? 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $quotation->city ?? 'N/A' }}</p>
                            <p><strong>Nature of Work:</strong> {{ $quotation->nature_of_work ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Quotation Details</h5>
                            <p><strong>Quotation #:</strong> {{ $quotation->unique_code ?? 'N/A' }}</p>
                            <p><strong>Date:</strong> {{ $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : 'N/A' }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-{{ $quotation->status === 'draft' ? 'warning' : 'success' }}">{{ ucfirst($quotation->status) }}</span></p>
                            <p><strong>Contract Amount:</strong> {{ $quotation->contract_amount ? '₹' . number_format($quotation->contract_amount, 2) : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Scope of Work</h5>
                            <div class="border p-3">
                                {!! nl2br(e($quotation->scope_of_work)) ?? 'No scope of work provided.' !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5>Contact Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Contact Person 1:</strong> {{ $quotation->contact_person_1 ?? 'N/A' }}</p>
                                    <p><strong>Position:</strong> {{ $quotation->position_1 ?? 'N/A' }}</p>
                                    <p><strong>Contact Number:</strong> {{ $quotation->contact_number_1 ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> {{ $quotation->company_email ?? 'N/A' }}</p>
                                    <p><strong>Project Start Date:</strong> {{ $quotation->project_start_date ? \Carbon\Carbon::parse($quotation->project_start_date)->format('d/m/Y') : 'N/A' }}</p>
                                    <p><strong>Tentative Completion:</strong> {{ $quotation->tentative_complete_date ? \Carbon\Carbon::parse($quotation->tentative_complete_date)->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($quotation->contract_copy_path)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Contract Document</h5>
                            <a href="{{ asset('storage/' . $quotation->contract_copy_path) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-download"></i> Download Contract
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Quotation
                    </a>
                    <a href="{{ route('quotations.contract.pdf', $quotation->id) }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Generate PDF Contract
                    </a>
                    <a href="{{ route('quotations.contract.png', $quotation->id) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-image"></i> Generate PNG Contract
                    </a>
                    <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
