@extends('frontend.layouts.app')

@section('title', 'Order Details | MarketPro')

@section('content')

<section class="orders-hero">
    <div class="container">

        <span>ORDER INFORMATION</span>

        <h1>Order Details</h1>

        <p>Review your order information and purchased products.</p>

        <div class="orders-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <i class="fas fa-angle-right"></i>
            <a href="{{ route('orders.index') }}">My Orders</a>
            <i class="fas fa-angle-right"></i>
            <span>Order Details</span>
        </div>

    </div>
</section>


<section class="order-details-section">
    <div class="container">

        {{-- Order Header --}}
        <div class="order-details-header">

            <div>
                <span>ORDER NUMBER</span>
                <h2>#{{ $order->order_number }}</h2>

                <p>
                    Placed on
                    {{ ($order->placed_at ?? $order->created_at)->format('d M, Y h:i A') }}
                </p>
            </div>

            <a href="{{ route('orders.index') }}" class="back-orders-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Orders
            </a>

        </div>


        <div class="order-details-grid">

            {{-- Left Side --}}
            <div class="order-details-main">

                {{-- Products --}}
                <div class="details-box">

                    <h3>
                        <i class="fas fa-box-open"></i>
                        Ordered Products
                    </h3>

                    @forelse($order->items as $item)

                        <div class="details-product">

                            @if($item->product && $item->product->thumbnail)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($item->product->thumbnail) }}"
                                    alt="{{ $item->product_name }}"
                                >
                            @else
                                <div class="order-product-placeholder">
                                    <i class="fas fa-box"></i>
                                </div>
                            @endif

                            <div class="details-product-info">

                                <h4>{{ $item->product_name }}</h4>

                                <p>SKU: {{ $item->product_sku ?: 'N/A' }}</p>

                                <p>Quantity: {{ $item->quantity }}</p>

                                <span>
                                    ৳{{ number_format((float)$item->price, 2) }}
                                    × {{ $item->quantity }}
                                </span>

                            </div>

                            <div class="details-product-total">
                                ৳{{ number_format((float)$item->total, 2) }}
                            </div>

                        </div>

                    @empty

                        <p>No products found in this order.</p>

                    @endforelse

                </div>


                {{-- Shipping Address --}}
                <div class="details-box">

                    <h3>
                        <i class="fas fa-map-marker-alt"></i>
                        Shipping Information
                    </h3>

                    <div class="shipping-details">

                        <h4>{{ $order->shipping_name }}</h4>

                        <p>
                            <i class="fas fa-phone"></i>
                            {{ $order->shipping_phone }}
                        </p>

                        @if($order->shipping_email)
                            <p>
                                <i class="fas fa-envelope"></i>
                                {{ $order->shipping_email }}
                            </p>
                        @endif

                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $order->shipping_address }},
                            {{ $order->shipping_city }}

                            @if($order->shipping_state)
                                , {{ $order->shipping_state }}
                            @endif

                            @if($order->shipping_postal_code)
                                - {{ $order->shipping_postal_code }}
                            @endif

                            , {{ $order->shipping_country }}
                        </p>

                    </div>

                </div>


                {{-- Customer Note --}}
                @if($order->customer_note)

                    <div class="details-box">

                        <h3>
                            <i class="fas fa-sticky-note"></i>
                            Your Note
                        </h3>

                        <p>{{ $order->customer_note }}</p>

                    </div>

                @endif

            </div>


            {{-- Right Side --}}
            <div class="order-details-sidebar">

                {{-- Order Summary --}}
                <div class="details-box">

                    <h3>Order Summary</h3>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>৳{{ number_format((float)$order->subtotal, 2) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Discount</span>
                        <strong class="discount-text">
                            - ৳{{ number_format((float)$order->discount_amount, 2) }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Shipping Charge</span>
                        <strong>৳{{ number_format((float)$order->shipping_charge, 2) }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Tax</span>
                        <strong>৳{{ number_format((float)$order->tax_amount, 2) }}</strong>
                    </div>

                    <div class="summary-total">
                        <span>Total Amount</span>
                        <strong>
                            ৳{{ number_format((float)$order->total_amount, 2) }}
                        </strong>
                    </div>

                </div>


                {{-- Payment Information --}}
                <div class="details-box">

                    <h3>
                        <i class="fas fa-credit-card"></i>
                        Payment Information
                    </h3>

                    <div class="summary-row">
                        <span>Method</span>
                        <strong>
                            {{ $order->payment_method
                                ? ucfirst(str_replace('_', ' ', $order->payment_method))
                                : 'N/A' }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Payment Status</span>

                        <strong class="payment-status-text">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Transaction ID</span>

                        <strong>
                            {{ $order->transaction_id ?: 'N/A' }}
                        </strong>
                    </div>

                </div>


                {{-- Order Status --}}
                <div class="details-box">

                    <h3>
                        <i class="fas fa-truck"></i>
                        Order Status
                    </h3>

                    <div class="order-status-timeline">

                        <div class="timeline-item completed">
                            <span class="timeline-dot"></span>

                            <div>
                                <h4>Order Placed</h4>
                                <p>
                                    {{ ($order->placed_at ?? $order->created_at)->format('d M, Y h:i A') }}
                                </p>
                            </div>
                        </div>


                        @if(in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']))
                            <div class="timeline-item completed">
                                <span class="timeline-dot"></span>
                                <div>
                                    <h4>Order Confirmed / Processing</h4>
                                    <p>Your order is being prepared.</p>
                                </div>
                            </div>
                        @endif


                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="timeline-item completed">
                                <span class="timeline-dot"></span>
                                <div>
                                    <h4>Shipped</h4>
                                    <p>
                                        {{ $order->shipped_at
                                            ? $order->shipped_at->format('d M, Y h:i A')
                                            : 'Your order has been shipped.' }}
                                    </p>
                                </div>
                            </div>
                        @endif


                        @if($order->status === 'delivered')
                            <div class="timeline-item completed">
                                <span class="timeline-dot"></span>
                                <div>
                                    <h4>Delivered</h4>
                                    <p>
                                        {{ $order->delivered_at
                                            ? $order->delivered_at->format('d M, Y h:i A')
                                            : 'Order delivered successfully.' }}
                                    </p>
                                </div>
                            </div>
                        @endif


                        @if($order->status === 'cancelled')
                            <div class="timeline-item cancelled">
                                <span class="timeline-dot"></span>
                                <div>
                                    <h4>Order Cancelled</h4>
                                    <p>
                                        {{ $order->cancelled_at
                                            ? $order->cancelled_at->format('d M, Y h:i A')
                                            : 'This order has been cancelled.' }}
                                    </p>
                                </div>
                            </div>
                        @endif


                        @if($order->status === 'returned')
                            <div class="timeline-item cancelled">
                                <span class="timeline-dot"></span>
                                <div>
                                    <h4>Order Returned</h4>
                                    <p>This order has been returned.</p>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
