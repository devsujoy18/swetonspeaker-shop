<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Old\Order;

class OldOrderController extends Controller
{
	public function index(){
	    $userId = Auth::id();
	    
		DB::connection('old_mysql')->getPdo();
		
        $orders = Order::with('details')
            ->where('user_id', $userId)
            ->where('payment_status', 2)
            ->orderBy('order_date', 'desc')
            ->get();
            
        return view('old.order_list', compact('orders'));
	}

}