<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Productreview;
use Livewire\WithPagination;

class ReviewManagementComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; // all, pending, approved, rejected
    public $ratingFilter = 'all'; // all, 5, 4, 3, 2, 1
    public $showNotification = false;
    public $notificationMessage = '';

    protected $listeners = ['reviewUpdated' => '$refresh'];

    public function approveReview($reviewId)
    {
        $review = Productreview::findOrFail($reviewId);
        $review->update([
            'status' => 'approved',
            'admin_note' => null
        ]);

        $this->showNotification('Review approved successfully!');
    }

    public function showNotification($message)
    {
        $this->notificationMessage = $message;
        $this->showNotification = true;
    }

    public function pendingReview($reviewId)
    {
        $review = Productreview::findOrFail($reviewId);
        $review->update([
            'status' => 'pending',
            'admin_note' => null
        ]);

        $this->showNotification('Review status reset to pending!');
    }

    public function deleteReview($reviewId)
    {
        $review = Productreview::findOrFail($reviewId);
        $review->delete();

        $this->showNotification('Review deleted successfully!');
    }



    public function getReviewsProperty()
    {
        // Optimized query with selective eager loading for better performance
        $query = Productreview::query()
            ->select('product_reviews.*') // Explicit select for better performance
            ->with([
                'user:id,name,email', // Only load necessary columns
                'product:id,name,slug',
                'order:id,order_number,order_date'
            ])
            ->latest('product_reviews.created_at');

        // Search filter with optimized queries
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('product', function($subQ) use ($searchTerm) {
                    $subQ->where('name', 'like', $searchTerm);
                })
                ->orWhereHas('user', function($subQ) use ($searchTerm) {
                    $subQ->where('name', 'like', $searchTerm)
                         ->orWhere('email', 'like', $searchTerm);
                })
                ->orWhereHas('order', function($subQ) use ($searchTerm) {
                    $subQ->where('order_number', 'like', $searchTerm);
                })
                ->orWhere('comment', 'like', $searchTerm);
            });
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Rating filter
        if ($this->ratingFilter !== 'all') {
            $query->where('rating', $this->ratingFilter);
        }

        return $query->paginate(15); // Increased to 15 for better UX
    }

    public function getStatsProperty()
    {
        return [
            'total' => Productreview::count(),
            'pending' => Productreview::pending()->count(),
            'approved' => Productreview::approved()->count(),
            'rejected' => Productreview::rejected()->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.review-management-component', [
            'reviews' => $this->reviews,
            'stats' => $this->stats
        ]);
    }
}