@extends('frontend.layouts.app')

@section('title', 'Contact Us - MarketPro')

@section('content')

<div class="contact-page">

    {{-- Hero Section --}}
    <section class="contact-hero">
        <div class="container">
            <span class="contact-badge">GET IN TOUCH</span>

            <h1>We'd Love to Hear From You</h1>

            <p>
                Have a question, suggestion, or need help?
                Send us a message and our team will get back to you.
            </p>

            <div class="contact-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Contact Us</span>
            </div>
        </div>
    </section>


    {{-- Contact Information & Form --}}
    <section class="contact-main-section">
        <div class="container">

            <div class="contact-main-grid">

                {{-- Left Side --}}
                <div class="contact-info-card">

                    <span class="contact-small-title">CONTACT INFORMATION</span>

                    <h2>Let's Start a Conversation</h2>

                    <p class="contact-info-description">
                        We are always ready to help you.
                        Feel free to contact us with any questions
                        about our products or services.
                    </p>

                    <div class="contact-info-list">

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div>
                                <h4>Email Support</h4>
                                <p>Send us your questions through the contact form.</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-comments"></i>
                            </div>

                            <div>
                                <h4>Customer Support</h4>
                                <p>We are happy to assist you with your shopping experience.</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-clock"></i>
                            </div>

                            <div>
                                <h4>Response Time</h4>
                                <p>Our team will respond as soon as possible.</p>
                            </div>
                        </div>

                    </div>

                    <div class="contact-social-area">
                        <h4>Stay Connected</h4>

                        <div class="contact-social-links">
                            <a href="#" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a href="#" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>

                            <a href="#" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <a href="#" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>

                </div>


                {{-- Right Side Form --}}
                <div class="contact-form-card">

                    <div class="contact-form-heading">
                        <span class="contact-small-title">SEND A MESSAGE</span>

                        <h2>Get In Touch</h2>

                        <p>Fill out the form below and we'll contact you shortly.</p>
                    </div>


                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="contact-alert contact-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif


                    {{-- Error Message --}}
                    @if($errors->any())
                        <div class="contact-alert contact-error">
                            <i class="fas fa-exclamation-circle"></i>

                            <div>
                                <strong>Please fix the following errors:</strong>

                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif


                    <form action="{{ route('contact.store') }}"
                          method="POST"
                          class="contact-form">

                        @csrf

                        <div class="contact-form-row">

                            <div class="contact-form-group">
                                <label for="name">Full Name *</label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    required
                                >
                            </div>

                            <div class="contact-form-group">
                                <label for="email">Email Address *</label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="example@email.com"
                                    required
                                >
                            </div>

                        </div>


                        <div class="contact-form-row">

                            <div class="contact-form-group">
                                <label for="phone">Phone Number</label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter phone number"
                                >
                            </div>

                            <div class="contact-form-group">
                                <label for="subject">Subject *</label>

                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    placeholder="Enter subject"
                                    required
                                >
                            </div>

                        </div>


                        <div class="contact-form-group">
                            <label for="message">Your Message *</label>

                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                placeholder="Write your message here..."
                                required
                            >{{ old('message') }}</textarea>
                        </div>


                        <button type="submit" class="contact-submit-btn">
                            Send Message

                            <i class="fas fa-paper-plane"></i>
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </section>


    {{-- Bottom Section --}}
    <section class="contact-bottom-section">
        <div class="container">

            <div class="contact-bottom-content">
                <div>
                    <span>NEED HELP?</span>
                    <h2>We're Here to Make Shopping Easier</h2>
                    <p>
                        Contact our team whenever you need assistance.
                    </p>
                </div>

                <a href="{{ route('shop') }}" class="contact-shop-btn">
                    Explore Products
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

</div>

@endsection
