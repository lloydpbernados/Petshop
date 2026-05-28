@extends('layouts.app')

@section('title', 'Order Placed — PawHaven')

@section('content')
<div style="background-color:#fcf9f4; min-height:80vh; display:flex;
            align-items:center; justify-content:center; padding:40px 20px;">
    <div style="background:#ffffff; padding:40px; border-radius:20px;
                box-shadow:0 10px 30px rgba(0,0,0,0.04); max-width:500px; width:100%;
                text-align:center; border:1px solid #f3eae1;">

        <span style="font-size:60px;">🎉</span>

        <h2 style="font-family:'Playfair Display',serif; color:#2d2117;
                   font-size:32px; margin-top:16px; margin-bottom:8px;">
            Order Placed!
        </h2>
        <p style="color:#8c7e74; font-size:15px; line-height:1.6;">
            Thank you for shopping at PawHaven.<br>
            Your order has been received and is being processed.
        </p>

        {{-- Order Number Display --}}
        <div style="background-color:#faf8f5; border:1px solid #e6ded6; border-radius:16px;
                    padding:24px; margin:28px 0; text-align:left;">
            <p style="margin:0 0 6px; color:#6e5e53; font-size:14px; font-weight:600;">
                Your Order Number
            </p>
            <p style="margin:0 0 16px; color:#e07a2c; font-weight:800; font-size:26px;
                      letter-spacing:-.02em;">
                #{{ session('order_id') ?? 'N/A' }}
            </p>
            <p style="margin:0; color:#8c7e74; font-size:13px; line-height:1.6;">
                📧 A confirmation has been noted on your account. You can track your order
                anytime using this number and the email address you provided at checkout.
            </p>
        </div>

        {{-- What's next steps --}}
        <div style="text-align:left; margin-bottom:28px;">
            <p style="color:#4a3b32; font-size:14px; font-weight:700; margin-bottom:12px;">What happens next?</p>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <span style="font-size:1.1rem; flex-shrink:0;">📦</span>
                    <span style="color:#6e5e53; font-size:13px; line-height:1.5;">
                        Our team will prepare and verify your order within 1-2 business days.
                    </span>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <span style="font-size:1.1rem; flex-shrink:0;">🚚</span>
                    <span style="color:#6e5e53; font-size:13px; line-height:1.5;">
                        Once shipped, you'll be able to see your tracking status update in the tracker.
                    </span>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px;">
                    <span style="font-size:1.1rem; flex-shrink:0;">🐾</span>
                    <span style="color:#6e5e53; font-size:13px; line-height:1.5;">
                        For pet purchases, our team may reach out to coordinate pickup or delivery details.
                    </span>
                </div>
            </div>
        </div>

        {{-- CTAs --}}
        <div style="display:flex; flex-direction:column; gap:12px;">
            <a href="{{ route('order.track.form') }}"
               style="display:block; background-color:#e07a2c; color:white; text-decoration:none;
                      padding:14px; border-radius:30px; font-weight:bold; font-size:15px;
                      box-shadow:0 4px 12px rgba(224,122,44,0.25);
                      transition:background-color .2s;">
                🔍 Track Your Order
            </a>
            <a href="{{ route('shop') }}"
               style="display:block; color:#4a3b32; text-decoration:none; font-size:14px;
                      font-weight:600; padding:12px;">
                Continue Shopping →
            </a>
            <a href="{{ route('home') }}"
               style="color:#8c7e74; text-decoration:none; font-size:13px;">
                Return to Storefront
            </a>
        </div>

    </div>
</div>
@endsection