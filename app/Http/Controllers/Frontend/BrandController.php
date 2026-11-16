<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // All Brands Page
    public function index()
    {
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('frontend.brands.index', compact('brands'));
    }

    // Single Brand Products Page
    public function show(Request $request, $slug)
    {
        $brand = Brand::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::query()
            ->where('brand_id', $brand->id)
            ->where('is_approved', true)
            ->with(['category', 'brand'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.brands.show', compact(
            'brand',
            'products'
        ));
    }
}
