<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\MailcoachMailer\Concerns\UsesMailcoachMail;

class CoashMailEmail extends Mailable
{
    use Queueable, 
     SerializesModels, 
     UsesMailcoachMail;
    /**
     * Create a new message instance.
     */
    public function __construct(
     ) {}

    public function build()
    {
        $this
         ->from('med@mailcoach.cloud', 'Med')
            ->mailcoachMail('transaction-mail', [
                'productName' =>"Oil Skin",
                'shippingDate' => "22/11/2024"
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Coash Mail Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
