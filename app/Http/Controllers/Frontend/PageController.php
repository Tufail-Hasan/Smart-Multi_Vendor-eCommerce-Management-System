<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::published()
            ->where('slug', 'about-us')
            ->firstOrFail();

        return view('frontend.pages.about', compact('page'));
    }
}
