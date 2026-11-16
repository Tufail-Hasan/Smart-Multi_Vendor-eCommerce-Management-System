@extends('frontend.layouts.app')

@section('title', $blog->meta_title ?: $blog->title . ' - MarketPro')

@section('content')

<!-- Blog Details Header -->
<section class="blog-details-header">

    <div class="container">

        <a href="{{ route('blogs.index') }}" class="blog-back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Blogs
        </a>


        @if($blog->category)

            <span class="blog-category">
                {{ $blog->category }}
            </span>

        @endif


        <h1>{{ $blog->title }}</h1>


        @if($blog->excerpt)

            <p>{{ $blog->excerpt }}</p>

        @endif


        <div class="blog-details-meta">

            <span>
                <i class="far fa-user"></i>
                {{ $blog->author_name ?? 'MarketPro Team' }}
            </span>

            <span>
                <i class="far fa-calendar"></i>

                {{ $blog->published_at?->format('d F, Y') ?? $blog->created_at->format('d F, Y') }}
            </span>

            <span>
                <i class="far fa-eye"></i>
                {{ number_format($blog->views) }} Views
            </span>

        </div>

    </div>

</section>


<!-- Blog Featured Image -->

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


<!-- Blog Content -->
<section class="blog-details-section">

    <div class="container">

        <div class="blog-details-content">

            <article class="blog-article">

                <div class="blog-article-content">

                    {!! nl2br(e($blog->content)) !!}

                </div>


                <div class="blog-article-footer">

                    <div>
                        <strong>Written By:</strong>

                        {{ $blog->author_name ?? 'MarketPro Team' }}
                    </div>

                    @if($blog->category)

                        <div>
                            <strong>Category:</strong>
                            {{ $blog->category }}
                        </div>

                    @endif

                </div>

            </article>

        </div>

    </div>

</section>


<!-- Related Blogs -->
@if($relatedBlogs->isNotEmpty())

<section class="related-blogs-section">

    <div class="container">

        <div class="section-heading">

            <div>
                <span>Keep Reading</span>
                <h2>Related Articles</h2>
            </div>

            <a href="{{ route('blogs.index') }}" class="blog-view-all">
                View All Blogs
            </a>

        </div>


        <div class="blog-grid">

            @foreach($relatedBlogs as $related)

                <article class="blog-card">

                    <a href="{{ route('blogs.show', $related->slug) }}"
                       class="blog-card-image">

                        @if($related->featured_image)

                            <img
                                src="{{ asset('storage/' . $related->featured_image) }}"
                                alt="{{ $related->title }}"
                            >

                        @else

                            <div class="blog-image-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>

                        @endif

                    </a>


                    <div class="blog-card-content">

                        @if($related->category)

                            <span class="blog-category">
                                {{ $related->category }}
                            </span>

                        @endif


                        <h3>
                            <a href="{{ route('blogs.show', $related->slug) }}">
                                {{ $related->title }}
                            </a>
                        </h3>


                        <p>
                            {{ $related->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($related->content), 100) }}
                        </p>


                        <a href="{{ route('blogs.show', $related->slug) }}"
                           class="blog-read-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>

                </article>

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection
