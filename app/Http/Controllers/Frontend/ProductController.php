<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'vendor',
        ])
        ->where('slug', $slug)
        ->where('is_approved', true)
        ->firstOrFail();

        return view('frontend.products.show', compact('product'));
    }
}
