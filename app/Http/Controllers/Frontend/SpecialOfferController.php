<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('is_approved', true)
            ->whereNotNull('discount_price')
            ->where('discount_price', '>', 0)
            ->whereColumn('discount_price', '<', 'price')
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.offers.index', compact('products'));
    }
}
