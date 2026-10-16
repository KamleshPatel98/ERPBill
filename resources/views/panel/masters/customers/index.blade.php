@extends('layouts.panel')

@section('title', 'Customer Master')

@section('content')

<!-- HEADER -->
<div class="card page-card mb-3">
    <div class="card-body">
        <div class="row align-items-center">

            <div class="col-md-3">
                <h4 class="page-title">Customer Master</h4>
                <p class="page-subtitle">Manage Customers</p>
            </div>

            <div class="col-md-7">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-2 align-items-end">

                        <div class="col-md-5">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search name / mobile / address...">
                        </div>

                        <div class="col-md-3">
                            <select name="is_active" class="form-select">
                                <option value="">All</option>
                                <option value="1" @selected(request('is_active') == '1')>Active</option>
                                <option value="0" @selected(request('is_active') == '0')>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                            </button>

                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-md-2 text-end">
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createCustomerModal">
                    <i class="fa fa-plus me-1"></i> Add New
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
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($records as $trow)

                        <tr>
                            <td>{{ $records->firstItem() + $loop->index }}</td>

                            <td>{{ $trow->name }}</td>

                            <td>{{ $trow->mobile }}</td>

                            <td>{{ $trow->address }}</td>

                            <td>
                                <x-is-active :isActive="$trow->is_active" />
                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCustomerModal"
                                        onclick="editCustomer(
                                            '{{ $trow->id }}',
                                            '{{ $trow->name }}',
                                            '{{ $trow->mobile }}',
                                            '{{ $trow->address }}',
                                            '{{ $trow->is_active }}'
                                        )">

                                    <i class="fa fa-pen"></i>

                                </button>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                No Records Found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $records->links('pagination::bootstrap-5') }}

        </div>

    </div>
</div>

<!-- CREATE MODAL -->
<div class="modal fade" id="createCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Customer</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="form_mode" value="create">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control"
                               value="{{ old('mobile') }}">
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Is Active</label>
                        <select name="is_active" class="form-select">
                            <option value="1" @selected(old('is_active') == '1')>Active</option>
                            <option value="0" @selected(old('is_active') == '0')>Inactive</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="edit_customer_form" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id" name="id" value="{{ old('id') }}">
                    <input type="hidden" name="form_mode" value="edit">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="edit_name" name="name" value="{{ old('name') }}"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" id="edit_mobile" name="mobile" value="{{ old('mobile') }}"class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea id="edit_address" name="address" class="form-control">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Is Active</label>
                        <select id="edit_is_active" name="is_active" class="form-select">
                            <option value="1" @selected(old('is_active') == '1')>Active</option>
                            <option value="0" @selected(old('is_active') == '1')>Inactive</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection

@push('script')
<script>

function editCustomer(id, name, mobile, address, is_active)
{
    $('#edit_id').val(id);
    $('#edit_name').val(name);
    $('#edit_mobile').val(mobile);
    $('#edit_address').val(address);
    $('#edit_is_active').val(is_active);

    let action = "{{ route('customers.update', ':id') }}";
    action = action.replace(':id', id);

    $('#edit_customer_form').attr('action', action);

    $('#editCustomerModal').modal('show');
}

$(function () {

    @if ($errors->any() && old('form_mode') === 'create')
        $('#createCustomerModal').modal('show');
    @endif

    @if ($errors->any() && old('form_mode') === 'edit')
        let id = "{{ old('id') }}";

        let action = "{{ route('customers.update', ':id') }}";
        action = action.replace(':id', id);

        $('#edit_customer_form').attr('action', action);

        $('#editCustomerModal').modal('show');
    @endif

});

</script>
@endpush