@extends('frontend.layouts.app')

@section('title', 'My Orders | MarketPro')

@section('content')

<section class="orders-hero">
    <div class="container">
        <span>MY ACCOUNT</span>
        <h1>My Orders</h1>
        <p>Manage and track all your purchases in one place.</p>

        <div class="orders-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <i class="fas fa-angle-right"></i>
            <a href="{{ route('account.index') }}">My Account</a>
            <i class="fas fa-angle-right"></i>
            <span>My Orders</span>
        </div>
    </div>
</section>


<section class="my-orders-section">
    <div class="container">

        {{-- Order Statistics --}}
        <div class="order-stats-grid">

            <div class="order-stat-card">
                <div class="order-stat-icon purple">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <span>Total Orders</span>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>

            <div class="order-stat-card">
                <div class="order-stat-icon orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <span>Active Orders</span>
                    <h3>{{ $pendingOrders }}</h3>
                </div>
            </div>

            <div class="order-stat-card">
                <div class="order-stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <span>Completed Orders</span>
                    <h3>{{ $completedOrders }}</h3>
                </div>
            </div>

        </div>


        {{-- Orders List --}}
        <div class="orders-content-card">

            <div class="orders-card-header">
                <div>
                    <h2>Order History</h2>
                    <p>View your recent and previous orders.</p>
                </div>

                <a href="{{ route('shop') }}" class="continue-shopping-btn">
                    <i class="fas fa-shopping-bag"></i>
                    Continue Shopping
                </a>
            </div>


            @forelse($orders as $order)

                @php
                    $statusColors = [
                        'pending' => 'orange',
                        'confirmed' => 'blue',
                        'processing' => 'purple',
                        'shipped' => 'cyan',
                        'delivered' => 'green',
                        'cancelled' => 'red',
                        'returned' => 'gray',
                    ];

                    $paymentColors = [
                        'pending' => 'orange',
                        'paid' => 'green',
                        'failed' => 'red',
                        'refunded' => 'blue',
                        'partially_refunded' => 'purple',
                    ];

                    $statusColor = $statusColors[$order->status] ?? 'gray';
                    $paymentColor = $paymentColors[$order->payment_status] ?? 'gray';
                @endphp

                <div class="order-card">

                    {{-- Order Header --}}
                    <div class="order-card-header">

                        <div>
                            <span class="order-label">ORDER NUMBER</span>

                            <h3>#{{ $order->order_number }}</h3>

                            <span class="order-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ ($order->placed_at ?? $order->created_at)->format('d M, Y') }}
                            </span>
                        </div>

                        <div class="order-badges">

                            <span class="order-status {{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>

                            <span class="payment-status {{ $paymentColor }}">
                                Payment: {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>

                        </div>

                    </div>


                    {{-- Order Products --}}
                    <div class="order-products">

                        @foreach($order->items->take(3) as $item)

                            <div class="order-product-item">

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

                                <div class="order-product-info">
                                    <h4>{{ $item->product_name }}</h4>
                                    <p>Quantity: {{ $item->quantity }}</p>
                                    <span>৳{{ number_format((float)$item->price, 2) }}</span>
                                </div>

                            </div>

                        @endforeach

                        @if($order->items->count() > 3)
                            <div class="order-more-products">
                                +{{ $order->items->count() - 3 }} more products
                            </div>
                        @endif

                    </div>


                    {{-- Order Footer --}}
                    <div class="order-card-footer">

                        <div class="order-total">
                            <span>Total Amount</span>
                            <h3>৳{{ number_format((float)$order->total_amount, 2) }}</h3>
                        </div>

                        <a
                            href="{{ route('orders.show', $order->id) }}"
                            class="view-order-btn"
                        >
                            View Details
                            <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>

                </div>

            @empty

                <div class="orders-empty">

                    <div class="empty-order-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>

                    <h2>No Orders Yet!</h2>

                    <p>
                        You haven't placed any orders yet.
                        Start shopping and discover amazing products.
                    </p>

                    <a href="{{ route('shop') }}">
                        Start Shopping
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

            @endforelse


            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="orders-pagination">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>

    </div>
</section>

@endsection
