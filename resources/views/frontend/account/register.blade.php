@extends('frontend.layouts.app')

@section('title', 'Create Account - MarketPro')

@section('content')

<section class="account-section">
    <div class="account-container">

        <div class="account-header">
            <h1>Create Your Account</h1>
            <p>Join MarketPro and enjoy shopping</p>
        </div>

        @if($errors->any())
            <div class="account-alert error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('account.register.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>First Name *</label>
                <input type="text" name="first_name"
                       value="{{ old('first_name') }}"
                       placeholder="First name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name"
                       value="{{ old('last_name') }}"
                       placeholder="Last name">
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password"
                       placeholder="Minimum 8 characters" required>
            </div>

            <div class="form-group">
                <label>Confirm Password *</label>
                <input type="password" name="password_confirmation"
                       placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="account-btn">
                Create Account
            </button>
        </form>

        <div class="account-footer">
            Already have an account?
            <a href="{{ route('account.login') }}">Login</a>
        </div>

    </div>
</section>

@endsection
