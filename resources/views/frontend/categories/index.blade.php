@extends('frontend.layouts.app')

@section('title', 'All Categories - MarketPro')

@section('content')

<section class="category-page-header">
    <div class="container">
        <span>Explore MarketPro</span>
        <h1>Shop by Categories</h1>
        <p>Discover products from our wide range of categories.</p>
    </div>
</section>

<section class="all-categories-section">
    <div class="container">

        <div class="section-heading">
            <div>
                <span>Our Collections</span>
                <h2>All Categories</h2>
            </div>

            <p>{{ $categories->count() }} Categories</p>
        </div>

        @if($categories->isNotEmpty())

            <div class="all-category-grid">

                @foreach($categories as $category)

                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="all-category-card">

                        <div class="all-category-image">

                            @if($category->image)

                                <img
                                    src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->name }}"
                                    loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';"
                                >

                            @else

                                <div class="category-placeholder">
                                    <i class="fas fa-layer-group"></i>
                                </div>

                            @endif

                        </div>

                        <div class="all-category-info">

                            <h3>{{ $category->name }}</h3>

                            <p>
                                {{ $category->products_count }} Products
                            </p>

                            @if($category->children->isNotEmpty())

                                <small>
                                    {{ $category->children->count() }}
                                    Subcategories
                                </small>

                            @endif

                        </div>

                        <span class="category-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>

                    </a>

                @endforeach

            </div>

        @else

            <div class="category-empty">
                <i class="fas fa-box-open"></i>
                <h3>No Categories Found</h3>
                <p>Categories will appear here when available.</p>
            </div>

        @endif

    </div>
</section>

@endsection
