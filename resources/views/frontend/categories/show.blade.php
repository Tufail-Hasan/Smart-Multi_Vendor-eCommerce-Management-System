@extends('frontend.layouts.app')

@section('title', $category->name . ' - MarketPro')

@section('content')

<section class="category-page-header">
    <div class="container">
        <span>MarketPro Categories</span>
        <h1>{{ $category->name }}</h1>

        <p>
            {{ $category->description ?? 'Explore our latest products in this category.' }}
        </p>
    </div>
</section>

<section class="shop-section">
    <div class="container">

        @if($category->children->isNotEmpty())

            <div class="section-heading">
                <div>
                    <span>Explore More</span>
                    <h2>Subcategories</h2>
                </div>
            </div>

            <div class="all-category-grid">

                @foreach($category->children as $child)

                    <a href="{{ route('categories.show', $child->slug) }}"
                       class="all-category-card">

                        <div class="all-category-image">

                            @if($child->image)
                                <img src="{{ asset('storage/' . $child->image) }}"
                                     alt="{{ $child->name }}">
                            @else
                                <div class="category-placeholder">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                            @endif

                        </div>

                        <div class="all-category-info">
                            <h3>{{ $child->name }}</h3>
                        </div>

                    </a>

                @endforeach

            </div>

        @endif

        <div class="section-heading" style="margin-top: 50px;">
            <div>
                <span>Our Products</span>
                <h2>{{ $category->name }} Products</h2>
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
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="category-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif

                            </a>

                            @if($product->is_featured)
                                <span class="product-badge">Featured</span>
                            @endif

                        </div>

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

                            <a href="{{ route('product.show', $product->slug) }}"
                               class="product-button">
                                View Details
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="shop-pagination">
                {{ $products->links() }}
            </div>

        @else

            <div class="category-empty">
                <i class="fas fa-box-open"></i>
                <h3>No Products Found</h3>
                <p>There are currently no approved products in this category.</p>
            </div>

        @endif

    </div>
</section>

@endsection
