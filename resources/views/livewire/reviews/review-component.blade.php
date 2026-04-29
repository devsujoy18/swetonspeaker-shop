<div>
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
            <div class="text-sm text-gray-600">
                <p>Order Date: {{ $order->order_date->format('d M Y') }}</p>
                <p>Total Amount: Rs. {{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-6">Rate Your Products</h3>

            <form wire:submit="submitReviews">
                @foreach($orderItems as $item)
                    @php
                        $review = $reviews[$item->id] ?? ['rating' => 0, 'comment' => '', 'existing_id' => null, 'status' => 'pending'];
                        $image = $item->product->primaryImage;
                    @endphp

                    <div class="mb-8 pb-8 border-b last:border-b-0">
                        <div class="flex gap-4 mb-4">
                            <img
                                src="{{ $image ? env('IMG_HOST').'uploads/'.$image->path : asset('images/buy.jpg') }}"
                                class="h-16 w-16 rounded object-cover"
                                alt="{{ $item->product->name }}"
                            >

                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} | Rs. {{ number_format($item->price, 2) }}</p>

                                @if($review['existing_id'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($review['status'] === 'approved') bg-green-100 text-green-800
                                        @elseif($review['status'] === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($review['status'] ?? 'pending') }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-2">Review submitted. Editing is disabled.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button
                                        type="button"
                                        wire:click="setRating({{ $item->id }}, {{ $i }})"
                                        @disabled($review['existing_id'])
                                        class="text-2xl transition-colors duration-200 {{ $review['rating'] >= $i ? 'text-yellow-400 hover:text-yellow-500' : 'text-gray-300 hover:text-yellow-400' }} {{ $review['existing_id'] ? 'cursor-not-allowed opacity-70' : '' }}"
                                    >
                                        &#9733;
                                    </button>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">{{ $review['rating'] }}/5</span>
                            </div>
                            @error('reviews.'.$item->id.'.rating')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="comment-{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                Comment (optional)
                            </label>
                            <textarea
                                wire:model="reviews.{{ $item->id }}.comment"
                                id="comment-{{ $item->id }}"
                                rows="3"
                                @disabled($review['existing_id'])
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Share your experience with this product..."
                            ></textarea>
                            @error('reviews.'.$item->id.'.comment')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach

                @if($this->hasEditableItems())
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('orders.show', $order->order_number) }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            @disabled(!$this->hasAnyReviews())
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
                        >
                            Submit Reviews
                        </button>
                    </div>
                @else
                    <p class="text-sm text-gray-600">All products in this order are already reviewed.</p>
                @endif
            </form>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
            <h4 class="font-medium text-blue-900 mb-2">Review Guidelines</h4>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>- Be honest and detailed in your review</li>
                <li>- Focus on product quality, features, and your experience</li>
                <li>- Reviews will be published after admin approval</li>
                <li>- Each product can be reviewed only once</li>
            </ul>
        </div>
    </div>
</div>
