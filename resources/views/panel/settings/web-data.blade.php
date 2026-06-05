@extends('layouts.panel')

@section('title', 'Web Data Settings')

@section('content')

    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h4 class="page-title">
                        Web Data
                    </h4>
                    <p class="page-subtitle">
                        Manage website information and configuration details
                    </p>
                </div>

                <div class="col-lg-6 text-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">

        <!-- WEBSITE INFO CARD -->
        <div class="col-lg-4 mb-3">

            <div class="card table-card h-100">

                <div class="card-body text-center">

                    <img src="{{ asset('assets/images/logo.jpg') }}"
                         class="img-fluid rounded-circle shadow mb-3"
                         width="120"
                         alt="Logo">

                    <h3 class="fw-bold mb-1">
                        TASPRO
                    </h3>

                    <p class="text-muted mb-1">
                        Super Admin
                    </p>

                    <p class="mb-4">
                        <i class="fa fa-phone me-1"></i>
                        1234567891
                    </p>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Website :</strong>
                        <span>https://taskpro.itmingo.com</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <strong>Web Version :</strong>
                        <span>1.0</span>
                    </div>

                </div>

            </div>

        </div>

        <!-- FORM CARD -->
        <div class="col-lg-8">

            <div class="card table-card">
                <div class="card-body">

                    <form action="{{ route('settings.web.data.update') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Website Name</label>
                                <input type="text"
                                    name="app_name"
                                    class="form-control"
                                    value="{{ old('app_name', getSetting('app_name')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Website URL</label>
                                <input type="url"
                                    name="app_url"
                                    class="form-control"
                                    value="{{ old('app_url', getSetting('app_url')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Mobile No</label>
                                <input type="text"
                                    name="app_phone"
                                    class="form-control"
                                    value="{{ old('app_phone', getSetting('app_phone')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Alt Mobile No</label>
                                <input type="text"
                                    name="app_alt_phone"
                                    class="form-control"
                                    value="{{ old('app_alt_phone', getSetting('app_alt_phone')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email"
                                    name="app_email"
                                    class="form-control"
                                    value="{{ old('app_email', getSetting('app_email')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Page Limit</label>
                                <input type="number"
                                    name="page_limit"
                                    class="form-control"
                                    value="{{ old('page_limit', getSetting('page_limit')) }}">
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Address</label>
                                <textarea name="app_address"
                                        class="form-control"
                                        rows="3">{{ old('app_address', getSetting('app_address')) }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Footer Text</label>
                                <textarea name="app_footer_text"
                                        class="form-control"
                                        rows="2">{{ old('app_footer_text', getSetting('app_footer_text')) }}</textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save me-1"></i>
                                    Save Changes
                                </button>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection