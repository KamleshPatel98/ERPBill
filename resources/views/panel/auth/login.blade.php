@extends('layouts.auth')

@section('title', 'Login Form')

@section('content')
    <p class="text-center small-text mb-3">
        Sign in to manage inventory, stock & sales
    </p>

    <!-- LOGIN FORM -->
    <form action="{{ route('auth.login.submit') }}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="text" name="email" class="form-control" placeholder="Enter email" value="{{ old('email', Cache::get('remember_email')) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control" placeholder="Enter password" value="{{ old('password') }}" required>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-3 small-text">
            <label>
                <input type="checkbox" name="remember_me" value="1" {{ Cache::has('remember_email') ? 'checked' : '' }}> Remember me
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>
    </form>
@endsection