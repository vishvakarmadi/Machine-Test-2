@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Find Your Dream Home</h1>
        <p class="lead mb-5 opacity-75">Discover the most premium properties in the best locations.</p>
        
        <form action="{{ url('/') }}" method="GET" class="glass-card p-4 mx-auto" style="max-width: 800px;">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="city" class="form-control form-control-lg" placeholder="Search by city..." value="{{ request('city') }}">
                </div>
                <div class="col-md-4">
                    <select name="type" class="form-select form-select-lg">
                        <option value="">All Property Types</option>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Latest Properties</h2>
    </div>

    @if($properties->count() > 0)
        <div class="row g-4">
            @foreach($properties as $property)
                <div class="col-md-6 col-lg-4">
                    <div class="glass-card h-100 position-relative">
                        @if($property->is_featured)
                            <span class="badge-featured">Featured</span>
                        @endif
                        
                        <div style="height: 250px; overflow: hidden;">
                            @if($property->featured_image)
                                <img src="{{ asset($property->featured_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $property->title }}">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                    <i class="fa-solid fa-house fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="text-primary fw-semibold">{{ $property->propertyType->name }}</span>
                                <h4 class="fw-bold text-success mb-0">${{ number_format($property->price) }}</h4>
                            </div>
                            <h5 class="fw-bold mb-2 text-truncate" title="{{ $property->title }}">{{ $property->title }}</h5>
                            <p class="text-muted mb-4"><i class="fa-solid fa-location-dot me-2"></i>{{ $property->city }}</p>
                            
                            <a href="{{ url('/property/' . $property->id) }}" class="btn btn-outline-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5 glass-card">
            <i class="fa-solid fa-magnifying-glass fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No properties found matching your criteria.</h4>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-3">Clear Filters</a>
        </div>
    @endif
</div>
@endsection
