<x-front-layout>
    <div class="bg-gray-100 py-10">
        <div class="container mx-auto px-4">

            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-700 mb-6" aria-label="breadcrumb">
                <ol class="flex space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a>
                        <span class="mx-2"> / </span>
                    </li>
                    <li class="text-gray-800 font-medium">Payment Failed</li>
                </ol>
            </nav>

            <!-- Failed Card -->
            <div class="bg-white shadow-lg rounded-2xl p-8 text-center">

                <!-- Failed Icon -->
                <div class="flex justify-center mb-4">
                    <div class="bg-red-100 text-red-600 w-16 h-16 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-10 w-10" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v3m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 17c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>

                <!-- Heading -->
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Payment Failed!
                </h1>

                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    Unfortunately, your payment could not be verified.
                    <br>
                    Please try again or choose a different payment method.
                </p>


                <!-- CTA Buttons -->
                <div class="mt-6 flex justify-center gap-4">
                    <!-- <a href="#"
                       class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700 transition">
                        Try Payment Again
                    </a> -->

                    <a href="{{ route('home') }}"
                       class="bg-gray-100 text-gray-700 px-6 py-2 rounded-xl hover:bg-gray-200 transition">
                        Continue Shopping
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-front-layout>
