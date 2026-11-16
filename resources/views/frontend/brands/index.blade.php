@extends('frontend.layouts.app')

@section('title', 'All Brands - MarketPro')

@section('content')

<!-- Brand Header -->
<section class="brand-page-header">
    <div class="container">
        <span>Discover Our Brands</span>

        <h1>Shop Your Favorite Brands</h1>

        <p>
            Explore products from trusted brands and discover
            your favorite collections at MarketPro.
        </p>
    </div>
</section>


<!-- All Brands -->
<section class="all-brands-section">

    <div class="container">

        <div class="section-heading">
            <div>
                <span>Our Collections</span>
                <h2>Popular Brands</h2>
            </div>

            <p>{{ $brands->count() }} Brands Available</p>
        </div>


        @if($brands->isNotEmpty())

            <div class="all-brands-grid">

                @foreach($brands as $brand)

                    <a href="{{ route('brands.show', $brand->slug) }}"
                       class="all-brand-card">

                        <div class="all-brand-logo">

                            @if($brand->logo)

    <img
        src="{{ asset('storage/' . $brand->logo) }}"
        alt="{{ $brand->name }}"
        loading="lazy"
        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';"
    >

@else

    <div class="brand-placeholder">
        <i class="fas fa-award"></i>
    </div>

@endif

                        </div>


                        <div class="all-brand-info">

                            <h3>{{ $brand->name }}</h3>

                            <p>
                                {{ $brand->products_count }} Products
                            </p>

                        </div>


                        <span class="brand-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>

                    </a>

                @endforeach

            </div>

        @else

            <div class="brand-empty">

                <i class="fas fa-award"></i>

                <h3>No Brands Available</h3>

                <p>
                    Brands will appear here when they are added
                    from the admin panel.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection
