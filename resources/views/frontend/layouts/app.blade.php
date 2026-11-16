<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MarketPro - Online Shopping')</title>

    <meta name="description" content="@yield('meta_description', 'Discover amazing products at MarketPro.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
</head>

<body>

    <!-- Top Announcement -->
    <div class="announcement">
        <div class="container announcement-content">
            <span>Welcome to MarketPro Marketplace!</span>
            <span>Free Shipping on Selected Orders</span>
        </div>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">

            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">M</span>
                Market<span>Pro</span>
            </a>

            <form action="{{ url('/shop') }}" method="GET" class="search-box">
                <input
                    type="search"
                    name="search"
                    placeholder="Search products, brands and more..."
                >
                <button type="submit">⌕</button>
            </form>

            <div class="header-actions">
                <!-- <a href="{{ url('/account') }}" class="header-link">
                    <span>♙</span>
                    <small>Account</small>
                </a> -->
                <a href="{{ route('account.index') }}">
    <i class="fas fa-user"></i>
    Account
</a>

                <!-- <a href="{{ url('/wishlist') }}" class="header-link">
                    <span>♡</span>
                    <small>Wishlist</small>
                </a> -->
<a href="{{ route('wishlist.index') }}">
    <i class="fas fa-heart"></i>
    Wishlist
</a>

                <!-- <a href="{{ url('/cart') }}" class="header-link">
                    <span>🛒</span>
                    <small>Cart</small>
                </a> -->
                <a href="{{ route('cart.index') }}">
    <i class="fas fa-shopping-cart"></i>
    Cart
</a>
            </div>

        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container nav-content">

            <a href="{{ route('home') }}">Home</a>
            <a href="{{ url('/shop') }}">Shop</a>
            <a href="{{ route('categories.index') }}">Categories</a>
            <!-- <a href="{{ url('/categories') }}">Categories</a> -->
            <!-- <a href="{{ url('/brands') }}">Brands</a> -->
            <a href="{{ route('brands.index') }}">Brands</a>
            <!-- <a href="{{ url('/offers') }}">Special Offers</a> -->
            <a href="{{ route('offers.index') }}">Special Offers</a>
            <!-- <a href="{{ url('/blogs') }}">Blog</a> -->
            <a href="{{ route('blogs.index') }}">Blog</a>
            <!-- <a href="{{ url('/contact') }}">Contact</a> -->
            <a href="{{ route('contact.index') }}">Contact</a>

        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-grid">

            <div>
                <a href="{{ route('home') }}" class="logo footer-logo">
                    <span class="logo-icon">M</span>
                    Market<span>Pro</span>
                </a>

                <p>
                    Your trusted multi-vendor marketplace.
                    Discover quality products from trusted sellers.
                </p>
            </div>

            <div>
                <h4>Quick Links</h4>
                <a href="{{ url('/shop') }}">Shop</a>
                <!-- <a href="{{ url('/about') }}">About Us</a> -->
                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ url('/blogs') }}">Our Blog</a>
            </div>

            <div>
                <h4>Customer Service</h4>
                <a href="{{ url('/account') }}">My Account</a>
                <!-- <a href="{{ url('/orders') }}">My Orders</a> -->
                <a href="{{ route('orders.index') }}">My Orders</a>
                <!-- <a href="{{ url('/track-order') }}">Track Order</a> -->
                <a href="{{ route('track-order.index') }}">Track Order</a>
                <!-- <a href="{{ url('/faq') }}">FAQs</a> -->
                <a href="{{ route('faq.index') }}">FAQs</a>
            </div>

            <div>
                <h4>Contact Us</h4>
                <p>Email: support@marketpro.com</p>
                <p>Phone: +880 1XXXXXXXXX</p>
                <p>Bangladesh</p>
            </div>

        </div>

        <div class="copyright">
            <div class="container">
                © {{ date('Y') }} MarketPro. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="{{ asset('frontend/js/app.js') }}"></script>
    @stack('scripts')

</body>
</html>
