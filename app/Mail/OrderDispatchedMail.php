<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderDispatchedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $messageBody;
    public $subjectLine;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $customerName = $order->billing_name;
        $orderId = $order->order_number;

        if ($order->awb_partner === 'Delhivery') {

            $this->subjectLine = 'Sweton Speakers - Order Dispatch & AWB number Details';

            $this->messageBody = "
                Dear {$customerName}, <br><br>
                Your order id <b>{$orderId}</b> has been dispatched through <b>Delhivery Courier</b>.
                AWB number is <b>{$order->awb_number}</b>.
                You can track your order at <a href='https://www.delhivery.com'>www.delhivery.com</a>.
                <br><br>
                Best Regards,<br>
                Team Sweton Speakers
            ";

        } elseif ($order->awb_partner === 'Bluedart') {

            $this->subjectLine = 'Sweton Speakers - Order Dispatch & Waybill number Details';

            $this->messageBody = "
                Dear {$customerName}, <br><br>
                Your order id <b>{$orderId}</b> has been dispatched through <b>Blue Dart Courier</b>.
                Waybill number is <b>{$order->awb_number}</b>.
                You can track your order at 
                <a href='https://www.bluedart.com/tracking'>https://www.bluedart.com/tracking</a>.
                <br><br>
                Best Regards,<br>
                Team Sweton Speakers
            ";
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_dispatched_email',
            with: [
                'order' => $this->order,
                'body' => $this->messageBody
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
