@extends('frontend.layouts.app')

@section('title', 'Special Offers - MarketPro')

@section('content')

<!-- Offers Hero -->
<section class="offers-hero">

    <div class="container">

        <div class="offers-hero-content">

            <span class="offers-label">
                <i class="fas fa-tags"></i>
                Exclusive Deals
            </span>

            <h1>Special Offers & Discounts</h1>

            <p>
                Discover amazing products at special prices.
                Shop your favorites and enjoy great savings.
            </p>

            <a href="#offer-products" class="offers-hero-btn">
                Explore Offers
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

        <div class="offers-hero-icon">
            <i class="fas fa-gift"></i>
        </div>

    </div>

</section>


<!-- Special Offers Products -->
<section class="special-offers-section" id="offer-products">

    <div class="container">

        <div class="section-heading">

            <div>
                <span>Limited Time Deals</span>
                <h2>Hot Deals For You</h2>
            </div>

            <p>
                {{ $products->total() }} Offers Available
            </p>

        </div>


        @if($products->isNotEmpty())

            <div class="product-grid">

                @foreach($products as $product)

                    @php
                        $discountAmount = $product->price - $product->discount_price;

                        $discountPercentage = $product->price > 0
                            ? round(($discountAmount / $product->price) * 100)
                            : 0;
                    @endphp


                    <div class="product-card offer-product-card">

                        <!-- Product Image -->
                        <div class="product-image">

                            <a href="{{ route('product.show', $product->slug) }}">

                                @if($product->thumbnail)

                                    <img
                                        src="{{ asset('storage/' . $product->thumbnail) }}"
                                        alt="{{ $product->name }}"
                                    >

                                @else

                                    <div class="category-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>

                                @endif

                            </a>


                            <span class="offer-discount-badge">
                                -{{ $discountPercentage }}%
                            </span>


                            @if($product->is_featured)

                                <span class="product-badge">
                                    Featured
                                </span>

                            @endif

                        </div>


                        <!-- Product Information -->
                        <div class="product-info">

                            @if($product->brand)

                                <span class="product-brand">
                                    {{ $product->brand->name }}
                                </span>

                            @endif


                            <h3>
                                <a href="{{ route('product.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>


                            <!-- Price -->
                            <div class="offer-product-price">

                                <span class="offer-current-price">
                                    ৳{{ number_format($product->discount_price, 2) }}
                                </span>

                                <del>
                                    ৳{{ number_format($product->price, 2) }}
                                </del>

                            </div>


                            <!-- Saving -->
                            <div class="offer-saving">
                                <i class="fas fa-check-circle"></i>

                                You Save ৳{{ number_format($discountAmount, 2) }}
                            </div>


                            <!-- Product Button -->
                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="product-button offer-view-btn"
                            >
                                View Offer
                                <i class="fas fa-arrow-right"></i>
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>


            <!-- Pagination -->
            <div class="shop-pagination">
                {{ $products->links() }}
            </div>


        @else

            <div class="offers-empty">

                <div class="offers-empty-icon">
                    <i class="fas fa-tags"></i>
                </div>

                <h3>No Special Offers Available</h3>

                <p>
                    There are currently no discounted products.
                    Please check back later for exciting deals.
                </p>

                <a href="{{ route('shop') }}" class="product-button">
                    Explore All Products
                </a>

            </div>

        @endif

    </div>

</section>

@endsection
