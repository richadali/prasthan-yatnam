@extends('admin.layouts.app')

@section('title', 'Manage Poems')

@section('page_title', 'Poems Management')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Poems</h5>
                <div>
                    <span class="me-3 text-muted">Next display order: <strong>{{ $nextDisplayOrder }}</strong></span>
                    <a href="{{ route('admin.poems.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Add New Poem
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="100">Image</th>
                            <th>Title</th>
                            <th width="100">Order</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($poems as $poem)
                        <tr>
                            <td>{{ $poem->id }}</td>
                            <td>
                                @if($poem->image)
                                <img src="{{ asset('storage/' . $poem->image) }}" alt="{{ $poem->title }}"
                                    class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-image text-secondary"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $poem->title }}</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control form-control-sm order-input"
                                        data-id="{{ $poem->id }}" value="{{ $poem->display_order }}" min="0"
                                        style="width: 70px;">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.poems.edit', $poem->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.poems.destroy', $poem->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this poem?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No poems found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all order input fields
        const orderInputs = document.querySelectorAll('.order-input');
        
        // Add change event listener to each input
        orderInputs.forEach(input => {
            input.addEventListener('change', function() {
                const poemId = this.getAttribute('data-id');
                const newOrder = this.value;
                
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/poems/${poemId}`;
                form.style.display = 'none';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);
                
                // Add method field
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PUT';
                form.appendChild(methodField);
                
                // Add display_order field
                const orderField = document.createElement('input');
                orderField.type = 'hidden';
                orderField.name = 'display_order';
                orderField.value = newOrder;
                form.appendChild(orderField);
                
                // Add other required fields with their current values
                const poemRow = this.closest('tr');
                const title = poemRow.cells[2].textContent.trim();
                
                const titleField = document.createElement('input');
                titleField.type = 'hidden';
                titleField.name = 'title';
                titleField.value = title;
                form.appendChild(titleField);
                
                // Append the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
</script>
@endsection