<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $newStatus
    ) {}

    public function envelope(): Envelope
    {
        $subjects = [
            'to-ship'   => '✅ Your PawHaven Order Has Been Approved!',
            'completed' => '📦 Your PawHaven Order Has Been Shipped!',
        ];

        return new Envelope(
            subject: $subjects[$this->newStatus] ?? 'Your PawHaven Order Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status',
        );
    }
}