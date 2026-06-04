@extends('layouts.panel')

@section('title', 'Category Master')

@section('content')
    <!-- HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-3">

                    <h4 class="page-title">
                        Category Master
                    </h4>

                    <p class="page-subtitle">
                        Manage Fertilizer, Pesticide & Seed categories
                    </p>

                </div>
                <div class="col-md-7">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ request('name') }}"
                                    placeholder="Search category...">
                            </div>

                            <div class="col-md-3">
                                <select name="is_active" class="form-select">
                                    <option value="">All</option>
                                    <option value="1" @selected(request('is_active') == '1')>
                                        Active
                                    </option>
                                    <option value="0" @selected(request('is_active') == '0')>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search me-1"></i> Search
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-secondary">
                                    <i class="fa fa-refresh me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-2 text-end">
                    <!-- CREATE BUTTON -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fa fa-plus me-1"></i>
                        Add Category
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Is Active</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $trow)
                            <tr>
                                <td>{{ $records->firstItem() + $loop->index }}</td>
                                <td>{{ $trow->name }}</td>
                                <td>
                                   <x-is-active :isActive="$trow->is_active" />
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            onclick="editCategory({{ $trow->id }},'{{ $trow->name }}','{{ $trow->is_active }}')">

                                        <i class="fa fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $records->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name" value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Is Active</label>
                            <select name="is_active" class="form-select"id="">
                                <option value="1" @selected(old('is_active') == '1')>Active</option>
                                <option value="0" @selected(old('is_active') == '0')>Inactive</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    {{-- Edit Modal--}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <form id="edit_category_form" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Is Active</label>
                            <select name="is_active" class="form-select" id="edit_is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        function editCategory(id, name, is_active) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_is_active').value = is_active;

            let action = "{{ route('categories.update', ':id') }}";
            action = action.replace(':id', id);

            document.getElementById('edit_category_form').action = action;
        }
    </script>
@endpush