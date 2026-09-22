<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StorefrontOrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Нове замовлення з сайту — '.$this->order['customer_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.storefront.order-placed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
