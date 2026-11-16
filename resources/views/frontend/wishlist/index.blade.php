@extends('frontend.layouts.app')

@section('title', 'My Wishlist - MarketPro')

@section('content')

<section class="wishlist-section">

    <div class="wishlist-container">

        {{-- Page Header --}}
        <div class="wishlist-header">
            <div>
                <span class="wishlist-subtitle">YOUR FAVORITES</span>
                <h1>My Wishlist</h1>
                <p>Save your favorite products and shop them whenever you like.</p>
            </div>

            <div class="wishlist-count">
                <i class="fas fa-heart"></i>
                {{ $wishlists->total() }} Items
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="wishlist-alert success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Info Message --}}
        @if(session('info'))
            <div class="wishlist-alert info">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>
        @endif

        {{-- Wishlist Products --}}
        @if($wishlists->count() > 0)

            <div class="wishlist-grid">

                @foreach($wishlists as $wishlist)

                    @php
                        $product = $wishlist->product;
                    @endphp

                    @if($product)

                        <div class="wishlist-card">

                            {{-- Product Image --}}
                            <div class="wishlist-image">

                                <a href="{{ route('product.show', $product->slug) }}">

                                    @if($product->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                        >
                                    @else
                                        <img
                                            src="{{ asset('images/no-image.png') }}"
                                            alt="{{ $product->name }}"
                                        >
                                    @endif

                                </a>

                                {{-- Remove Button --}}
                                <form action="{{ route('wishlist.destroy', $wishlist->id) }}"
                                      method="POST"
                                      class="wishlist-remove-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" title="Remove from wishlist">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </form>

                            </div>

                            {{-- Product Information --}}
                            <div class="wishlist-content">

                                <h3>
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <div class="wishlist-price">

                                    @if($product->discount_price)
                                        <span class="current-price">
                                            ৳{{ number_format((float) $product->discount_price, 2) }}
                                        </span>

                                        <del>
                                            ৳{{ number_format((float) $product->price, 2) }}
                                        </del>
                                    @else
                                        <span class="current-price">
                                            ৳{{ number_format((float) $product->price, 2) }}
                                        </span>
                                    @endif

                                </div>

                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="wishlist-view-btn">

                                    <i class="fas fa-eye"></i>
                                    View Product

                                </a>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="wishlist-pagination">
                {{ $wishlists->links() }}
            </div>

        @else

            {{-- Empty Wishlist --}}
            <div class="wishlist-empty">

                <div class="empty-icon">
                    <i class="far fa-heart"></i>
                </div>

                <h2>Your Wishlist is Empty!</h2>

                <p>
                    You haven't saved any products yet.
                    Explore our collection and add your favorite products.
                </p>

                <a href="{{ route('shop') }}" class="shop-now-btn">
                    <i class="fas fa-shopping-bag"></i>
                    Continue Shopping
                </a>

            </div>

        @endif

    </div>

</section>

@endsection
