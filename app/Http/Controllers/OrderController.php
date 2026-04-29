<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('orderitems')   // eager load items
            ->with([
                'reviews' => function ($query) {
                    $query->where('user_id', Auth::id())
                        ->with('product');
                },
            ])
            ->withCount([
                'reviews as user_reviews_count' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($order_number)
    {
        $order = Order::with([
            'orderitems.product.primaryImage'
        ])
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
    
    /**
     * Admin only
     */
    public function allOrders(Request $request){
        $query = Order::with('orderitems', 'orderitems.product','user');

        // Filters
        if ($request->status) {
            $query->where('order_status', $request->status);
        }
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('order_date', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay(),
            ]);
        }

        $orders = $query->latest()->paginate(10);

        return view('orders.all_orders', compact('orders'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order->order_status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->order_status
        ]);
    }
    
    /**
     * Order Details
     **/
    public function showDetails(Order $order){
        $order->load([
            'orderitems.product',
            'user'
        ]);

        return view('orders.show_details', compact('order'));
    }

    /**
     * Product review page
     **/
    public function product_review($order_number){
        $order = Order::with(['orderitems.product'])
            ->where('order_number', $order_number)
            ->where('user_id', Auth::id())
            ->where('order_status', 'complete') // Only allow reviews for completed orders
            ->firstOrFail();        
        return view('orders.reviews_create', compact('order'));    
    }
    
    /**
     * Admin review details view page
     **/
    public function review_details($reviewId){
        return view('orders.review_details', compact('reviewId'));  
    }
    
    /**
     * Modify Orders
     */
    public function modifyOrder(Order $order){
        abort_unless(auth()->user()?->can('isAdmin'), 403);

        // if ($order->payment_status !== 'success') {
        //     abort(403);
        // }

        $order->load([
            'orderitems.product',
            'user'
        ]);

        return view('orders.edit_order', compact('order'));
    }
}
