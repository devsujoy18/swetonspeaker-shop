<div>
        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Reviews</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg shadow border border-yellow-200">
                    <div class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-yellow-600">Pending</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg shadow border border-green-200">
                    <div class="text-2xl font-bold text-green-700">{{ $stats['approved'] }}</div>
                    <div class="text-sm text-green-600">Approved</div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg shadow border border-red-200">
                    <div class="text-2xl font-bold text-red-700">{{ $stats['rejected'] }}</div>
                    <div class="text-sm text-red-600">Rejected</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Search by product, user, or comment..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select wire:model.live="statusFilter" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="ratingFilter"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($reviews as $review)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ $review->product->name }}</div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="text-yellow-400 text-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                                    @endfor
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                                    @if($review->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($review->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="text-sm text-gray-600">
                                                <strong>User:</strong> {{ $review->user->name }} ({{ $review->user->email }})<br>
                                                <strong>Order:</strong> {{ $review->order->order_number }}<br>
                                                <strong>Date:</strong> {{ $review->created_at->format('d M Y, h:i A') }}
                                            </div>
                                            
                                            @if($review->comment)
                                                <div class="bg-gray-50 p-3 rounded text-sm mt-2">
                                                    <strong>Comment:</strong> {{ $review->comment }}
                                                </div>
                                            @endif
                                            
                                            @if($review->admin_note)
                                                <div class="bg-yellow-50 p-3 rounded text-sm mt-2">
                                                    <strong>Admin Note:</strong> {{ $review->admin_note }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex gap-2 ml-4">
                                            @if($review->status === 'pending')
                                                <button wire:click="approveReview({{ $review->id }})"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-green-100 text-green-700 border-green-300">
                                                    Approve
                                                </button>
                                                <button wire:click="selectReview({{ $review->id }})"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                    Reject
                                                </button>
                                            @elseif($review->status === 'approved')
                                                <button wire:click="pendingReview({{ $review->id }})"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-blue-100 text-blue-700 border border-blue-300">
                                                    Reset
                                                </button>
                                            @elseif($review->status === 'rejected')
                                                <button wire:click="approveReview({{ $review->id }})"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                                    Approve
                                                </button>
                                                <button wire:click="pendingReview({{ $review->id }})"
                                                    wire:confirm="Are you sure?"
                                                        class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                                                    Reset
                                                </button>
                                            @endif
                                            
                                            <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                    class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                                View Details
                                            </a>
                                            
                                            <button wire:click="deleteReview({{ $review->id }})"
                                                    wire:confirm="Are you sure you want to delete this review?"
                                                    class="px-3 py-1 bg-red-100 text-red-700 border border-red-300">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        {{ $reviews->links() }}
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-lg mb-2">No reviews found</div>
                            <div class="text-sm">Try adjusting your filters or search terms</div>
                        </div>
                    @endif
            </div>
        </div>

        <!-- Success Notification with Auto-dismiss -->
        <div x-data="{ show: @entangle('showNotification') }" 
             x-show="show" 
             x-transition
             @click="show = false"
             x-init="$watch('show', value => { if(value) setTimeout(() => show = false, 3000) })"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 cursor-pointer">
            <span x-text="$wire.notificationMessage"></span>
        </div>
</div>