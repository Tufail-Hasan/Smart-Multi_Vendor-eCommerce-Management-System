@extends('frontend.layouts.app')

@section('title', 'My Account - MarketPro')

@section('content')

<section class="dashboard-section">

    <div class="dashboard-container">

        <div class="dashboard-welcome">
            <div>
                <h1>Hello, {{ $customer->full_name }}!</h1>
                <p>Welcome to your MarketPro account.</p>
            </div>

            <form action="{{ route('account.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <div class="dashboard-grid">

            <div class="dashboard-card">
                <i class="fas fa-shopping-bag"></i>
                <h3>{{ $customer->total_orders }}</h3>
                <p>Total Orders</p>
            </div>

            <div class="dashboard-card">
                <i class="fas fa-wallet"></i>
                <h3>৳{{ number_format((float) $customer->total_spent, 2) }}</h3>
                <p>Total Spent</p>
            </div>

            <div class="dashboard-card">
                <i class="fas fa-user-check"></i>
                <h3>{{ ucfirst($customer->status) }}</h3>
                <p>Account Status</p>
            </div>

        </div>

        <div class="dashboard-profile">
            <h2>My Profile Information</h2>

            <div class="profile-info">
                <p><strong>Full Name:</strong> {{ $customer->full_name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Phone:</strong> {{ $customer->phone ?? 'Not provided' }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($customer->gender ?? 'Not provided') }}</p>
                <p><strong>Date of Birth:</strong>
                    {{ $customer->date_of_birth?->format('d M, Y') ?? 'Not provided' }}
                </p>
            </div>
        </div>

    </div>

</section>

@endsection
