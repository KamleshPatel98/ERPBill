@extends('layouts.panel')

@section('title', "Create / Edit Supplier")

@section('content')

<!-- PAGE HEADER -->
<div class="card page-card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title">{{ isset($supplier) ? 'Edit Supplier' : 'Add New Supplier' }}</h4>
                <p class="page-subtitle">Supplier registration form</p>
            </div>

            <div class="col-lg-6 text-end">
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="card table-card">
    <div class="card-body">

        <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST">
            @csrf
            @if(isset($supplier))
                @method('PUT')
            @endif

            <div class="row g-3">

                <!-- Name -->
                <div class="col-md-3">
                    <label class="form-label">Supplier Name *</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $supplier->name ?? '') }}"
                        placeholder="Enter supplier name" required>
                </div>

                <!-- Mobile -->
                <div class="col-md-3">
                    <label class="form-label">Mobile *</label>
                    <input type="text" name="mobile" class="form-control"
                        value="{{ old('mobile', $supplier->mobile ?? '') }}"
                        maxlength="10" placeholder="10-digit mobile number" required>
                </div>

                <!-- Email -->
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $supplier->email ?? '') }}"
                        placeholder="example@mail.com">
                </div>

                <!-- GST -->
                <div class="col-md-3">
                    <label class="form-label">GST Number</label>
                    <input type="text" name="gst_no" class="form-control"
                        value="{{ old('gst_no', $supplier->gst_no ?? '') }}"
                        placeholder="GST Number">
                </div>

                <!-- Address -->
                <div class="col-12">
                    <label class="form-label">Address *</label>
                    <textarea name="address" class="form-control" rows="3"
                        placeholder="Full address" required>{{ old('address', $supplier->address ?? '') }}</textarea>
                </div>

                <!-- City -->
                <div class="col-md-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ old('city', $supplier->city ?? '') }}" class="form-control">
                </div>

                <!-- State -->
                <div class="col-md-3">
                    <label class="form-label">State</label>
                    <select name="state_id" class="form-select">
                        <option value="">Select State</option>
                        @foreach($states ?? [] as $state)
                            <option value="{{ $state->id }}" @selected(old('state_id', $supplier->state_id ?? '') == $state->id)>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Zip -->
                <div class="col-md-3">
                    <label class="form-label">ZIP Code</label>
                    <input type="text" name="zip" value="{{ old('zip', $supplier->zip ?? '') }}"class="form-control">
                </div>

                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" @selected(old('is_Active', $supplier->is_active ?? '') == 1)>Active</option>
                        <option value="0" @selected(old('is_Active', $supplier->is_active ?? '') == 0)>Inactive</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-12 text-end">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fa fa-refresh me-1"></i>
                        Reset
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>
                        Save Supplier
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection

<x-dropdown />