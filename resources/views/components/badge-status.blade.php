{{-- Component: Badge trạng thái --}}
@props(['status'])

@if($status === 'published')
    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Published</span>
@else
    <span class="badge bg-secondary"><i class="bi bi-pencil me-1"></i>Draft</span>
@endif
