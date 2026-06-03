@extends('layouts.panel')

@section('title', 'Category Master')

@section('content')
    <!-- HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h4 class="page-title">
                        Category Master
                    </h4>

                    <p class="page-subtitle">
                        Manage Fertilizer, Pesticide & Seed categories
                    </p>

                </div>

                <div class="col-md-6 text-end">

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
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- ROW 1 -->
                        <tr>
                            <td>1</td>
                            <td>Fertilizer</td>
                            <td>All fertilizer products</td>
                            <td><span class="badge-active">Active</span></td>
                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success action-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        onclick="editCategory(1,'Fertilizer','All fertilizer products')">

                                    <i class="fa fa-pen"></i>
                                </button>

                                <button class="btn btn-sm btn-outline-danger action-btn">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>

                        <!-- ROW 2 -->
                        <tr>
                            <td>2</td>
                            <td>Pesticide</td>
                            <td>Crop protection chemicals</td>
                            <td><span class="badge-active">Active</span></td>
                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success action-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        onclick="editCategory(2,'Pesticide','Crop protection chemicals')">

                                    <i class="fa fa-pen"></i>
                                </button>

                                <button class="btn btn-sm btn-outline-danger action-btn">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>

                    </tbody>

                </table>

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

                    <form>

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" placeholder="Enter category name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
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

                    <form>

                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" id="edit_desc"></textarea>
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
        function editCategory(id, name, desc){
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_desc').value = desc;
        }
    </script>
@endpush