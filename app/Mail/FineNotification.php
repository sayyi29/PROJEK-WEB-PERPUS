<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Fine;

class FineNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fine;

    public function __construct(Fine $fine)
    {
        $this->fine = $fine;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Denda Keterlambatan - LUMINA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.fine_notification',
        );
    }
}
