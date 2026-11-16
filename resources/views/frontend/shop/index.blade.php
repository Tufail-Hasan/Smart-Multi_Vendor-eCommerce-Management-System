@extends('frontend.layouts.app')

@section('title', 'Shop - MarketPro')

@section('content')

<!-- Shop Header -->
<section class="shop-header">
    <div class="container">
        <span>MARKETPRO COLLECTION</span>
        <h1>Explore Our Products</h1>
        <p>Discover amazing products from trusted marketplace vendors.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">

        <div class="shop-layout">

            <!-- Sidebar Filters -->
            <aside class="shop-sidebar">

                <form action="{{ route('shop') }}" method="GET">

                    <div class="filter-group">
                        <h3>Search Products</h3>

                        <input
                            type="search"
                            name="search"
                            placeholder="Search products..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="filter-group">
                        <h3>Categories</h3>

                        @foreach($categories as $category)

                            <label class="filter-option">
                                <input
                                    type="radio"
                                    name="category"
                                    value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'checked' : '' }}
                                >

                                {{ $category->name }}
                            </label>

                        @endforeach
                    </div>

                    <div class="filter-group">
                        <h3>Brands</h3>

                        @foreach($brands as $brand)

                            <label class="filter-option">
                                <input
                                    type="radio"
                                    name="brand"
                                    value="{{ $brand->slug }}"
                                    {{ request('brand') == $brand->slug ? 'checked' : '' }}
                                >

                                {{ $brand->name }}
                            </label>

                        @endforeach
                    </div>

                    <div class="filter-group">
                        <h3>Price Range (৳)</h3>

                        <input
                            type="number"
                            name="min_price"
                            placeholder="Minimum Price"
                            min="0"
                            value="{{ request('min_price') }}"
                        >

                        <input
                            type="number"
                            name="max_price"
                            placeholder="Maximum Price"
                            min="0"
                            value="{{ request('max_price') }}"
                        >
                    </div>

                    <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}">

                    <button type="submit" class="filter-button">
                        Apply Filters
                    </button>

                    <a href="{{ route('shop') }}" class="clear-filter">
                        Clear All Filters
                    </a>

                </form>

            </aside>

            <!-- Products -->
            <div class="shop-products">

                <div class="shop-toolbar">

                    <div>
                        <h2>All Products</h2>

                        <p>
                            Showing {{ $products->firstItem() ?? 0 }}
                            -
                            {{ $products->lastItem() ?? 0 }}
                            of {{ $products->total() }} products
                        </p>
                    </div>

                    <form action="{{ route('shop') }}" method="GET">

                        @foreach(request()->except(['sort', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <select name="sort" onchange="this.form.submit()">

                            <option value="latest"
                                {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                Latest Products
                            </option>

                            <option value="price_low"
                                {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>

                            <option value="price_high"
                                {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>

                            <option value="name"
                                {{ request('sort') == 'name' ? 'selected' : '' }}>
                                Name: A to Z
                            </option>

                        </select>

                    </form>

                </div>

                <div class="product-grid">

                    @forelse($products as $product)

                        <div class="product-card">

                            <div class="product-image">

                                @if($product->thumbnail)

    <img
        src="{{ asset('storage/' . $product->thumbnail) }}"
        alt="{{ $product->name }}"
        loading="lazy"
        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';"
    >

@else

    <div class="no-image">
        No Image Available
    </div>

@endif

                                @if($product->is_featured)
                                    <span class="product-badge">
                                        Featured
                                    </span>
                                @endif

                            </div>

                            <div class="product-info">

                                @if($product->brand)
                                    <small class="shop-brand">
                                        {{ $product->brand->name }}
                                    </small>
                                @endif

                                <h3>{{ $product->name }}</h3>

                                <div class="product-price">

                                    @if($product->discount_price !== null && $product->discount_price < $product->price)
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

                        <div class="shop-empty">
                            <h3>No Products Found!</h3>
                            <p>Try changing your search or filters.</p>

                            <a href="{{ route('shop') }}" class="btn-primary">
                                View All Products
                            </a>
                        </div>

                    @endforelse

                </div>

                <!-- Pagination -->
                <div class="shop-pagination">
                    {{ $products->links() }}
                </div>

            </div>

        </div>

    </div>
</section>

@endsection
