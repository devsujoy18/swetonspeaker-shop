<?php

namespace App\Livewire\Reviews;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Productreview;
use Illuminate\Support\Facades\Auth;

class ReviewComponent extends Component
{
    public $order;
    public $orderItems;
    public $reviews = [];
    public $showReviewForm = false;
    public $orderNumber; // Add this property to hold the order number

    protected $rules = [
        'reviews.*.rating' => 'required|integer|min:1|max:5',
        'reviews.*.comment' => 'nullable|string|max:1000',
    ];
    
    protected $messages = [
        'reviews.*.rating.required' => 'Please select a rating before submitting your review.',
        'reviews.*.rating.integer'  => 'The rating must be a valid number.',
        'reviews.*.rating.min'      => 'The minimum rating is 1 star.',
        'reviews.*.rating.max'      => 'The maximum rating is 5 stars.',
        'reviews.*.comment.max'     => 'Your review comment may not exceed 1000 characters.',
    ];
    
    protected $validationAttributes = [
        'reviews.*.rating'  => 'rating',
        'reviews.*.comment' => 'review comment',
    ];


    public function mount($orderNumber)
    {
        $this->orderNumber = $orderNumber; // Store the order number
        
        $this->order = Order::with(['orderitems.product'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->where('order_status', 'complete') // Only allow reviews for completed orders
            ->firstOrFail();

        $this->orderItems = $this->order->orderitems;
        
        // Initialize reviews array
        foreach ($this->orderItems as $item) {
            $existingReview = Productreview::where('user_id', Auth::id())
                ->where('order_item_id', $item->id)
                ->first();

            $this->reviews[$item->id] = [
                'rating' => $existingReview ? $existingReview->rating : 0,
                'comment' => $existingReview ? $existingReview->comment : '',
                'existing_id' => $existingReview ? $existingReview->id : null,
                'status'      => $existingReview ? $existingReview->status : 'pending',
                'is_locked'   => (bool) $existingReview,
            ];
        }
    }

    public function submitReviews()
    {
        $this->validate();

        foreach ($this->reviews as $orderItemId => $reviewData) {
            // Reviews are one-time only.
            if (($reviewData['existing_id'] ?? null) || (int) $reviewData['rating'] <= 0) {
                continue;
            }

            $orderItem = OrderItem::where('id', $orderItemId)
                ->where('order_id', $this->order->id)
                ->first();

            if (! $orderItem) {
                continue;
            }

            Productreview::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'order_item_id' => $orderItemId,
                ],
                [
                    'product_id' => $orderItem->product_id,
                    'order_id' => $this->order->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                    'status' => 'pending',
                ]
            );
        }

        session()->flash('success', 'Your review has been submitted successfully.');
        
        // Refresh reviews data using the stored order number
        $this->mount($this->orderNumber);
    }

    public function setRating($orderItemId, $rating)
    {
        $this->reviews[$orderItemId]['rating'] = $rating;
    }

    public function hasAnyReviews()
    {
        foreach ($this->reviews as $review) {
            if (!($review['existing_id'] ?? null) && ($review['rating'] > 0 || !empty($review['comment']))) {
                return true;
            }
        }
        return false;
    }

    public function hasEditableItems()
    {
        foreach ($this->reviews as $review) {
            if (! ($review['existing_id'] ?? null)) {
                return true;
            }
        }

        return false;
    }

    public function render()
    {
        return view('livewire.reviews.review-component');
    }
}
