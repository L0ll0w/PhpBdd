<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rdv;

    /**
     * Create a new message instance.
     */
    public function __construct($rdv)
    {
        $this->rdv = $rdv;
    }

    public function build()
    {
        return $this->from('test918237465@gmail.com')  // The sender
            ->subject('Confirmation de votre rendez-vous') // The subject
            ->view('emails.rdv_confirmation');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Adress('test918237465@gmail.com', 'Test'), // The sender
            subject: 'Confirmation de votre rendez-vous'); // The subject
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
