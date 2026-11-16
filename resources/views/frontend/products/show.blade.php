@extends('frontend.layouts.app')

@section('title', $product->name . ' - MarketPro')

@section('content')

<section class="product-details-section">
    <div class="container">

        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('shop') }}">Shop</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </div>

        <div class="product-details-grid">

            {{-- Product Image --}}
            <div class="product-gallery">

                <div class="main-product-image">

                    @if($product->thumbnail)
                        <img
                            src="{{ asset('storage/' . $product->thumbnail) }}"
                            alt="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                        >
                    @else
                        <div class="product-image-placeholder">
                            <i class="fas fa-image"></i>
                            <p>No Image Available</p>
                        </div>
                    @endif

                </div>

            </div>


            {{-- Product Information --}}
            <div class="product-details-info">

                <div class="product-brand">
                    @if($product->brand)
                        Brand:
                        <a href="{{ route('brands.show', $product->brand->slug) }}">
                            {{ $product->brand->name }}
                        </a>
                    @endif
                </div>

                <h1>{{ $product->name }}</h1>

                <div class="product-meta">

                    @if($product->category)
                        <span>
                            Category: {{ $product->category->name }}
                        </span>
                    @endif

                    @if($product->sku)
                        <span>SKU: {{ $product->sku }}</span>
                    @endif

                </div>


                {{-- Price --}}
                <div class="product-detail-price">

                    @if($product->discount_price !== null && $product->discount_price < $product->price)

                        <span class="current-price">
                            ৳{{ number_format($product->discount_price, 2) }}
                        </span>

                        <del class="old-price">
                            ৳{{ number_format($product->price, 2) }}
                        </del>

                        <span class="discount-badge">
                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                        </span>

                    @else

                        <span class="current-price">
                            ৳{{ number_format($product->price, 2) }}
                        </span>

                    @endif

                </div>


                {{-- Description --}}
                @if($product->short_description)
                    <p class="short-description">
                        {{ $product->short_description }}
                    </p>
                @endif


                {{-- Stock --}}
                <div class="product-stock">

                    @if($product->stock > 0)
                        <span class="in-stock">
                            <i class="fas fa-check-circle"></i>
                            In Stock ({{ $product->stock }} available)
                        </span>
                    @else
                        <span class="out-of-stock">
                            Out of Stock
                        </span>
                    @endif

                </div>


                {{-- Product Attributes --}}
                <div class="product-attributes">

                    @if($product->color)
                        <p><strong>Color:</strong> {{ $product->color }}</p>
                    @endif

                    @if($product->size)
                        <p><strong>Size:</strong> {{ $product->size }}</p>
                    @endif

                    @if($product->weight)
                        <p>
                            <strong>Weight:</strong>
                            {{ $product->weight }} {{ $product->weight_unit }}
                        </p>
                    @endif

                </div>


                {{-- Quantity --}}
                @if($product->stock > 0)

                    <form action="#" method="POST" class="product-cart-form">
                        @csrf

                        <div class="quantity-wrapper">
                            <label for="quantity">Quantity:</label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                            >
                        </div>

                        <form action="{{ route('wishlist.store') }}" method="POST">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <button type="submit" class="add-wishlist-btn">
        <i class="far fa-heart"></i>
        Add to Wishlist
    </button>
</form>

                         <button type="submit" class="add-to-cart-btn"
        {{ $product->stock < 1 ? 'disabled' : '' }}>

        <i class="fas fa-shopping-cart"></i>
        Add to Cart

    </button>

                    </form>

                @endif


                {{-- Vendor --}}
                @if($product->vendor)
                    <div class="product-vendor">
                        <strong>Sold By:</strong>
                        {{ $product->vendor->store_name ?? 'Marketplace Vendor' }}
                    </div>
                @endif

            </div>

        </div>


        {{-- Full Description --}}
        <div class="product-description-section">

            <h2>Product Description</h2>

            <div class="description-content">
                {!! nl2br(e($product->description ?? 'No description available.')) !!}
            </div>

        </div>

    </div>
</section>

@endsection
