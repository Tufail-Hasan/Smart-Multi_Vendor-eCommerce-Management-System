@extends('frontend.layouts.app')

@section('title', 'Our Blog - MarketPro')

@section('content')

<!-- Blog Hero -->
<section class="blog-hero">

    <div class="container">

        <span class="blog-hero-label">
            <i class="fas fa-book-open"></i>
            MarketPro Journal
        </span>

        <h1>Discover Ideas & Inspiration</h1>

        <p>
            Explore the latest trends, shopping guides,
            product reviews and helpful articles.
        </p>

    </div>

</section>


<!-- Featured Blogs -->
@if($featuredBlogs->isNotEmpty())

<section class="featured-blog-section">

    <div class="container">

        <div class="section-heading">

            <div>
                <span>Editor's Choice</span>
                <h2>Featured Articles</h2>
            </div>

        </div>


        <div class="featured-blog-grid">

            @foreach($featuredBlogs as $blog)

                <a href="{{ route('blogs.show', $blog->slug) }}"
                   class="featured-blog-card">

                    <div class="featured-blog-image">

                        @if($blog->featured_image)

    <img
        src="{{ Storage::disk('public')->url($blog->featured_image) }}"
        alt="{{ $blog->title }}"
        loading="lazy"
        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';"
    >

@else

    <div class="blog-image-placeholder">
        <i class="fas fa-newspaper"></i>
    </div>

@endif

                        <span class="featured-blog-badge">
                            Featured
                        </span>

                    </div>


                    <div class="featured-blog-content">

                        @if($blog->category)
                            <span class="blog-category">
                                {{ $blog->category }}
                            </span>
                        @endif

                        <h3>{{ $blog->title }}</h3>

                        <p>
                            {{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                        </p>

                        <span class="blog-read-more">
                            Read Article
                            <i class="fas fa-arrow-right"></i>
                        </span>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif


<!-- All Blogs Section -->
<section class="all-blogs-section">

    <div class="container">

        <div class="section-heading">

            <div>
                <span>Latest Updates</span>
                <h2>Explore Our Blogs</h2>
            </div>

            <p>{{ $blogs->total() }} Articles Available</p>

        </div>


        <!-- Search and Filter -->
        <div class="blog-filter-wrapper">

            <form action="{{ route('blogs.index') }}"
                  method="GET"
                  class="blog-filter-form">

                <div class="blog-search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        name="search"
                        placeholder="Search articles..."
                        value="{{ request('search') }}"
                    >

                </div>


                <select name="category" class="blog-category-select">

                    <option value="">All Categories</option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category }}"
                            {{ request('category') == $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>

                    @endforeach

                </select>


                <button type="submit" class="blog-filter-btn">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>


                <a href="{{ route('blogs.index') }}"
                   class="blog-reset-btn">
                    Reset
                </a>

            </form>

        </div>


        <!-- Blog Cards -->
        @if($blogs->isNotEmpty())

            <div class="blog-grid">

                @foreach($blogs as $blog)

                    <article class="blog-card">

                        <a href="{{ route('blogs.show', $blog->slug) }}"
                           class="blog-card-image">

                            @if($blog->featured_image)

                                <img
                                    src="{{ asset('storage/' . $blog->featured_image) }}"
                                    alt="{{ $blog->title }}"
                                >

                            @else

                                <div class="blog-image-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>

                            @endif

                        </a>


                        <div class="blog-card-content">

                            <div class="blog-meta">

                                @if($blog->category)

                                    <span class="blog-category">
                                        {{ $blog->category }}
                                    </span>

                                @endif

                                <span>
                                    <i class="far fa-calendar"></i>

                                    {{ $blog->published_at?->format('d M, Y') ?? $blog->created_at->format('d M, Y') }}
                                </span>

                            </div>


                            <h3>
                                <a href="{{ route('blogs.show', $blog->slug) }}">
                                    {{ $blog->title }}
                                </a>
                            </h3>


                            <p>
                                {{ $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 120) }}
                            </p>


                            <div class="blog-card-footer">

                                <span class="blog-author">
                                    <i class="far fa-user"></i>

                                    {{ $blog->author_name ?? 'MarketPro Team' }}
                                </span>


                                <a href="{{ route('blogs.show', $blog->slug) }}"
                                   class="blog-read-link">

                                    Read More
                                    <i class="fas fa-arrow-right"></i>

                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            <!-- Pagination -->
            <div class="shop-pagination">
                {{ $blogs->links() }}
            </div>


        @else

            <div class="blog-empty">

                <i class="fas fa-newspaper"></i>

                <h3>No Articles Found</h3>

                <p>
                    We couldn't find any articles matching your search.
                    Please try another keyword or category.
                </p>

                <a href="{{ route('blogs.index') }}"
                   class="blog-filter-btn">
                    View All Blogs
                </a>

            </div>

        @endif

    </div>

</section>

@endsection
