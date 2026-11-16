@extends('frontend.layouts.app')

@section('title', 'Frequently Asked Questions | MarketPro')

@section('content')

{{-- FAQ Hero --}}
<section class="faq-hero">
    <div class="container">
        <span class="faq-hero-label">HELP CENTER</span>

        <h1>Frequently Asked Questions</h1>

        <p>
            Find answers to common questions about shopping,
            orders, payments and more.
        </p>

        <div class="faq-search">
            <i class="fas fa-search"></i>

            <input
                type="text"
                id="faqSearch"
                placeholder="Search your questions..."
            >
        </div>
    </div>
</section>


{{-- FAQ Section --}}
<section class="faq-section">
    <div class="container">

        @if(session('success'))
            <div class="faq-success-message">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="faq-layout">

            {{-- Sidebar --}}
            <div class="faq-sidebar">

                <h3>FAQ Categories</h3>

                <button class="faq-category active" data-category="all">
                    <i class="fas fa-th-large"></i>
                    All Questions
                    <span>{{ $faqs->count() }}</span>
                </button>

                @foreach($categories as $category)
                    <button
                        class="faq-category"
                        data-category="{{ strtolower($category) }}"
                    >
                        <i class="fas fa-folder"></i>

                        {{ $category }}

                        <span>
                            {{ $faqs->where('category', $category)->count() }}
                        </span>
                    </button>
                @endforeach

            </div>


            {{-- FAQ Content --}}
            <div class="faq-main">

                @if($featuredFaqs->isNotEmpty())
                    <div class="faq-featured-box">
                        <h3>
                            <i class="fas fa-star"></i>
                            Popular Questions
                        </h3>

                        @foreach($featuredFaqs as $faq)
                            <a href="#faq-{{ $faq->id }}">
                                {{ $faq->question }}
                            </a>
                        @endforeach
                    </div>
                @endif


                <div class="faq-list">

                    @forelse($faqs as $faq)

                        <div
                            class="faq-item"
                            id="faq-{{ $faq->id }}"
                            data-category="{{ strtolower($faq->category ?? '') }}"
                            data-question="{{ strtolower($faq->question) }}"
                            data-answer="{{ strtolower(strip_tags($faq->answer)) }}"
                        >

                            <button class="faq-question">
                                <span>
                                    {{ $faq->question }}

                                    @if($faq->is_featured)
                                        <span class="faq-popular-badge">
                                            Popular
                                        </span>
                                    @endif
                                </span>

                                <i class="fas fa-plus"></i>
                            </button>


                            <div class="faq-answer">

                                <div class="faq-answer-content">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>

                                <div class="faq-helpful">

                                    <span>Was this answer helpful?</span>

                                    <form
                                        action="{{ route('faq.helpful', $faq) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="feedback"
                                            value="yes"
                                        >

                                        <button type="submit">
                                            <i class="far fa-thumbs-up"></i>
                                            Yes ({{ $faq->helpful_count }})
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="faq-empty">
                            <i class="far fa-question-circle"></i>

                            <h3>No FAQs Available</h3>

                            <p>There are currently no published questions.</p>
                        </div>

                    @endforelse

                    <div class="faq-no-results" id="faqNoResults">
                        <i class="fas fa-search"></i>
                        <h3>No matching questions found</h3>
                        <p>Try searching with different keywords.</p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>


{{-- Contact Support --}}
<section class="faq-contact">
    <div class="container">

        <div class="faq-contact-content">

            <div>
                <h2>Still Have Questions?</h2>

                <p>
                    Can't find the answer you're looking for?
                    Our support team is here to help.
                </p>
            </div>

            <a href="{{ route('contact.index') }}">
                Contact Us
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>
</section>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const faqItems = document.querySelectorAll('.faq-item');
    const categoryButtons = document.querySelectorAll('.faq-category');
    const searchInput = document.getElementById('faqSearch');
    const noResults = document.getElementById('faqNoResults');

    let selectedCategory = 'all';

    // Accordion
    document.querySelectorAll('.faq-question').forEach(button => {

        button.addEventListener('click', function () {

            const currentItem = this.closest('.faq-item');
            const isOpen = currentItem.classList.contains('active');

            faqItems.forEach(item => {
                item.classList.remove('active');
            });

            if (!isOpen) {
                currentItem.classList.add('active');
            }

        });

    });


    // Filter Function
    function filterFaqs() {

        const searchText = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        faqItems.forEach(item => {

            const category = item.dataset.category;
            const question = item.dataset.question;
            const answer = item.dataset.answer;

            const matchesCategory =
                selectedCategory === 'all' ||
                category === selectedCategory;

            const matchesSearch =
                question.includes(searchText) ||
                answer.includes(searchText);

            if (matchesCategory && matchesSearch) {

                item.style.display = 'block';
                visibleCount++;

            } else {

                item.style.display = 'none';
                item.classList.remove('active');

            }

        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }


    // Category Filter
    categoryButtons.forEach(button => {

        button.addEventListener('click', function () {

            categoryButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            this.classList.add('active');

            selectedCategory = this.dataset.category;

            filterFaqs();

        });

    });


    // Search
    searchInput.addEventListener('input', filterFaqs);

});
</script>
@endpush

@endsection
