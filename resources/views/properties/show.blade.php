@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Property Images -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="glass-card p-2 mb-4">
                <div style="height: 500px; border-radius: 12px; overflow: hidden; position: relative;">
                    @if($property->is_featured)
                        <span class="badge-featured" style="font-size: 1rem; padding: 8px 20px;">Featured</span>
                    @endif
                    @if($property->featured_image)
                        <img src="{{ asset($property->featured_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $property->title }}">
                    @else
                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                            <i class="fa-solid fa-image fa-5x opacity-25"></i>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="glass-card p-5">
                <h3 class="fw-bold mb-4">Description</h3>
                <div class="fs-5 lh-lg text-muted">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>
        </div>
        
        <!-- Property Details Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card p-4 position-sticky" style="top: 100px;">
                <div class="mb-4 pb-4 border-bottom">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3 fw-medium">
                        {{ $property->propertyType->name }}
                    </span>
                    <h2 class="fw-bold mb-3">{{ $property->title }}</h2>
                    <p class="text-muted fs-5 mb-3"><i class="fa-solid fa-location-dot me-2 text-danger"></i>{{ $property->city }}</p>
                    <h1 class="text-success fw-bold mb-0">${{ number_format($property->price) }}</h1>
                </div>
                
                <div class="d-grid gap-3">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                        <i class="fa-solid fa-envelope me-2"></i>Send Enquiry
                    </button>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Back to Listings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header bg-light border-0 p-4">
                <h5 class="modal-title fw-bold" id="enquiryModalLabel">Enquire About This Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="enquiryAlert" class="alert d-none" role="alert"></div>
                
                <form id="enquiryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" id="error-name"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback" id="error-email"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mobile" class="form-label fw-medium">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mobile" name="mobile" required>
                        <div class="invalid-feedback" id="error-mobile"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="form-label fw-medium">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="4" required>I am interested in {{ $property->title }}. Please contact me with more details.</textarea>
                        <div class="invalid-feedback" id="error-message"></div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2" id="submitBtn">
                            Submit Enquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#enquiryForm').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let submitBtn = $('#submitBtn');
        let alertBox = $('#enquiryAlert');
        
        // Reset errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
        alertBox.addClass('d-none').removeClass('alert-success alert-danger');
        
        submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending...');
        
        $.ajax({
            url: "{{ url('/property/' . $property->id . '/enquire') }}",
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                if(response.success) {
                    form[0].reset();
                    alertBox.addClass('alert-success').text(response.message).removeClass('d-none');
                    setTimeout(function() {
                        $('#enquiryModal').modal('hide');
                        alertBox.addClass('d-none');
                    }, 3000);
                }
                submitBtn.prop('disabled', false).text('Submit Enquiry');
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).text('Submit Enquiry');
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        $('#' + key).addClass('is-invalid');
                        $('#error-' + key).text(errors[key][0]);
                    }
                } else {
                    alertBox.addClass('alert-danger').text('Something went wrong. Please try again later.').removeClass('d-none');
                }
            }
        });
    });
});
</script>
@endpush
