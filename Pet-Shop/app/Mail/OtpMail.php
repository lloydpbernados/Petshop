<?php

// ──────────────────────────────────────────────────────────────────────────
// app/Mail/OtpMail.php
// ──────────────────────────────────────────────────────────────────────────

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $customerName;

    public function __construct(string $otp, string $customerName = 'Customer')
    {
        $this->otp          = $otp;
        $this->customerName = $customerName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🐾 Your PawHaven Order OTP — ' . $this->otp,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
        );
    }
}