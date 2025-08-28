@extends('admin.layouts.app')

@section('title', 'Manage Testimonials')

@section('page_title', 'Testimonials Management')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Testimonials</h5>
                <div>
                    <span class="me-3 text-muted">Next display order: <strong>{{ $nextDisplayOrder }}</strong></span>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Add New Testimonial
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
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th width="100">Order</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->id }}</td>
                            <td>
                                @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                                    class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $testimonial->name }}</td>
                            <td>{{ $testimonial->designation }}</td>
                            <td>
                                @if($testimonial->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control form-control-sm order-input"
                                        data-id="{{ $testimonial->id }}" value="{{ $testimonial->display_order }}"
                                        min="0" style="width: 70px;">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
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
                            <td colspan="7" class="text-center py-4">No testimonials found</td>
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
                const testimonialId = this.getAttribute('data-id');
                const newOrder = this.value;
                
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/testimonials/${testimonialId}`;
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
                const testimonialRow = this.closest('tr');
                const name = testimonialRow.cells[2].textContent.trim();
                const designation = testimonialRow.cells[3].textContent.trim();
                const isActive = testimonialRow.cells[4].querySelector('.badge').classList.contains('bg-success');
                
                const nameField = document.createElement('input');
                nameField.type = 'hidden';
                nameField.name = 'name';
                nameField.value = name;
                form.appendChild(nameField);
                
                const designationField = document.createElement('input');
                designationField.type = 'hidden';
                designationField.name = 'designation';
                designationField.value = designation;
                form.appendChild(designationField);
                
                const isActiveField = document.createElement('input');
                isActiveField.type = 'hidden';
                isActiveField.name = 'is_active';
                isActiveField.value = isActive ? '1' : '0';
                form.appendChild(isActiveField);
                
                // Get the message from the server (we'll need to add this field)
                const messageField = document.createElement('input');
                messageField.type = 'hidden';
                messageField.name = 'message';
                messageField.value = 'Unchanged'; // This is a placeholder, we'll update this server-side
                form.appendChild(messageField);
                
                // Append the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
</script>
@endsection