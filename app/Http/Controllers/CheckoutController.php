<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use Razorpay\Api\Api;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Services\WatiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user has any previous orders
        $latestOrder = Order::where('user_id', $user->id)
            ->latest('id')
            ->first();

        if ($latestOrder) {
            // Prefill from latest order
            $billingData = [
                'name'              => $latestOrder->billing_name,
                'email'             => $latestOrder->billing_email,
                'phone'             => $latestOrder->billing_phone,
                'zip'               => $latestOrder->billing_zip,
                'locality'          => $latestOrder->billing_locality,
                'street'            => $latestOrder->billing_street,
                'city'              => $latestOrder->billing_city,
                'state'             => $latestOrder->billing_state,
                'landmark'          => $latestOrder->billing_landmark,
                'alternate_phone'   => $latestOrder->billing_alternate_phone,
                'company_name'      => $latestOrder->company_name ?? '',
                'gst_no'            => $latestOrder->gst_no ?? '',
            ];

            $shippingData = [
                'name'              => $latestOrder->shipping_name,
                'email'             => $latestOrder->shipping_email,
                'phone'             => $latestOrder->shipping_phone,
                'zip'               => $latestOrder->shipping_zip,
                'locality'          => $latestOrder->shipping_locality,
                'street'            => $latestOrder->shipping_street,
                'city'              => $latestOrder->shipping_city,
                'state'             => $latestOrder->shipping_state,
                'landmark'          => $latestOrder->shipping_landmark,
                'alternate_phone'   => $latestOrder->shipping_alternate_phone,
            ];
        } else {
            // Fallback from user table
            $billingData = [
                'name'              => $user->name,
                'email'             => $user->email,
                'phone'             => $user->phone_number,
                'zip'               => $user->zip_postal_code,
                'locality'          => $user->locality_house_no,
                'street'            => $user->street_address,
                'city'              => $user->city_district_town,
                'state'             => $user->state,
                'landmark'          => $user->landmark,
                'alternate_phone'   => null,
                'company_name'      => $user->company_name ?? '',
                'gst_no'            => $user->gst_no ?? '',
            ];

            $shippingData = [
                'name'              => '',
                'email'             => '',
                'phone'             => '',
                'zip'               => '',
                'locality'          => '',
                'street'            => '',
                'city'              => '',
                'state'             => '',
                'landmark'          => '',
                'alternate_phone'   => ''
            ]; // default same as billing initially
        }

        return view('checkout', compact('user', 'billingData', 'shippingData'));
    }



    public function guestCheckout()
    {
        return view('guest_checkout');
    }

    public function placeOrder(Request $request)
    {
        /**
         * Check User/Guest is blocked or not
         */
         
         $blockedUser = User::where(function ($q) use ($request) {
                $q->where('email', $request->billing_email)
                  ->orWhere('phone_number', $request->billing_phone);
            })
            ->whereNotNull('blocked_at')
            ->first();

        if ($blockedUser) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'blocked' => 'Your account has been blocked. Please contact support.'
                ]);
        }
        $rules = [
            // Billing details
            'billing_name'            => 'required|string|max:255|regex:/^[A-Za-z\s\.\'-]+$/|not_regex:/^\d+$/',
            'billing_email'           => 'required|email',
            'billing_phone'           => 'required|digits_between:8,15',
            'billing_zip'             => 'required|string|max:20',
            'billing_locality'        => 'required|string|max:255',
            'billing_street'          => 'required|string|max:255',
            'billing_city'            => 'required|string|max:255',
            'billing_state'           => 'required|string|max:255',
            'billing_landmark'        => 'required|string|max:255',
            'billing_alternate_phone' => 'nullable|digits_between:8,15',
            'company_name'            => 'nullable|string|max:255',
            'gst_no' => 'nullable|regex:/^[A-Z0-9]{15}$/',

            // Payment & terms
            'paymentMethod'           => 'required|in:razorpay,cod',
            'termsCheckbox'           => 'accepted',
        ];

        // Only validate shipping if not using same address
        if (!$request->has('shipping_same_as_billing')) {
            $rules = array_merge($rules, [
                'shipping_name'            => 'required|string|max:255|regex:/^[A-Za-z\s\.\'-]+$/|not_regex:/^\d+$/',
                'shipping_email'           => 'required|email',
                'shipping_phone'           => 'required|digits_between:8,15',
                'shipping_zip'             => 'required|string|max:20',
                'shipping_locality'        => 'required|string|max:255',
                'shipping_street'          => 'required|string|max:255',
                'shipping_city'            => 'required|string|max:255',
                'shipping_state'           => 'required|string|max:255',
                'shipping_landmark'        => 'required|string|max:255',
                'shipping_alternate_phone' => 'nullable|digits_between:8,15',
            ]);
        }

        $messages = [
            // Billing messages
            'billing_name.required'     => 'Please enter your full name.',
            'billing_name.regex'    => 'Name can only contain letters, spaces, dots, hyphens and apostrophes.',
            'billing_name.not_regex'=> 'Name cannot be only numbers.',
            'billing_email.required'    => 'We need your email address.',
            'billing_email.email'       => 'Please enter a valid email address.',
            'billing_phone.required'    => 'Phone number is required.',
            'billing_phone.digits_between' => 'Phone number must be between 8 and 15 digits.',
            'billing_zip.required'      => 'ZIP / Postal code is required.',
            'billing_city.required'     => 'City / District is required.',
            'billing_state.required'    => 'State is required.',
            'billing_landmark.required' => 'Please provide a landmark for delivery.',
            
            'gst_no.regex' => 'Please enter a valid GST number (15 characters, A–Z and 0–9 only).',

            // Shipping messages
            'shipping_name.required'     => 'Shipping name is required.',
            'shipping_name.regex'    => 'Name can only contain letters, spaces, dots, hyphens and apostrophes.',
            'shipping_name.not_regex'=> 'Name cannot be only numbers.',
            'shipping_email.required'    => 'Shipping email is required.',
            'shipping_phone.required'    => 'Shipping phone is required.',
            'shipping_zip.required'      => 'Shipping ZIP code is required.',
            'shipping_city.required'     => 'Shipping city is required.',
            'shipping_state.required'    => 'Shipping state is required.',
            'shipping_landmark.required' => 'Please provide a shipping landmark.',

            // Payment & terms
            'paymentMethod.required'    => 'Please select a payment method.',
            'termsCheckbox.accepted'    => 'You must agree to the terms and conditions before placing the order.',
        ];

        $validated = $request->validate($rules, $messages);

        // ðŸ”’ Always override shipping zip with session value
        $shippingZip = session('checkout_postcode');

        // âœ… If shipping = same as billing â†’ copy server-side
        if ($request->boolean('shipping_same_as_billing')) {
            $validated['shipping_name']     = $validated['billing_name'];
            $validated['shipping_email']    = $validated['billing_email'];
            $validated['shipping_phone']    = $validated['billing_phone'];
            $validated['shipping_zip']      = $shippingZip;
            $validated['shipping_locality'] = $validated['billing_locality'];
            $validated['shipping_street']   = $validated['billing_street'];
            $validated['shipping_city']     = $validated['billing_city'];
            $validated['shipping_state']    = $validated['billing_state'];
            $validated['shipping_landmark'] = $validated['billing_landmark'];
            $validated['shipping_alternate_phone'] = $request->billing_alternate_phone;
        }

        //dd($request->all());

        /**Process and insert data**/
        $cartItems = Cart::getContent()->sortBy('id');
        $subtotal = Cart::getSubTotal();
        $total = Cart::getTotal();
        
        // 🔹 Determine the user (logged-in or guest)
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            // Check if a guest user already exists by email
            $guestUser = User::firstOrCreate(
                ['email' => $validated['billing_email']],
                [
                    'name' => $validated['billing_name'],
                    'phone_number' => $validated['billing_phone'],
                    'zip_postal_code' => $validated['billing_zip'],
                    'locality_house_no' => $validated['billing_locality'],
                    'street_address' => $validated['billing_street'],
                    'city_district_town' => $validated['billing_city'],
                    'state' => $validated['billing_state'],
                    'landmark' => $validated['billing_landmark'],
                    'company_name' => $validated['company_name'] ?? null,
                    'gst_no' => $validated['gst_no'] ?? null,
                    'password' => Hash::make("Password@123"), // Default password - Password@123
                    'user_type' => 'guest',
                ]
            );

            $userId = $guestUser->id;
        }

        $order = Order::create([
            //'user_id'                  => Auth::id(), // null if guest
            'user_id'                  => $userId, // null if guest
            'billing_name'             => $validated['billing_name'],
            'billing_email'            => $validated['billing_email'],
            'billing_phone'            => $validated['billing_phone'],
            'billing_zip'              => $validated['billing_zip'],
            'billing_locality'         => $validated['billing_locality'],
            'billing_street'           => $validated['billing_street'],
            'billing_city'             => $validated['billing_city'],
            'billing_state'            => $validated['billing_state'],
            'billing_landmark'         => $validated['billing_landmark'],
            'billing_alternate_phone'  => $validated['billing_alternate_phone'] ?? null,
            'company_name'             => $validated['company_name'] ?? null,
            'gst_no'                   => $validated['gst_no'] ?? null,

            'shipping_same_as_billing' => $request->boolean('shipping_same_as_billing'),
            'shipping_name'            => $validated['shipping_name'] ?? null,
            'shipping_email'           => $validated['shipping_email'] ?? null,
            'shipping_phone'           => $validated['shipping_phone'] ?? null,
            'shipping_zip'             => session('checkout_postcode') ?? null,
            'shipping_locality'        => $validated['shipping_locality'] ?? null,
            'shipping_street'          => $validated['shipping_street'] ?? null,
            'shipping_city'            => $validated['shipping_city'] ?? null,
            'shipping_state'           => $validated['shipping_state'] ?? null,
            'shipping_landmark'        => $validated['shipping_landmark'] ?? null,
            'shipping_alternate_phone' => $validated['shipping_alternate_phone'] ?? null,

            'subtotal'                 => $subtotal,
            'total'                    => $total,
            'payment_method'           => $request->paymentMethod,
            'payment_status'           => 'processing',
            'order_status'             => 'processing',
            'token'                    => $this->createToken()
        ]);

        // Save order items
        foreach ($cartItems as $item) {
            $order->orderitems()->create([
                'product_id'         => $item->attributes->product_id,
                'price_attribute_id' => $item->attributes->price_attribute_id,
                'shop_description'   => $item->attributes->shop_description ?? null,
                'product_name'       => $item->name,
                'quantity'           => $item->quantity,
                'price'              => $item->price,
                'total'              => $item->price * $item->quantity,
            ]);

        }

        /**
         * Razorpay Integrations
         */
        if($request->paymentMethod == 'razorpay'){
            return redirect()->route('razorpay.payment.page', $order->token)->with('success', 'Process the payment');
        }

        /**
         * COD Integrations
         */
        if($request->paymentMethod == 'cod'){
            $order->load(['orderitems.product.combinations']);
            // Send email
            try {
                Mail::to($order->billing_email)->send(new OrderPlacedMail($order));
                
                $emails = explode(',', env('ADMIN_EMAILS'));
                //Mail::to('satnam1122@gmail.com')->send(new OrderPlacedMail($order, true));
                Mail::to($emails)->send(new OrderPlacedMail($order, true));
            } catch (\Throwable $e) {
                \Log::error('Order confirmation email failed: ' . $e->getMessage());
            }

            // Clear cart
            Cart::clear();
            return redirect()->route('checkout.success', $order->order_number)
                         ->with('success', 'Order placed successfully!');
        }
    }


    public function razorpayPaymentPage($token){
        $order = Order::where('token', $token)->firstOrFail();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $orderData = [
            'receipt'         => $order->order_number,
            'amount'          => $order->total * 100, // amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1, // auto capture
        ];

        $razorpayOrder = $api->order->create($orderData);
        $order->razorpay_order_id = $razorpayOrder['id'];
        $order->save();

        return view('razorpay_payment', [
            'order' => $order,
            'razorpayOrderId' => $razorpayOrder->id,
            'razorpayKey' => env('RAZORPAY_KEY'),
        ]);
    }


    public function razorpayVerify(Request $request){
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order = Order::with(['orderitems.product.combinations'])->where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

            $order->update([
                'payment_status' => 'success',
                'order_status' => 'confirmed',
                'token'        => $this->createToken()
            ]);
            
            //Call to update order serial no
            //$this->generateOrderslno($order);

            // Send confirmation email
            /*try {
                //Mail::to($order->billing_email)->send(new OrderPlacedMail($order));
                
                //$emails = explode(',', env('ADMIN_EMAILS'));
                //Mail::to('satnam1122@gmail.com')->send(new OrderPlacedMail($order, true));
                //Mail::to($emails)->send(new OrderPlacedMail($order, true));
            } catch (\Throwable $e) {
                //Log::error('Order confirmation email failed: ' . $e->getMessage());
            }
            */
            
            // Send WhatsApp notification
            /*try {
                $watiService = new WatiService;
            
                $watiService->sendTemplateMessage(
                    mobile: $order->billing_phone,
                    templateName: 'order_success_new',
                    parameters: [
                        ['name' => 'order_id', 'value' => $order->order_number],
                    ],
                    broadcastName: 'order_success'
                );
            } catch (\Throwable $e) {
                \Log::error('WhatsApp notification failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }*/

            Cart::clear();

            return redirect()->route('checkout.success', $order->order_number)
                             ->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            \Log::error('Razorpay verification failed: ' . $e->getMessage());
            /*return redirect()->route('checkout.success', $order->order_number)
                             ->with('error', 'Payment verification failed.');*/
            return redirect()->route('checkout.failed')
                     ->with('error', 'Payment verification failed. Please try again.');
        }
    }

    public function createToken(){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';//Generate token
        return $token = substr(str_shuffle(str_repeat($characters, 16)), 0, 16);
    }


    public function success($orderNo){
        $order = Order::where('order_number', $orderNo)->firstOrFail();
        return view('checkout_success', compact('order'));
    }
    
    public function failed(){
        return view('checkout_failed');
    }
    
    /**
     * 
     * public function generateOrderslno(Order $order)
    {
        return DB::transaction(function () use ($order) {

            $date = Carbon::parse($order->created_at)
                ->timezone(config('app.timezone'))
                ->toDateString();

            $lastSerial = Order::whereDate('created_at', $date)
                ->where('payment_status', 'success')
                ->lockForUpdate() // 🔥 THIS IS THE KEY
                ->max('order_sl_no');

            $nextSerial = ($lastSerial ?? 0) + 1;

            $order->update([
                'order_sl_no' => $nextSerial
            ]);

            return $nextSerial;
        });
    }
    */
    
    public function generateOrderslno(Order $order)
    {
        if ($order->order_sl_no > 0) {
            return $order->order_sl_no;
        }
    
        $date = Carbon::parse($order->created_at)
            ->timezone(config('app.timezone'))
            ->toDateString();
    
        // 🔥 LOCK ACTUAL ROWS (not MAX)
        $lastOrder = Order::whereDate('created_at', $date)
            ->where('payment_status', 'success')
            ->where('order_sl_no', '>', 0)
            ->orderByDesc('order_sl_no')
            ->lockForUpdate()
            ->first();
    
        $lastSerial = $lastOrder?->order_sl_no ?? 0;
    
        $nextSerial = $lastSerial + 1;
    
        $order->update([
            'order_sl_no' => $nextSerial
        ]);
    
        return $nextSerial;
    }

    /**
     * Method : handlePayment
     * Description : Handle webhook response and update payment status
     * @input : $event
     * @output : 200
     **/
    public function handlePayment(Request $request){
        $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

        $payload   = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        
        // Verify webhook signature
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $api->utility->verifyWebhookSignature($payload, $signature, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook Signature Failed: ' . $e->getMessage());
            return response()->json(['status' => 'invalid signature'], 400);
        }
        
        $data  = json_decode($payload, true);
        $event = $data['event'] ?? null;
    
        Log::info('Razorpay Webhook Received: ' . $event, $data);
        
        try {
            switch ($event) {
    
                case 'payment.captured':
                    $payment = $data['payload']['payment']['entity'];
    
                    $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
                    
                    // Insert payment record (idempotent)
                    DB::table('payments')->updateOrInsert(
                        ['payment_id' => $payment['id']],
                        [
                            'order_id'            => $order?->id,
                            'transaction_id'   => $payment['order_id'],
                            'amount'              => $payment['amount'] / 100, // paise to INR
                            'status'              => $payment['status'], // captured
                            'method'              => $payment['method'] ?? null,
                            'event'               => $event,
                        ]
                    );
                    
                    if($order){
                        $order->transaction_id = $payment['order_id'];
                        $order->save(); 
                    }
                    
                    if ($order && $order->payment_status !== 'success') {
                        $order->update([
                            'payment_status'   => 'success',
                            'order_status'     => 'confirmed', // confirmed
                            'razorpay_payment_id' => $payment['id'],
                            
                        ]);
                        
                        //Call to update order serial no
                        $this->generateOrderslno($order);
            
                        // Send confirmation email
                        try {
                            Mail::to($order->billing_email)->send(new OrderPlacedMail($order));
                            
                            $emails = explode(',', env('ADMIN_EMAILS'));
                            //Mail::to('satnam1122@gmail.com')->send(new OrderPlacedMail($order, true));
                            Mail::to($emails)->send(new OrderPlacedMail($order, true));
                        } catch (\Throwable $e) {
                            \Log::error('Order confirmation email failed: ' . $e->getMessage());
                        }
                        
                        // Send WhatsApp notification
                        try {
                            $watiService = new WatiService;
                        
                            $watiService->sendTemplateMessage(
                                mobile: $order->billing_phone,
                                templateName: 'order_success_new',
                                parameters: [
                                    ['name' => 'order_id', 'value' => $order->order_number],
                                ],
                                broadcastName: 'order_success'
                            );
                        } catch (\Throwable $e) {
                            \Log::error('WhatsApp notification failed', [
                                'order_id' => $order->id,
                                'error' => $e->getMessage(),
                            ]);
                        }

                        
                    }
                    break;
    
                case 'payment.failed':
                    $payment = $data['payload']['payment']['entity'];
    
                    $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
                    
                    // Insert payment record (idempotent)
                    DB::table('payments')->updateOrInsert(
                        ['payment_id' => $payment['id']],
                        [
                            'order_id'            => $order?->id,
                            'transaction_id'   => $payment['order_id'],
                            'amount'              => $payment['amount'] / 100, // paise to INR
                            'status'              => 'failed', // failed
                            'method'              => $payment['method'] ?? null,
                            'event'               => $event,
                        ]
                    );
    
                    if ($order && $order->payment_status !== 'success') {
                        $order->update([
                            'transaction_id' => $payment['order_id'],
                            'payment_status' => 'failed',
                            'order_status'   => 'cancelled', // failed
                        ]);
                    }
                    break;
    
                case 'refund.created':
                case 'refund.processed':
                    $refund  = $data['payload']['refund']['entity'];
                    $paymentId = $refund['payment_id'] ?? null;
    
                    $order = Order::where('razorpay_payment_id', $paymentId)->first();
    
                    if ($order) {
                        // $order->update([
                        //     'payment_status' => 'refunded',
                        //     'order_status'   => 'refunded',
                        // ]);
                    }
                    break;
    
                default:
                    Log::info('Unhandled Razorpay event: ' . $event);
                    break;
            }
    
            return response()->json(['status' => 'ok'], 200);
    
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook Handling Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

}
