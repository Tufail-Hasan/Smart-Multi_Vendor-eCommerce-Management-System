<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // All Blogs Page
    public function index(Request $request)
    {
        $query = Blog::published();

        // Search Blogs
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Featured Blogs
        $featuredBlogs = Blog::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // All Blogs
        $blogs = $query
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9)
            ->withQueryString();

        // Available Categories
        $categories = Blog::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('frontend.blogs.index', compact(
            'blogs',
            'featuredBlogs',
            'categories'
        ));
    }


    // Single Blog Details Page
    public function show($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increase Blog Views
        $blog->increment('views');

        $blog->refresh();

        // Related Blogs
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->when($blog->category, function ($query) use ($blog) {
                $query->where('category', $blog->category);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.blogs.show', compact(
            'blog',
            'relatedBlogs'
        ));
    }
}
