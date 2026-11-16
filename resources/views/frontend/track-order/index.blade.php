@extends('frontend.layouts.app')

@section('title', 'Track Your Order | MarketPro')

@section('content')

<section class="track-hero">
    <div class="container">

        <div class="track-icon">
            <i class="fas fa-shipping-fast"></i>
        </div>

        <h1>Track Your Order</h1>

        <p>
            Enter your order details below to check your
            order status and delivery progress.
        </p>

    </div>
</section>

<section class="track-section">
    <div class="container">

        <div class="track-card">

            <div class="track-card-header">
                <h2>Order Tracking</h2>
                <p>Enter your Order Number and Phone Number.</p>
            </div>

            @if(session('error'))
                <div class="track-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('track-order.track') }}" method="POST">
                @csrf

                <div class="track-form-group">
                    <label for="order_number">Order Number</label>

                    <div class="track-input">
                        <i class="fas fa-receipt"></i>

                        <input
                            type="text"
                            id="order_number"
                            name="order_number"
                            value="{{ old('order_number') }}"
                            placeholder="Enter your order number"
                            required
                        >
                    </div>

                    @error('order_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="track-form-group">
                    <label for="phone">Phone Number</label>

                    <div class="track-input">
                        <i class="fas fa-phone"></i>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Enter your order phone number"
                            required
                        >
                    </div>

                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="track-submit-btn">
                    <i class="fas fa-search"></i>
                    Track Order
                </button>

            </form>

            <div class="track-help">
                <i class="fas fa-info-circle"></i>
                Please use the same phone number provided during checkout.
            </div>

        </div>

    </div>
</section>

@endsection
