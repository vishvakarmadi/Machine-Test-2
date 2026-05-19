@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Property Enquiries</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Enquiries</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="150">Date</th>
                        <th scope="col">Property Reference</th>
                        <th scope="col">Customer Info</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td class="text-muted small">
                                {{ $enquiry->created_at->format('M d, Y') }}<br>
                                {{ $enquiry->created_at->format('h:i A') }}
                            </td>
                            <td>
                                @if($enquiry->property)
                                    <a href="{{ url('/property/' . $enquiry->property->id) }}" target="_blank" class="fw-medium text-decoration-none">
                                        {{ Str::limit($enquiry->property->title, 40) }}
                                    </a>
                                    <br>
                                    <span class="badge bg-secondary mt-1">{{ $enquiry->property->propertyType->name ?? 'Unknown' }}</span>
                                @else
                                    <span class="text-danger">Property Deleted</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $enquiry->name }}</strong><br>
                                <a href="mailto:{{ $enquiry->email }}" class="text-muted small text-decoration-none"><i class="fa-solid fa-envelope me-1"></i>{{ $enquiry->email }}</a><br>
                                <a href="tel:{{ $enquiry->mobile }}" class="text-muted small text-decoration-none"><i class="fa-solid fa-phone me-1"></i>{{ $enquiry->mobile }}</a>
                            </td>
                            <td>
                                <div class="bg-light p-3 rounded" style="font-size: 0.9rem;">
                                    {!! nl2br(e($enquiry->message)) !!}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-inbox fa-3x mb-3 opacity-50"></i>
                                <h5>No enquiries yet</h5>
                                <p>When customers send enquiries from property listings, they will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-4 d-flex justify-content-end">
        {{ $enquiries->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
