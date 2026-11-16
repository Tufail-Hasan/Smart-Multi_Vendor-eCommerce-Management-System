<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    /**
     * Show Track Order Page.
     */
    public function index()
    {
        return view('frontend.track-order.index');
    }

    /**
     * Track Customer Order.
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $shipping = Shipping::with([
            'order.items.product',
            'order.statuses',
        ])
            ->whereHas('order', function ($query) use ($validated) {
                $query->where('order_number', $validated['order_number']);
            })
            ->where('recipient_phone', $validated['phone'])
            ->latest()
            ->first();

        if (!$shipping) {
            return back()
                ->withInput()
                ->with('error', 'No order found! Please check your Order Number and Phone Number.');
        }

        return view('frontend.track-order.result', compact('shipping'));
    }
}
