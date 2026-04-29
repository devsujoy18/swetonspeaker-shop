<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Productreview;

class ReviewDetailComponent extends Component
{
    public $reviewId;
    public $review;
    public $adminNote = '';
    public $newStatus = '';

    public function mount($reviewId)
    {
        $this->reviewId = $reviewId;
        $this->loadReview();
    }

    public function loadReview()
    {
        $this->review = Productreview::with([
            'user:id,name,email',
            'product:id,name,slug',
            'product.primaryImage',
            'order:id,order_number,order_date,total',
            'order.orderitems',
            'orderItem:id,product_id,quantity,price'
        ])->findOrFail($this->reviewId);

        $this->adminNote = $this->review->admin_note ?? '';
        $this->newStatus = $this->review->status;
    }

    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:pending,approved,rejected',
            'adminNote' => 'nullable|string|max:1000'
        ]);

        $this->review->update([
            'status' => $this->newStatus,
            'admin_note' => $this->adminNote
        ]);

        session()->flash('success', 'Review status updated successfully!');
        $this->loadReview();
    }

    public function deleteReview()
    {
        $this->review->delete();
        session()->flash('success', 'Review deleted successfully!');
        return redirect()->route('admin.reviews.index');
    }

    public function render()
    {
        return view('livewire.admin.review-detail-component')
            ->layout('layouts.app');
    }
}
