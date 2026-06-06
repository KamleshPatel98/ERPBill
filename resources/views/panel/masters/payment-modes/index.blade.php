@extends('layouts.panel')

@section('title', 'Payment Mode Master')

@section('content')

<!-- HEADER -->
<div class="card page-card mb-3">
    <div class="card-body">
        <div class="row align-items-center">

            <div class="col-md-3">
                <h4 class="page-title">Payment Mode Master</h4>
                <p class="page-subtitle">Manage Payment Modes</p>
            </div>

            <div class="col-md-7">
                <form action="{{ url()->current() }}" method="GET">

                    <div class="row g-2 align-items-end">

                        <div class="col-md-5">
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ request('name') }}"
                                   placeholder="Search payment mode">
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
                                <i class="fa fa-search me-1"></i>
                                Search
                            </button>

                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                <i class="fa fa-refresh me-1"></i>
                                Reset
                            </a>
                        </div>

                    </div>

                </form>
            </div>

            <div class="col-md-2 text-end">
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createPaymentModeModal">
                    <i class="fa fa-plus me-1"></i>
                    Add New
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
                        <th width="80">#</th>
                        <th>Name</th>
                        <th width="150">Is Active</th>
                        <th width="120" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($records as $trow)

                        <tr>

                            <td>{{ $records->firstItem() + $loop->index }}</td>

                            <td>{{ $trow->name }}</td>

                            <td>
                                <x-is-active :isActive="$trow->is_active" />
                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success"
                                        onclick="editPaymentMode(
                                            '{{ $trow->id }}',
                                            '{{ $trow->name }}',
                                            '{{ $trow->is_active }}'
                                        )">

                                    <i class="fa fa-pen"></i>

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No Records Found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-3">
            {{ $records->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

<!-- CREATE MODAL -->
<div class="modal fade" id="createPaymentModeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Add Payment Mode
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('payment-modes.store') }}"
                      method="POST">

                    @csrf

                    <input type="hidden"
                           name="form_mode"
                           value="create">

                    <div class="mb-3">
                        <label class="form-label">
                            Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="Cash">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Is Active
                        </label>

                        <select name="is_active"
                                class="form-select">

                            <option value="1"
                                    @selected(old('is_active', 1) == 1)>
                                Active
                            </option>

                            <option value="0"
                                    @selected(old('is_active') === '0')>
                                Inactive
                            </option>

                        </select>

                    </div>

                    <div class="text-end">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editPaymentModeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Payment Mode
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form id="edit_payment_mode_form"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <input type="hidden"
                           id="edit_id"
                           name="id"
                           value="{{ old('id') }}">

                    <input type="hidden"
                           name="form_mode"
                           value="edit">

                    <div class="mb-3">

                        <label class="form-label">
                            Name
                        </label>

                        <input type="text"
                               id="edit_name"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Is Active
                        </label>

                        <select id="edit_is_active"
                                name="is_active"
                                class="form-select">

                            <option value="1"
                                @selected(old('is_active') == '1')>
                                Active
                            </option>

                            <option value="0"
                                @selected(old('is_active') == '0')>
                                Inactive
                            </option>

                        </select>

                    </div>

                    <div class="text-end">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                                class="btn btn-success">
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

    function editPaymentMode(id, name, is_active)
    {
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_is_active').val(is_active);

        let action = "{{ route('payment-modes.update', ':id') }}";
        action = action.replace(':id', id);

        $('#edit_payment_mode_form').attr('action', action);

        $('#editPaymentModeModal').modal('show');
    }

    $(function () {

        @if($errors->any() && old('form_mode') === 'create')
            $('#createPaymentModeModal').modal('show');
        @endif

        @if($errors->any() && old('form_mode') === 'edit')

            let id = "{{ old('id') }}";

            let action = "{{ route('payment-modes.update', ':id') }}";
            action = action.replace(':id', id);

            $('#edit_payment_mode_form').attr('action', action);

            $('#editPaymentModeModal').modal('show');

        @endif

    });

</script>
@endpush