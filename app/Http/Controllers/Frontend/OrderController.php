<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Customer's order list.
     */
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $orders = Order::where('customer_id', $customerId)
            ->with('items')
            ->latest()
            ->paginate(10);

        $totalOrders = Order::where('customer_id', $customerId)->count();

        $pendingOrders = Order::where('customer_id', $customerId)
            ->whereIn('status', ['pending', 'confirmed', 'processing'])
            ->count();

        $completedOrders = Order::where('customer_id', $customerId)
            ->where('status', 'delivered')
            ->count();

        return view('frontend.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'completedOrders'
        ));
    }

    /**
     * Customer's order details.
     */
    public function show($id)
    {
        $customerId = Auth::guard('customer')->id();

        $order = Order::where('customer_id', $customerId)
            ->with([
                'items.product',
                'statuses',
                'shippings',
                'payments',
            ])
            ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }
}
