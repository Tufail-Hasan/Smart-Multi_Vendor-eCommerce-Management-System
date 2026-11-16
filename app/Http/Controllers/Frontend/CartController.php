<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get or create customer's active cart.
     */
    private function getCart()
    {
        return Cart::firstOrCreate([
            'customer_id' => Auth::guard('customer')->id(),
            'status' => 'active',
        ]);
    }

    /**
     * Display shopping cart.
     */
    public function index()
    {
        $cart = $this->getCart();

        $cart->load('items.product');

        return view('frontend.cart.index', compact('cart'));
    }

    /**
     * Add product to cart.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $quantity = $validated['quantity'] ?? 1;

        if ($product->stock < $quantity) {
            return back()->with('error', 'Sorry! Not enough stock available.');
        }

        $cart = $this->getCart();

        $cartItem = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $newQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return back()->with('success', 'Product added to your cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();

        $cartItem = $cart->items()
            ->with('product')
            ->findOrFail($id);

        if ($validated['quantity'] > $cartItem->product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update([
            'quantity' => $validated['quantity'],
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        $cart = $this->getCart();

        $cart->items()->findOrFail($id)->delete();

        return back()->with('success', 'Product removed from cart!');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        $cart = $this->getCart();

        $cart->items()->delete();

        return back()->with('success', 'Your cart has been cleared!');
    }
}