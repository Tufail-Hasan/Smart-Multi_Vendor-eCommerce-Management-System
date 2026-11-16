@extends('frontend.layouts.app')

@section('title', ($page->meta_title ?: $page->title) . ' | MarketPro')

@section('content')

{{-- Page Banner --}}
<section class="about-hero">
    <div class="about-hero-overlay"></div>

    <div class="container about-hero-content">
        <span class="about-label">WHO WE ARE</span>

        <h1>{{ $page->title }}</h1>

        <p>
            {{ $page->excerpt ?: 'Discover our story, our passion and our commitment to delivering the best shopping experience.' }}
        </p>

        <div class="about-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <i class="fas fa-angle-right"></i>
            <span>{{ $page->title }}</span>
        </div>
    </div>
</section>


{{-- About Content --}}
<section class="about-section">
    <div class="container">

        <div class="about-content-wrapper">

            @if($page->featured_image)
                <div class="about-image">
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($page->featured_image) }}"
                        alt="{{ $page->title }}"
                    >
                </div>
            @endif

            <div class="about-content">

                <span class="section-subtitle">ABOUT MARKETPRO</span>

                <h2>
                    Welcome to
                    <span>MarketPro</span>
                </h2>

                <div class="about-description">
                    {!! $page->content !!}
                </div>

            </div>

        </div>

    </div>
</section>


{{-- Features --}}
<section class="about-features">
    <div class="container">

        <div class="about-section-heading">
            <span class="section-subtitle">WHY CHOOSE US</span>
            <h2>Why Shop With MarketPro?</h2>
            <p>We are committed to making your shopping experience simple and enjoyable.</p>
        </div>

        <div class="about-feature-grid">

            <div class="about-feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3>Quality Products</h3>
                <p>Explore a wide range of carefully selected products from trusted vendors.</p>
            </div>

            <div class="about-feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Get your favorite products delivered conveniently to your doorstep.</p>
            </div>

            <div class="about-feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Shopping</h3>
                <p>Shop confidently with a focus on secure transactions and customer trust.</p>
            </div>

            <div class="about-feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Customer Support</h3>
                <p>Our goal is to provide helpful support whenever you need assistance.</p>
            </div>

        </div>

    </div>
</section>


{{-- CTA --}}
<section class="about-cta">
    <div class="container">

        <h2>Ready to Start Shopping?</h2>

        <p>
            Discover amazing products from different vendors
            and enjoy shopping with MarketPro.
        </p>

        <a href="{{ route('shop') }}" class="about-cta-btn">
            Explore Products
            <i class="fas fa-arrow-right"></i>
        </a>

    </div>
</section>

@endsection
