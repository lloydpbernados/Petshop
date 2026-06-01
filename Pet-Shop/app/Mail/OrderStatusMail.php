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
            'shipped'   => '🚚 Your PawHaven Order Is On Its Way!',
            'completed' => '🎉 Your PawHaven Order Has Been Delivered!',
            'cancelled' => '❌ Your PawHaven Order Has Been Cancelled',

        ];

        return new Envelope(
            subject: $subjects[$this->newStatus] ?? 'Your PawHaven Order Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status',
            // $order and $newStatus are public so they're auto-passed to the view
        );
    }
}