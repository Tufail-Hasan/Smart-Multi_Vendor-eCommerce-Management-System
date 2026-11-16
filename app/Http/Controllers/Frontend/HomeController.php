<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // Latest Products
        $products = Product::query()
            ->where('is_approved', true)
            ->with(['category', 'brand'])
            ->latest()
            ->take(8)
            ->get();

        // Featured Products
        $featuredProducts = Product::query()
            ->where('is_approved', true)
            ->where('is_featured', true)
            ->with(['category', 'brand'])
            ->latest()
            ->take(8)
            ->get();

        // Active Parent Categories
        //$categories = Category::active()
        // ->parentCategories()
        // ->withCount('products')
        //->latest()
        //->take(8)
        //->get();
        // Active Parent Categories
        $categories = Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->take(8)
            ->get();

        // Active Brands
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('name')
            ->take(10)
            ->get();

        // Homepage Sliders
        $sliders = Slider::query()
            ->where('is_active', true)
            ->where('position', 'homepage')
            ->where(function ($query) {
                $query->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            })
            ->orderBy('sort_order')
            ->latest()
            ->get();

        // Homepage Banners
        $banners = Banner::active()
            ->where('position', 'home')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('frontend.home', compact(
            'products',
            'featuredProducts',
            'categories',
            'brands',
            'sliders',
            'banners'
        ));
    }
}
