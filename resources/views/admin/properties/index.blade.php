@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manage Properties</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Properties</li>
                </ol>
            </nav>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
                <i class="fa-solid fa-plus me-2"></i>Add Property
            </button>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="80">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">City</th>
                        <th scope="col">Price</th>
                        <th scope="col" width="100">Featured</th>
                        <th scope="col" width="150" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $propertyTypes = \App\Models\PropertyType::all(); @endphp
                    
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                @if($property->featured_image)
                                    <img src="{{ asset($property->featured_image) }}" class="rounded" width="60" height="40" style="object-fit: cover;" alt="{{ $property->title }}">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px;">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $property->title }}</td>
                            <td><span class="badge bg-secondary">{{ $property->propertyType->name }}</span></td>
                            <td>{{ $property->city }}</td>
                            <td class="fw-bold text-success">${{ number_format($property->price) }}</td>
                            <td>
                                @if($property->is_featured)
                                    <i class="fa-solid fa-check-circle text-success fs-5"></i>
                                @else
                                    <i class="fa-solid fa-times-circle text-muted fs-5 opacity-50"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPropertyModal{{ $property->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Property Modal -->
                        <div class="modal fade" id="editPropertyModal{{ $property->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Edit Property: {{ $property->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-7">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">Property Title <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="title_edit_{{ $property->id }}" name="title" value="{{ $property->title }}" required>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 mb-3 mb-md-0">
                                                            <label class="form-label fw-medium">Property Type <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="type_edit_{{ $property->id }}" name="property_type_id" required>
                                                                <option value="">Select Type</option>
                                                                @foreach($propertyTypes as $type)
                                                                    <option value="{{ $type->id }}" {{ $property->property_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-medium">City <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="city_edit_{{ $property->id }}" name="city" value="{{ $property->city }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <label class="form-label fw-medium mb-0">Property Description <span class="text-danger">*</span></label>
                                                            <button type="button" class="btn btn-sm btn-outline-primary btn-generate-ai" data-target="edit_{{ $property->id }}">
                                                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i> AI Gen
                                                            </button>
                                                        </div>
                                                        <textarea class="form-control" id="desc_edit_{{ $property->id }}" name="description" rows="6" required>{{ $property->description }}</textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-5">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">Price (USD) <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" step="0.01" class="form-control" name="price" value="{{ $property->price }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">Featured Image</label>
                                                        <input class="form-control img-upload" data-target="preview_edit_{{ $property->id }}" type="file" name="featured_image" accept="image/*">
                                                        <div class="form-text">Leave blank to keep the current image.</div>
                                                        
                                                        <div class="mt-2 text-center {{ !$property->featured_image ? 'd-none' : '' }}" id="preview_edit_{{ $property->id }}_container">
                                                            <img src="{{ $property->featured_image ? asset($property->featured_image) : '' }}" id="preview_edit_{{ $property->id }}" class="img-thumbnail" style="max-height: 150px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="is_featured" {{ $property->is_featured ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-medium ms-2">Featured Property</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Property</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-building-circle-xmark fa-3x mb-3 opacity-50"></i>
                                <h5>No properties found</h5>
                                <p>You haven't added any properties yet.</p>
                                <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addPropertyModal">Add your first property</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4 d-flex justify-content-end">
        {{ $properties->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Property Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title_new" name="title" required>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-medium">Property Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="type_new" name="property_type_id" required>
                                        <option value="">Select Type</option>
                                        @foreach($propertyTypes ?? \App\Models\PropertyType::all() as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city_new" name="city" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-medium mb-0">Property Description <span class="text-danger">*</span></label>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-generate-ai" data-target="new">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> AI Gen
                                    </button>
                                </div>
                                <textarea class="form-control" id="desc_new" name="description" rows="6" required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Price (USD) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" name="price" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Featured Image</label>
                                <input class="form-control img-upload" data-target="preview_new" type="file" name="featured_image" accept="image/*">
                                
                                <div class="mt-2 text-center d-none" id="preview_new_container">
                                    <img src="" id="preview_new" class="img-thumbnail" style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_featured">
                                <label class="form-check-label fw-medium ms-2">Featured Property</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Property</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-open Add modal if requested in URL
    if (window.location.hash === '#add' || new URLSearchParams(window.location.search).has('add')) {
        const addModalEl = document.getElementById('addPropertyModal');
        if (addModalEl) {
            const addModal = new bootstrap.Modal(addModalEl);
            addModal.show();
        }
    }

    // Image Preview for Modals
    $('.img-upload').change(function() {
        const file = this.files[0];
        const target = $(this).data('target');
        
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#' + target).attr('src', event.target.result);
                $('#' + target + '_container').removeClass('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            $('#' + target + '_container').addClass('d-none');
        }
    });

    // AI Description Generation for Modals
    $('.btn-generate-ai').click(function() {
        let targetId = $(this).data('target');
        let title = $('#title_' + targetId).val();
        let city = $('#city_' + targetId).val();
        let property_type_id = $('#type_' + targetId).val();

        if (!title || !city || !property_type_id) {
            alert('Please fill out Title, Property Type, and City first so the AI knows what to write about!');
            return;
        }

        let btn = $(this);
        let originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('admin.ai.generate-description') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                title: title,
                city: city,
                property_type_id: property_type_id
            },
            success: function(response) {
                if(response.success) {
                    $('#desc_' + targetId).val(response.description);
                } else {
                    alert(response.message || 'Error generating description.');
                }
                btn.prop('disabled', false).html(originalText);
            },
            error: function(xhr) {
                alert('Something went wrong contacting the AI API.');
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endpush
