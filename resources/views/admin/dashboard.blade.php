@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">Welcome back, {{ Auth::guard('admin')->user()->name }}. Manage your properties and enquiries here.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4 d-flex align-items-center justify-content-between border-0 shadow-sm">
                <div>
                    <span class="text-muted small fw-semibold uppercase">Total Properties</span>
                    <h2 class="fw-bold text-dark mt-1 mb-0">{{ $propertiesCount }}</h2>
                </div>
                <div class="bg-primary-subtle text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                    <i class="fa-solid fa-building fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 d-flex align-items-center justify-content-between border-0 shadow-sm">
                <div>
                    <span class="text-muted small fw-semibold uppercase">Featured Listings</span>
                    <h2 class="fw-bold text-warning mt-1 mb-0">{{ $featuredCount }}</h2>
                </div>
                <div class="bg-warning-subtle text-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                    <i class="fa-solid fa-star fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 d-flex align-items-center justify-content-between border-0 shadow-sm">
                <div>
                    <span class="text-muted small fw-semibold uppercase">Customer Enquiries</span>
                    <h2 class="fw-bold text-success mt-1 mb-0">{{ $enquiriesCount }}</h2>
                </div>
                <div class="bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                    <i class="fa-solid fa-envelope fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Properties Card -->
        <div class="col-md-6">
            <div class="glass-card p-5 text-center h-100 d-flex flex-column justify-content-center">
                <i class="fa-solid fa-building fa-4x text-primary mb-4"></i>
                <h3 class="fw-bold">Properties</h3>
                <p class="text-muted mb-4">Manage your real estate listings, add new ones, or edit existing properties.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-primary">View Properties</a>
                    <a href="{{ route('admin.properties.index') }}?add=1" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        
        <!-- Enquiries Card -->
        <div class="col-md-6">
            <div class="glass-card p-5 text-center h-100 d-flex flex-column justify-content-center">
                <i class="fa-solid fa-envelope-open-text fa-4x text-success mb-4"></i>
                <h3 class="fw-bold">Enquiries</h3>
                <p class="text-muted mb-4">View and respond to customer enquiries about your properties.</p>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-success">View Enquiries</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
