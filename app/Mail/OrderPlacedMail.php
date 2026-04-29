<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Carbon\Carbon;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $forAdmin;
    protected $adminMessage;
    public $emailBody;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, bool $forAdmin = false, $emailBody = "You have placed an order.")
    {
        $this->order = $order;
        $this->forAdmin = $forAdmin;
        $this->emailBody = $emailBody;
        //Build admin subject
        if($this->forAdmin){
            $date = Carbon::parse($this->order->created_at)->toDateString();
            /*$serialNo = Order::whereDate('created_at', $date)
                            ->where('order_status', 'confirmed')
                            ->where('payment_status', 'paid')
                            ->count();*/
            $serialNo = $this->order->order_sl_no;
            $formattedDate = Carbon::parse($this->order->created_at)->format('M jS Y');
            $paymentMethod = ucfirst($this->order->payment_method ?? 'Unknown');
            $amount = number_format($this->order->total ?? 0, 2);

            $this->adminMessage = "Sweton Order Success - SL. No. - $serialNo - $formattedDate - $paymentMethod - Rs. $amount";
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->forAdmin ? $this->adminMessage : 'Your Order ' . $this->order->order_number . ' has been placed!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->forAdmin ? 'emails.admin_order_notification' : 'emails.order_placed',
            with: [
                'order' => $this->order,
                'email_body' => $this->emailBody,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
