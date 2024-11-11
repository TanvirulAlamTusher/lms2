<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Orderconfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public function __construct($data) {
      $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your order has been confirmed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order_mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
