@extends('layouts.panel')

@section('title', 'Financial Year Master')

@section('content') 
<!-- HEADER --> 
<div class="card page-card mb-3">
    <div class="card-body"> 
        <div class="row align-items-center">

            <div class="col-md-3">
                <h4 class="page-title">
                    Financial Year Master
                </h4>
                <p class="page-subtitle">
                    Manage Financial Years
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
                                   placeholder="Search financial year...">
                        </div>

                        <div class="col-md-3">
                            <select name="is_active" class="form-select">
                                <option value="">All</option>

                                <option value="1"
                                        @selected(request('is_active') == '1')>
                                    Active
                                </option>

                                <option value="0"
                                        @selected(request('is_active') == '0')>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search me-1"></i>
                                Search
                            </button>

                            <a href="{{ url()->current() }}"
                               class="btn btn-secondary">
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
                        data-bs-target="#createFinancialYearModal">
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
                        <th>#</th>
                        <th>Financial Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $trow)

                        <tr>
                            <td>
                                {{ $records->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $trow->name }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($trow->start_date)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($trow->end_date)->format('d-m-Y') }}
                            </td>

                            <td>
                                <x-is-active :isActive="$trow->is_active" />
                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-outline-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editFinancialYearModal"
                                        onclick="editFinancialYear(
                                            '{{ $trow->id }}',
                                            '{{ $trow->name }}',
                                            '{{ $trow->start_date }}',
                                            '{{ $trow->end_date }}',
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
<div class="modal fade"
     id="createFinancialYearModal"
     tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Add Financial Year
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('financial-years.store') }}"
                      method="POST">

                    @csrf

                    <input type="hidden"
                           name="form_mode"
                           value="create">

                    <div class="mb-3">
                        <label class="form-label">
                            Financial Year <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="2025-26" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Start Date  <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="start_date"
                               class="form-control datepicker"
                               autocomplete="OFF"
                               value="{{ old('start_date') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            End Date  <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="end_date"
                               class="form-control datepicker"
                               autocomplete="OFF"
                               value="{{ old('end_date') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Is Active
                        </label>

                        <select name="is_active"
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
<div class="modal fade"
     id="editFinancialYearModal"
     tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Financial Year
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <form id="edit_financial_year_form"
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
                            Financial Year
                        </label>

                        <input type="text"
                               id="edit_name"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Start Date
                        </label>

                        <input type="text"
                               id="edit_start_date"
                               name="start_date"
                               class="form-control datepicker"
                               autocomplete="OFF"
                               value="{{ old('start_date') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            End Date
                        </label>

                        <input type="text"
                               id="edit_end_date"
                               name="end_date"
                               class="form-control datepicker"
                               autocomplete="OFF"
                               value="{{ old('end_date') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Is Active
                        </label>

                        <select id="edit_is_active"
                                name="is_active"
                                class="form-select">

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
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
```

@endsection

@push('script')

<script>
    function editFinancialYear(
        id,
        name,
        start_date,
        end_date,
        is_active
    ) {
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_start_date').val(start_date);
        $('#edit_end_date').val(end_date);
        $('#edit_is_active').val(is_active);

        const action =
            "{{ route('financial-years.update', ':id') }}"
                .replace(':id', id);

        $('#edit_financial_year_form')
            .attr('action', action);
    }

    $(function () {
        @if ($errors->any() && old('form_mode') === 'create')
            $('#createFinancialYearModal').modal('show');
        @endif
        @if ($errors->any() && old('form_mode') === 'edit')
            const id = "{{ old('id') }}";
            $('#edit_financial_year_form').attr(
                'action',
                "{{ route('financial-years.update', ':id') }}"
                    .replace(':id', id)
            );
            $('#editFinancialYearModal').modal('show');
        @endif
    });
</script>

@endpush

<x-datepicker />