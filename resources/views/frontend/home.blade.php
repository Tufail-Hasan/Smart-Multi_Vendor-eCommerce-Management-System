@extends('frontend.layouts.app')

@section('title', 'MarketPro - Premium Online Marketplace')

@section('content')

{{-- ==========================================
    HERO SLIDER
========================================== --}}

@if($sliders->isNotEmpty())

<section class="home-slider">

    @foreach($sliders as $slider)

        <div class="slider-item"
             style="background-image: url('{{ asset('storage/' . $slider->image) }}');">

            <div class="slider-overlay"></div>

            <div class="container">
                <div class="slider-content">

                    @if($slider->subtitle)
                        <h2>{{ $slider->subtitle }}</h2>
                    @endif

                    <h1>{{ $slider->title }}</h1>

                    @if($slider->description)
                        <p>{{ $slider->description }}</p>
                    @endif

                    <div class="slider-buttons">

                        @if($slider->button_text && $slider->button_url)
                            <a href="{{ $slider->button_url }}"
                               class="btn-primary">
                                {{ $slider->button_text }} →
                            </a>
                        @endif

                        @if($slider->secondary_button_text && $slider->secondary_button_url)
                            <a href="{{ $slider->secondary_button_url }}"
                               class="btn-outline"
                               style="border-color:white;color:white;">
                                {{ $slider->secondary_button_text }}
                            </a>
                        @endif

                    </div>

                </div>
            </div>

        </div>

    @endforeach

</section>

@else

{{-- Default Hero if no slider exists --}}

<section class="hero-section">
    <div class="container">
        <div class="hero-content">

            <div class="hero-text">

                <span class="hero-label">
                    ✨ YOUR PREMIUM MARKETPLACE
                </span>

                <h1>
                    Discover More.<br>
                    Shop <span>Smarter.</span>
                </h1>

                <p>
                    Explore amazing products from trusted vendors.
                    Find everything you need in one place.
                </p>

                <div class="hero-buttons">
                    <a href="{{ url('/shop') }}" class="btn-primary">
                        Shop Now →
                    </a>

                    <a href="{{ url('/categories') }}" class="btn-outline">
                        Explore Categories
                    </a>
                </div>

            </div>

            <div class="hero-image">
                <div class="hero-circle"></div>

                <img
                    src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=900"
                    alt="Online Shopping"
                >
            </div>

        </div>
    </div>
</section>

@endif


{{-- ==========================================
    FEATURES
========================================== --}}

<section class="features-section">
    <div class="container features-grid">

        <div class="feature-item">
            <span>🚚</span>
            <div>
                <h4>Fast Delivery</h4>
                <p>Quick & reliable shipping</p>
            </div>
        </div>

        <div class="feature-item">
            <span>🔒</span>
            <div>
                <h4>Secure Payment</h4>
                <p>Safe payment experience</p>
            </div>
        </div>

        <div class="feature-item">
            <span>⭐</span>
            <div>
                <h4>Quality Products</h4>
                <p>Trusted marketplace sellers</p>
            </div>
        </div>

        <div class="feature-item">
            <span>💬</span>
            <div>
                <h4>24/7 Support</h4>
                <p>We're here to help</p>
            </div>
        </div>

    </div>
</section>


{{-- ==========================================
    CATEGORIES
========================================== --}}

<section class="section category-section">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">EXPLORE OUR STORE</span>
                <h2>Shop By Category</h2>
                <p>Find your favorite products easily.</p>
            </div>

            <a href="{{ url('/categories') }}" class="view-all">
                View All →
            </a>
        </div>

        <div class="category-placeholder">

            @forelse($categories as $category)

                <a href="{{ url('/shop?category=' . $category->slug) }}"
                   class="category-box">

                    @if($category->image)
                        <img
                            src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="category-image"
                        >
                    @else
                        <span class="category-icon">🛍️</span>
                    @endif

                    <span>{{ $category->name }}</span>

                    <small>
                        {{ $category->products_count }} Products
                    </small>

                </a>

            @empty

                <p>No categories available yet.</p>

            @endforelse

        </div>

    </div>
</section>


{{-- ==========================================
    BRANDS
========================================== --}}

<section class="section brands-section">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">POPULAR BRANDS</span>
                <h2>Shop By Brands</h2>
                <p>Explore products from trusted brands.</p>
            </div>
        </div>

        <div class="brand-grid">

            @forelse($brands as $brand)

                <a href="{{ url('/shop?brand=' . $brand->slug) }}"
                   class="brand-card">

                    @if($brand->logo)
                        <img
                            src="{{ asset('storage/' . $brand->logo) }}"
                            alt="{{ $brand->name }}"
                        >
                    @else
                        <span class="brand-name">
                            {{ $brand->name }}
                        </span>
                    @endif

                    <h4>{{ $brand->name }}</h4>

                </a>

            @empty

                <p>No brands available yet.</p>

            @endforelse

        </div>

    </div>
</section>


{{-- ==========================================
    FEATURED PRODUCTS
========================================== --}}

<section class="section product-section">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">HANDPICKED FOR YOU</span>
                <h2>Featured Products</h2>
                <p>Discover products selected for you.</p>
            </div>

            <a href="{{ url('/shop') }}" class="view-all">
                View All Products →
            </a>
        </div>

        <div class="product-grid">

            @forelse($featuredProducts as $product)

                <div class="product-card">

                    <div class="product-image">

                        @if($product->thumbnail)
                            <img
                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                alt="{{ $product->name }}"
                            >
                        @else
                            <div class="no-image">No Image</div>
                        @endif

                        <span class="product-badge">Featured</span>

                    </div>

                    <div class="product-info">

                        <h3>{{ $product->name }}</h3>

                        <div class="product-price">

                            @if($product->discount_price)
                                <strong>
                                    ৳{{ number_format($product->discount_price, 2) }}
                                </strong>

                                <del>
                                    ৳{{ number_format($product->price, 2) }}
                                </del>
                            @else
                                <strong>
                                    ৳{{ number_format($product->price, 2) }}
                                </strong>
                            @endif

                        </div>

                        <a href="{{ url('/product/' . $product->slug) }}"
                           class="product-button">
                            View Details →
                        </a>

                    </div>

                </div>

            @empty

                <p class="empty-products">
                    No featured products available yet.
                </p>

            @endforelse

        </div>

    </div>
</section>


{{-- ==========================================
    DYNAMIC PROMOTIONAL BANNERS
========================================== --}}

@if($banners->isNotEmpty())

<section class="home-banner-section">
    <div class="container">

        <div class="home-banner-grid">

            @foreach($banners as $banner)

                <div class="home-banner-card"
                     style="background-image: url('{{ asset('storage/' . $banner->image) }}');">

                    <div class="home-banner-content">

                        @if($banner->subtitle)
                            <span>{{ $banner->subtitle }}</span>
                        @endif

                        <h3>{{ $banner->title }}</h3>

                        @if($banner->description)
                            <p>{{ $banner->description }}</p>
                        @endif

                        @if($banner->button_text && $banner->button_url)
                            <a href="{{ $banner->button_url }}"
                               class="btn-white">
                                {{ $banner->button_text }} →
                            </a>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>
</section>

@else

<section class="promotion-section">
    <div class="container">
        <div class="promotion-box">

            <div>
                <span>EXCLUSIVE COLLECTION</span>
                <h2>Upgrade Your Shopping Experience</h2>
                <p>Discover something special for every moment.</p>

                <a href="{{ url('/shop') }}" class="btn-white">
                    Explore Now →
                </a>
            </div>

            <div class="promotion-icon">🛍️</div>

        </div>
    </div>
</section>

@endif


{{-- ==========================================
    LATEST PRODUCTS
========================================== --}}

<section class="section">
    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">JUST ARRIVED</span>
                <h2>Latest Products</h2>
                <p>Explore our newest arrivals.</p>
            </div>

            <a href="{{ url('/shop') }}" class="view-all">
                Explore All →
            </a>
        </div>

        <div class="product-grid">

            @forelse($products as $product)

                <div class="product-card">

                    <div class="product-image">

                        @if($product->thumbnail)
                            <img
                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                alt="{{ $product->name }}"
                            >
                        @else
                            <div class="no-image">No Image</div>
                        @endif

                    </div>

                    <div class="product-info">

                        <h3>{{ $product->name }}</h3>

                        <div class="product-price">

                            @if($product->discount_price)
                                <strong>
                                    ৳{{ number_format($product->discount_price, 2) }}
                                </strong>

                                <del>
                                    ৳{{ number_format($product->price, 2) }}
                                </del>
                            @else
                                <strong>
                                    ৳{{ number_format($product->price, 2) }}
                                </strong>
                            @endif

                        </div>

                        <a href="{{ url('/product/' . $product->slug) }}"
                           class="product-button">
                            View Details →
                        </a>

                    </div>

                </div>

            @empty

                <p class="empty-products">
                    No products available.
                </p>

            @endforelse

        </div>

    </div>
</section>

@endsection
