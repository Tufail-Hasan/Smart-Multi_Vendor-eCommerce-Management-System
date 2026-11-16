@extends('frontend.layouts.app')

@section('title', 'Order Tracking Result | MarketPro')

@section('content')

@php
    $order = $shipping->order;

    $steps = [
        'pending' => 'Order Placed',
        'ready_to_ship' => 'Ready to Ship',
        'shipped' => 'Shipped',
        'in_transit' => 'In Transit',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
    ];

    $completedSteps = array_keys($steps);

    $currentStep = array_search($shipping->status, $completedSteps);

    $failedStatuses = ['failed', 'returned', 'cancelled'];

    $isFailed = in_array($shipping->status, $failedStatuses);

@endphp

<section class="track-result-section">

    <div class="container">

        <div class="track-result-header">

            <div>
                <span class="track-success-label">
                    <i class="fas fa-check-circle"></i>
                    Order Found
                </span>

                <h1>Order Tracking Details</h1>

                <p>Here is the latest information about your order.</p>
            </div>

            <a href="{{ route('track-order.index') }}" class="track-again-btn">
                <i class="fas fa-search"></i>
                Track Another Order
            </a>

        </div>


        {{-- Order Summary --}}

        <div class="tracking-summary">

            <div>
                <span>Order Number</span>
                <h3>{{ $order->order_number }}</h3>
            </div>

            <div>
                <span>Shipping Number</span>
                <h3>{{ $shipping->shipping_number }}</h3>
            </div>

            <div>
                <span>Order Date</span>
                <h3>
                    {{ $order->placed_at?->format('d M Y') ?? $order->created_at?->format('d M Y') }}
                </h3>
            </div>

            <div>
                <span>Order Amount</span>
                <h3>৳{{ number_format($order->total_amount, 2) }}</h3>
            </div>

        </div>


        {{-- Shipping Status --}}

        <div class="tracking-card">

            <h2>
                <i class="fas fa-shipping-fast"></i>
                Delivery Progress
            </h2>

            <div class="tracking-current-status">

                <span>Current Shipping Status</span>

                <strong class="status-{{ $shipping->status }}">
                    {{ ucwords(str_replace('_', ' ', $shipping->status)) }}
                </strong>

            </div>


            @if($isFailed)

                <div class="tracking-warning">
                    <i class="fas fa-exclamation-triangle"></i>

                    Your shipment is currently
                    {{ str_replace('_', ' ', $shipping->status) }}.
                    Please contact our support team for assistance.
                </div>

            @else

                <div class="tracking-timeline">

                    @foreach($steps as $key => $label)

                        @php
                            $stepIndex = array_search($key, $completedSteps);

                            $isCompleted = $currentStep !== false
                                && $stepIndex <= $currentStep;
                        @endphp

                        <div class="tracking-step {{ $isCompleted ? 'completed' : '' }}">

                            <div class="tracking-step-icon">

                                @if($isCompleted)
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="fas fa-circle"></i>
                                @endif

                            </div>

                            <div class="tracking-step-content">
                                <h4>{{ $label }}</h4>

                                @if($key === 'shipped' && $shipping->shipped_at)
                                    <p>{{ $shipping->shipped_at->format('d M Y, h:i A') }}</p>

                                @elseif($key === 'delivered' && $shipping->delivered_at)
                                    <p>{{ $shipping->delivered_at->format('d M Y, h:i A') }}</p>

                                @endif
                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>


        {{-- Shipping Information --}}

        <div class="tracking-details-grid">

            <div class="tracking-card">

                <h2>
                    <i class="fas fa-truck"></i>
                    Shipping Information
                </h2>

                <div class="tracking-info-row">
                    <span>Courier</span>
                    <strong>{{ $shipping->courier_name ?? 'Not Assigned' }}</strong>
                </div>

                <div class="tracking-info-row">
                    <span>Tracking Number</span>
                    <strong>{{ $shipping->tracking_number ?? 'Not Available' }}</strong>
                </div>

                <div class="tracking-info-row">
                    <span>Shipping Method</span>
                    <strong>{{ $shipping->shipping_method ?? 'Standard Delivery' }}</strong>
                </div>

                <div class="tracking-info-row">
                    <span>Estimated Delivery</span>
                    <strong>
                        {{ $shipping->estimated_delivery_at?->format('d M Y') ?? 'Not Available' }}
                    </strong>
                </div>

            </div>


            <div class="tracking-card">

                <h2>
                    <i class="fas fa-map-marker-alt"></i>
                    Delivery Address
                </h2>

                <div class="delivery-address">

                    <h4>{{ $shipping->recipient_name }}</h4>

                    <p>{{ $shipping->recipient_phone }}</p>

                    <p>{{ $shipping->recipient_email }}</p>

                    <p>{{ $shipping->address }}</p>

                    <p>
                        {{ $shipping->city }}

                        @if($shipping->state)
                            , {{ $shipping->state }}
                        @endif

                        @if($shipping->postal_code)
                            - {{ $shipping->postal_code }}
                        @endif
                    </p>

                    <p>{{ $shipping->country }}</p>

                </div>

            </div>

        </div>


        {{-- Order Items --}}

        <div class="tracking-card tracking-items-card">

            <h2>
                <i class="fas fa-shopping-bag"></i>
                Ordered Products
            </h2>

            @foreach($order->items as $item)

                <div class="tracking-product">

                    <div class="tracking-product-image">

                        @if($item->product && $item->product->thumbnail)
                            <img
                                src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                alt="{{ $item->product_name }}"
                            >
                        @else
                            <i class="fas fa-box"></i>
                        @endif

                    </div>

                    <div class="tracking-product-info">

                        <h4>{{ $item->product_name }}</h4>

                        <p>SKU: {{ $item->product_sku ?? 'N/A' }}</p>

                        <p>Quantity: {{ $item->quantity }}</p>

                    </div>

                    <div class="tracking-product-price">
                        ৳{{ number_format($item->total, 2) }}
                    </div>

                </div>

            @endforeach

            <div class="tracking-total">
                <span>Total Amount</span>
                <strong>৳{{ number_format($order->total_amount, 2) }}</strong>
            </div>

        </div>


        <div class="tracking-support">

            <i class="fas fa-headset"></i>

            <div>
                <h3>Need Help With Your Order?</h3>
                <p>Contact our support team if you have any questions.</p>
            </div>

            <a href="{{ route('contact.index') }}">
                Contact Support
            </a>

        </div>

    </div>

</section>

@endsection
