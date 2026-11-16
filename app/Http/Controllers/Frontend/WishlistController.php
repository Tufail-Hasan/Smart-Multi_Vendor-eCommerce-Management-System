<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display customer wishlist.
     */
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $wishlists = Wishlist::with('product')
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate(12);

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    /**
     * Add product to wishlist.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $customerId = Auth::guard('customer')->id();

        $wishlist = Wishlist::firstOrCreate([
            'customer_id' => $customerId,
            'product_id' => $validated['product_id'],
        ]);

        if ($wishlist->wasRecentlyCreated) {
            return back()->with('success', 'Product added to your wishlist!');
        }

        return back()->with('info', 'This product is already in your wishlist.');
    }

    /**
     * Remove product from wishlist.
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('customer_id', Auth::guard('customer')->id())
            ->findOrFail($id);

        $wishlist->delete();

        return back()->with('success', 'Product removed from your wishlist!');
    }
}
