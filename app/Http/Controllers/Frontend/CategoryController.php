<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all active categories.
     */
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Display category details and products.
     */
    public function show(Request $request, $slug)
    {
        $category = Category::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->firstOrFail();

        $categoryIds = collect([$category->id])
            ->merge($category->children->pluck('id'));

        $products = Product::query()
            ->where('is_approved', true)
            ->whereIn('category_id', $categoryIds)
            ->with(['brand', 'category'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'frontend.categories.show',
            compact('category', 'products')
        );
    }
}
