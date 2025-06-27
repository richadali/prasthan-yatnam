@extends('admin.layouts.app')

@section('title', 'Manage Discourses')

@section('page_title', 'Manage Discourses')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.5rem;
        margin-left: 0.25rem;
    }

    table.dataTable {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .table-thumbnail {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 4px;
    }

    .table-thumbnail-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 4px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">All Discourses</h1>
            <p class="text-muted">Manage your spiritual discourse content</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.discourses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Create New Discourse
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="discoursesTable" class="table table-hover align-middle mb-0 w-100">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Discourse</th>
                        <th>Videos</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discourses as $index => $discourse)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($discourse->thumbnail)
                                    <img src="{{ asset('storage/' . $discourse->thumbnail) }}"
                                        alt="{{ $discourse->title }}" class="table-thumbnail"
                                        onerror="this.onerror=null; this.classList.add('bg-light'); this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2248%22%20height%3D%2248%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2048%2048%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1%20text%20%7B%20fill%3A%23919191%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1%22%3E%3Crect%20width%3D%2248%22%20height%3D%2248%22%20fill%3D%22%23eeeeee%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2217.9%22%20y%3D%2228.5%22%3E%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';">
                                    @else
                                    <div class="table-thumbnail-placeholder">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $discourse->title }}</h6>
                                    <small class="text-muted">{{ Str::limit(strip_tags($discourse->description), 60)
                                        }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="fas fa-film me-1"></i> {{ $discourse->videos()->count() }} Videos
                            </span>
                        </td>
                        <td>₹{{ number_format($discourse->price) }}</td>
                        <td>
                            @if($discourse->is_active)
                            @if($discourse->is_upcoming)
                            <span class="badge bg-warning">Upcoming</span>
                            @else
                            <span class="badge bg-success">Active</span>
                            @endif
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td data-sort="{{ $discourse->created_at->timestamp }}">{{ $discourse->created_at->format('M d,
                            Y') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.discourses.edit', $discourse->id) }}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $discourse->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $discourse->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the discourse "<strong>{{
                                                    $discourse->title }}</strong>"?</p>
                                            <p class="text-danger"><small>This will also delete all videos
                                                    associated with this discourse.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.discourses.destroy', $discourse->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#discoursesTable').DataTable({
            order: [[5, 'desc']], // Sort by Created date descending by default
            columnDefs: [
                { orderable: false, targets: [1, 6] }, // Disable sorting on description and actions columns
                { searchable: false, targets: [0, 2, 3, 4, 5, 6] } // Only search in discourse title/description column
            ],
            language: {
                search: "Search discourses:",
                lengthMenu: "Show _MENU_ discourses per page",
                info: "Showing _START_ to _END_ of _TOTAL_ discourses",
                infoEmpty: "No discourses available",
                infoFiltered: "(filtered from _MAX_ total discourses)",
                emptyTable: "No discourses found"
            },
            // Update row numbers on draw
            drawCallback: function(settings) {
                $('#discoursesTable tbody tr').each(function(index) {
                    $('td:first', this).html(index + 1);
                });
            }
        });
    });
</script>
@endsection