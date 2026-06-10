@extends('layouts.app')
@section('title', 'Track Your Order — PawHaven')
@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }
.track-wrap {
    background-color: #fcf9f4; min-height: 80vh;
    display: flex; align-items: center; justify-content: center;
    padding: 24px 16px;
}
.track-card {
    background: #ffffff; padding: 24px 20px; border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04); width: 100%; max-width: 450px;
    border: 1px solid #f3eae1;
}
@media (min-width: 480px) { .track-card { padding: 36px 32px; } }
@media (min-width: 640px) { .track-card { padding: 40px; } }
.track-icon { font-size: 2rem; text-align: center; margin-bottom: 0.6rem; display: block; }
@media (min-width: 480px) { .track-icon { font-size: 2.5rem; } }
.track-title { font-family: 'Playfair Display', serif; color: #2d2117; font-size: 22px; font-weight: bold; text-align: center; margin: 0 0 8px; }
@media (min-width: 480px) { .track-title { font-size: 26px; } }
@media (min-width: 640px) { .track-title { font-size: 28px; } }
.track-sub { color: #8c7e74; font-size: 13px; line-height: 1.6; text-align: center; margin-bottom: 24px; }
.track-error { background-color: #fdf2f2; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 11px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 18px; }
.track-label { display: block; color: #4a3b32; font-weight: 600; font-size: 13px; margin-bottom: 7px; }
.track-input {
    width: 100%; padding: 11px 14px; border: 1px solid #e6ded6;
    border-radius: 12px; background-color: #faf8f5; color: #2d2117;
    font-size: 15px; outline: none; transition: border-color .2s;
}
.track-input:focus { border-color: #e07a2c; }
.track-field { margin-bottom: 18px; }
@media (min-width: 480px) { .track-field { margin-bottom: 22px; } }
.track-btn {
    width: 100%; background-color: #e07a2c; color: white; border: none;
    padding: 13px; border-radius: 30px; font-size: 15px; font-weight: bold;
    cursor: pointer; box-shadow: 0 4px 12px rgba(224,122,44,0.2);
    transition: background-color .2s; margin-top: 8px;
}
@media (min-width: 480px) { .track-btn { font-size: 16px; padding: 14px; } }
.track-btn:hover { background-color: #cf7029; }
.track-back { text-align: center; margin-top: 22px; }
.track-back a { color: #8c7e74; text-decoration: none; font-size: 13px; font-weight: 500; }
</style>

<div class="track-wrap">
    <div class="track-card">
        <div style="text-align:center; margin-bottom: 24px;">
            <span class="track-icon">🐾</span>
            <h2 class="track-title">Track Your Order</h2>
            <p class="track-sub">Enter your Order ID and the email address you used at checkout to check your order status.</p>
        </div>

        @if(session('error'))
        <div class="track-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('order.track.search') }}" method="POST">
            @csrf
            <div class="track-field">
                <label for="order_id" class="track-label">Order ID</label>
                <input type="text" name="order_id" id="order_id"
                       placeholder="e.g., PH-ABC12345" required
                       value="{{ old('order_id') }}" class="track-input">
                @error('order_id')
                    <span style="color:#e53e3e; font-size:12px; display:block; margin-top:4px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="track-field" style="margin-bottom: 24px;">
                <label for="email" class="track-label">Email Address</label>
                <input type="email" name="email" id="email"
                       placeholder="yourname@email.com" required
                       value="{{ old('email') }}" class="track-input">
                @error('email')
                    <span style="color:#e53e3e; font-size:12px; display:block; margin-top:4px;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="track-btn">🔍 Track Order</button>
        </form>

        <div class="track-back">
            <a href="{{ route('home') }}">← Return to Storefront</a>
        </div>
    </div>
</div>
@endsection