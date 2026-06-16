<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('isAdmin') || $user->can('isSubadmin')) {
            $paidOrders = $this->paidOrdersQuery();

            // Stats
            $totalOrders = Order::count();
            $totalRevenue = (clone $paidOrders)->get()->sum(fn (Order $order) => $order->netAmount());
            $totalUsers = User::where('user_type', 'LIKE', '%user%')->count();
            $pendingOrders = Order::where('order_status', 'processing')->count();

            // Charts: last 7 days orders & revenue
            $dates = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i)->format('Y-m-d'));

            $ordersData = $dates->map(fn ($date) => (clone $paidOrders)->whereDate('order_date', $date)->count());

            $revenueData = $dates->map(fn ($date) => (clone $paidOrders)->whereDate('order_date', $date)->get()->sum(fn (Order $order) => $order->netAmount()));

            // Latest 10 entries
            $latestOrders = Order::latest()->take(10)->get();
            $latestUsers = User::where('user_type', 'user')->latest()->take(10)->get();

            return view('dashboard', compact(
                'totalOrders', 'totalRevenue', 'totalUsers', 'pendingOrders',
                'dates', 'ordersData', 'revenueData', 'latestOrders', 'latestUsers'
            ));
        }

        if ($user->can('isUser')) {

            $totalOrders = $user->orders()->count();
            $activeOrders = $user->orders()
                ->whereIn('order_status', ['pending', 'processing', 'shipped'])
                ->count();
            $pendingPayments = $user->orders()
                ->where('payment_status', 'unpaid')
                ->count();

            $recentOrders = $user->orders()->latest()->take(5)->get();

            return view('dashboard', compact(
                'user', 'totalOrders', 'activeOrders', 'pendingPayments', 'recentOrders'
            ));
        }

        abort(403, 'Unauthorized page access');

    }

    private function paidOrdersQuery(): Builder
    {
        return Order::financialLedger();
    }
}
