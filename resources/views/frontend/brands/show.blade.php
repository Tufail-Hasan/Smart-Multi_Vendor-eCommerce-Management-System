@extends('frontend.layouts.app')

@section('title', $brand->name . ' - MarketPro')

@section('content')

<!-- Brand Header -->
<section class="brand-details-header">

    <div class="container">

        <div class="brand-details-logo">

            @if($brand->logo)

                <img
                    src="{{ asset('storage/' . $brand->logo) }}"
                    alt="{{ $brand->name }}"
                >

            @else

                <i class="fas fa-award"></i>

            @endif

        </div>


        <div class="brand-details-content">

            <span>MarketPro Brand Collection</span>

            <h1>{{ $brand->name }}</h1>

            <p>
                {{ $brand->description ?? 'Discover our latest products from ' . $brand->name . '.' }}
            </p>

        </div>

    </div>

</section>


<!-- Brand Products -->
<section class="shop-section">

    <div class="container">

        <div class="section-heading">

            <div>
                <span>Explore Collection</span>
                <h2>{{ $brand->name }} Products</h2>
            </div>

            <p>{{ $products->total() }} Products Found</p>

        </div>


        @if($products->isNotEmpty())

            <div class="product-grid">

                @foreach($products as $product)

                    <div class="product-card">

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


                            @if($product->is_featured)

                                <span class="product-badge">
                                    Featured
                                </span>

                            @endif

                        </div>


                        <div class="product-info">

                            <span class="product-brand">
                                {{ $brand->name }}
                            </span>


                            <h3>
                                <a href="{{ route('product.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>


                            <div class="product-price">

                                @if($product->discount_price)

                                    <span class="current-price">
                                        ৳{{ number_format($product->discount_price, 2) }}
                                    </span>

                                    <del>
                                        ৳{{ number_format($product->price, 2) }}
                                    </del>

                                @else

                                    <span class="current-price">
                                        ৳{{ number_format($product->price, 2) }}
                                    </span>

                                @endif

                            </div>


                            <a
                                href="{{ route('product.show', $product->slug) }}"
                                class="product-button"
                            >
                                View Details
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

            <div class="brand-empty">

                <i class="fas fa-box-open"></i>

                <h3>No Products Found</h3>

                <p>
                    There are currently no approved products
                    available for this brand.
                </p>

                <a href="{{ route('brands.index') }}" class="product-button">
                    Explore All Brands
                </a>

            </div>

        @endif

    </div>

</section>

@endsection
