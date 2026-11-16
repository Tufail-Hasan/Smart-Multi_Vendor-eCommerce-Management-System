@extends('frontend.layouts.app')

@section('title', 'Shopping Cart - MarketPro')

@section('content')

<section class="cart-section">

    <div class="cart-container">

        {{-- Cart Header --}}
        <div class="cart-header">
            <div>
                <span class="cart-subtitle">YOUR SHOPPING BAG</span>
                <h1>Shopping Cart</h1>
                <p>Review your selected products before checkout.</p>
            </div>

            <div class="cart-count">
                <i class="fas fa-shopping-cart"></i>
                {{ $cart->items->sum('quantity') }} Items
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="cart-alert success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="cart-alert error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="cart-alert error">
                {{ $errors->first() }}
            </div>
        @endif

        @if($cart->items->count() > 0)

            <div class="cart-layout">

                {{-- Cart Products --}}
                <div class="cart-products">

                    <div class="cart-products-header">
                        <h2>Cart Items</h2>

                        <form action="{{ route('cart.clear') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="clear-cart-btn">
                                <i class="fas fa-trash-alt"></i>
                                Clear Cart
                            </button>
                        </form>
                    </div>

                    @foreach($cart->items as $item)

                        @if($item->product)

                            @php
                                $product = $item->product;
                            @endphp

                            <div class="cart-item">

                                {{-- Product Image --}}
                                <div class="cart-item-image">
                                    <a href="{{ route('product.show', $product->slug) }}">

                                        @if($product->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                            >
                                        @else
                                            <img
                                                src="{{ asset('images/no-image.png') }}"
                                                alt="{{ $product->name }}"
                                            >
                                        @endif

                                    </a>
                                </div>

                                {{-- Product Details --}}
                                <div class="cart-item-details">

                                    <h3>
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <p class="cart-stock">
                                        @if($product->stock > 0)
                                            <i class="fas fa-check-circle"></i>
                                            In Stock
                                        @else
                                            <span class="out-of-stock">Out of Stock</span>
                                        @endif
                                    </p>

                                    <div class="cart-unit-price">
                                        ৳{{ number_format($product->current_price, 2) }}
                                    </div>

                                    {{-- Quantity Update --}}
                                    <form action="{{ route('cart.update', $item->id) }}"
                                          method="POST"
                                          class="quantity-form">

                                        @csrf
                                        @method('PUT')

                                        <label>Quantity:</label>

                                        <div class="quantity-control">

                                            <button type="button"
                                                    onclick="changeCartQuantity(this, -1)">
                                                −
                                            </button>

                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ $product->stock }}"
                                                required
                                            >

                                            <button type="button"
                                                    onclick="changeCartQuantity(this, 1)">
                                                +
                                            </button>

                                        </div>

                                        <button type="submit" class="update-cart-btn">
                                            Update
                                        </button>

                                    </form>

                                </div>

                                {{-- Item Total & Remove --}}
                                <div class="cart-item-actions">

                                    <strong class="cart-item-total">
                                        ৳{{ number_format($item->total_price, 2) }}
                                    </strong>

                                    <form action="{{ route('cart.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Remove this product from cart?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="remove-cart-btn">
                                            <i class="fas fa-trash-alt"></i>
                                            Remove
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endif

                    @endforeach

                    <a href="{{ route('shop') }}" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i>
                        Continue Shopping
                    </a>

                </div>

                {{-- Cart Summary --}}
                <div class="cart-summary">

                    <h2>Order Summary</h2>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>
                            ৳{{ number_format($cart->subtotal, 2) }}
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <strong>Calculated at checkout</strong>
                    </div>

                    <div class="summary-row">
                        <span>Tax</span>
                        <strong>Calculated at checkout</strong>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span>Cart Total</span>
                        <strong>
                            ৳{{ number_format($cart->subtotal, 2) }}
                        </strong>
                    </div>

                    <p class="summary-note">
                        Shipping charges and applicable taxes will be calculated
                        during checkout.
                    </p>

                    <button type="button"
                            class="checkout-btn"
                            onclick="alert('Checkout page will be available in the next step.')">

                        Proceed to Checkout
                        <i class="fas fa-arrow-right"></i>

                    </button>

                    <div class="secure-checkout">
                        <i class="fas fa-lock"></i>
                        Secure Shopping Experience
                    </div>

                </div>

            </div>

        @else

            {{-- Empty Cart --}}
            <div class="empty-cart">

                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>

                <h2>Your Cart is Empty!</h2>

                <p>
                    Looks like you haven't added any products to your cart yet.
                    Explore our collection and find something you love.
                </p>

                <a href="{{ route('shop') }}" class="shop-now-btn">
                    <i class="fas fa-shopping-bag"></i>
                    Start Shopping
                </a>

            </div>

        @endif

    </div>

</section>

@endsection

@push('scripts')
<script>
    function changeCartQuantity(button, change) {
        const input = button.parentElement.querySelector('input[name="quantity"]');

        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 999999;

        let value = parseInt(input.value) || min;

        value += change;

        if (value < min) value = min;
        if (value > max) value = max;

        input.value = value;
    }
</script>
@endpush
