<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmployeeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $employeeId;
    public $employeeName;

    /**
     * Create a new message instance.
     */
    public function __construct($employeeId, $employeeName)
    {
        $this->employeeId = $employeeId;
        $this->employeeName = $employeeName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("test@test.com"),
            replyTo: [
                new Address('test@test.com', 'Employee'),
            ],
            subject: 'Welcome Employee Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'employeeName' => $this->employeeName,
                'employeeId' => $this->employeeId,
            ],
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
