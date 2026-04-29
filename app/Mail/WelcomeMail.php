<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $forAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, bool $forAdmin = false)
    {
        $this->user = $user;
        $this->forAdmin = $forAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->forAdmin ? 'New User Registered' : 'Welcome to Our Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->forAdmin ? 'emails.admin_new_user' : 'emails.user_welcome',
            with: [
                'user' => $this->user,
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
