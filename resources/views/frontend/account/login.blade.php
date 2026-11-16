@extends('frontend.layouts.app')

@section('title', 'Customer Login - MarketPro')

@section('content')

<section class="account-section">
    <div class="account-container">

        <div class="account-header">
            <h1>Welcome Back!</h1>
            <p>Login to your MarketPro account</p>
        </div>

        @if(session('success'))
            <div class="account-alert success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="account-alert error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('account.login.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                       placeholder="Enter your password" required>
            </div>

            <button type="submit" class="account-btn">
                Login to Account
            </button>
        </form>

        <div class="account-footer">
            Don't have an account?
            <a href="{{ route('account.register') }}">Create Account</a>
        </div>

    </div>
</section>

@endsection
