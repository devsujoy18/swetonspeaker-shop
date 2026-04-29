<x-front-layout>
    <div class="bg-gray-100 py-4 border-b">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-700" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-red-600 hover:underline">Home</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-800">Payment</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto my-10 px-4">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="bg-red-600 text-white text-center py-4">
                <h2 class="text-xl font-semibold tracking-wide">Secure Payment</h2>
            </div>

            <div class="p-6 text-center">
                <img src="{{ asset('image/razorpay-logo.png')}}" alt="Razorpay" class="mx-auto mb-4 w-24">

                <h4 class="text-lg font-semibold mb-1">Order #{{ $order->order_number }}</h4>
                <p class="text-gray-600 mb-4">Please complete your payment to confirm your order.</p>

                <div class="bg-gray-50 border rounded-lg py-3 mb-6">
                    <p class="text-lg">
                        Total Amount: 
                        <span class="text-green-600 font-bold">₹{{ number_format($order->total, 2) }}</span>
                    </p>
                </div>

                <button id="rzp-button"
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full text-base font-medium shadow transition-all duration-200">
                    <i class="bi bi-credit-card-fill mr-2"></i> Pay with Razorpay
                </button>

                <p class="text-xs text-gray-500 mt-4 flex items-center justify-center gap-1">
                    <i class="bi bi-lock-fill text-green-600"></i> 
                    100% Secure Payment via SSL Encryption
                </p>
            </div>

            <div class="bg-gray-100 text-center text-sm text-gray-600 py-3">
                Need help? 
                <a href="https://swetonspeakers.com/contact-us" class="text-red-600 hover:underline font-medium">Contact Support</a>
            </div>
        </div>
    </div>

    <!-- Fullscreen Loader -->
    <div id="payment-loader" class="fixed inset-0 bg-white/90 z-50 hidden flex-col items-center justify-center">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-red-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="text-gray-800 font-medium text-lg">Processing your payment...</p>
            <p class="text-gray-500 text-sm mt-1">Please don’t refresh or close this page</p>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    document.getElementById('rzp-button').onclick = function(e) {
        e.preventDefault();

        var options = {
            "key": "{{ $razorpayKey }}",
            "amount": "{{ $order->total * 100 }}",
            "currency": "INR",
            "name": "SWETON",
            "description": "Payment for Order #{{ $order->order_number }}",
            "order_id": "{{ $razorpayOrderId }}",
            "handler": function (response) {
                // Show loader immediately after payment success
                document.getElementById('payment-loader').classList.remove('hidden');

                fetch("{{ route('razorpay.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(response)
                }).then(() => {
                    window.location.href = "{{ route('checkout.success', $order->order_number) }}";
                }).catch(() => {
                    alert('Payment verification failed. Please contact support.');
                    document.getElementById('payment-loader').classList.add('hidden');
                });
            },
            "theme": {
                "color": "#dc2626"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
    </script>
</x-front-layout>
