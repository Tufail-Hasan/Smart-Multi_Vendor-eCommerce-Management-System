<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()
            ->ordered()
            ->get();

        $categories = Faq::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $featuredFaqs = Faq::active()
            ->featured()
            ->ordered()
            ->take(5)
            ->get();

        return view('frontend.faq.index', compact(
            'faqs',
            'categories',
            'featuredFaqs'
        ));
    }

    public function helpful(Faq $faq, Request $request)
    {
        $request->validate([
            'feedback' => ['required', 'in:yes'],
        ]);

        if (! $faq->is_active) {
            abort(404);
        }

        $faq->increment('helpful_count');

        return back()->with('success', 'Thank you for your feedback!');
    }
}