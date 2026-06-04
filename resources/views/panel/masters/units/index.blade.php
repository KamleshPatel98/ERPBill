@extends('layouts.panel')

@section('title', 'Units Master')

@section('content')

<!-- HEADER -->
<div class="card page-card mb-3">
    <div class="card-body">
        <div class="row align-items-center">

            <div class="col-md-3">
                <h4 class="page-title">
                    Units Master
                </h4>
                <p class="page-subtitle">
                    Manage Product Units (kg, gm, litre etc.)
                </p>
            </div>

            <div class="col-md-7">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-2 align-items-end">

                        <div class="col-md-5">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Search name or short name unit...">
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
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createUnitModal">
                    <i class="fa fa-plus me-1"></i>
                    Add Unit
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
                        <th>Unit Name</th>
                        <th>Short Name</th>
                        <th>Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($records as $trow)

                        <tr>
                            <td>{{ $records->firstItem() + $loop->index }}</td>

                            <td>{{ $trow->name }}</td>

                            <td>{{ $trow->short_name }}</td>

                            <td>
                                <x-is-active :isActive="$trow->is_active" />
                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUnitModal"
                                        onclick="editUnit(
                                            {{ $trow->id }},
                                            '{{ $trow->name }}',
                                            '{{ $trow->short_name }}',
                                            '{{ $trow->is_active }}'
                                        )">

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

<!-- CREATE MODAL -->
<div class="modal fade" id="createUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('units.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="form_mode" value="create">

                    <div class="mb-3">
                        <label>Unit Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="Kilogram">
                    </div>

                    <div class="mb-3">
                        <label>Short Name</label>
                        <input type="text"
                               name="short_name"
                               class="form-control"
                               value="{{ old('short_name') }}"
                               placeholder="kg">
                    </div>

                    <div class="mb-3">
                        <label>Is Active</label>
                        <select name="is_active" class="form-select">
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

<!-- EDIT MODAL -->
<div class="modal fade" id="editUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="edit_unit_form" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id" value="{{ old('id') }}">
                    <input type="hidden" name="form_mode" value="edit">

                    <div class="mb-3">
                        <label>Unit Name</label>
                        <input type="text"
                               id="edit_name"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Short Name</label>
                        <input type="text"
                               id="edit_short_name"
                               name="short_name"
                               value="{{ old('short_name') }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Is Active</label>
                        <select name="is_active"
                                id="edit_is_active"
                                class="form-select">

                            <option value="1" @selected(old('is_active') == 1)>Active</option>
                            <option value="0" @selected(old('is_active') == 0)>Inactive</option>

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
    function editUnit(id, name, short_name, is_active)
    {
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_short_name').val(short_name);
        $('#edit_is_active').val(is_active);

        let action = "{{ route('units.update', ':id') }}";
        action = action.replace(':id', id);

        $('#edit_unit_form').attr('action', action);

        $('#editUnitModal').modal('show');
    }

    $(function () {
        @if ($errors->any() && old('form_mode') === 'create')
            $('#createUnitModal').modal('show');
        @endif

        @if ($errors->any() && old('form_mode') === 'edit')
            const id = "{{ old('id') }}";

            $('#edit_unit_form').attr(
                'action',
                "{{ route('units.update', ':id') }}".replace(':id', id)
            );

            $('#editUnitModal').modal('show');
        @endif
    });
</script>
@endpush