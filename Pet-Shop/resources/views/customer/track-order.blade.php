@extends('layouts.app')

@section('content')
<div style="background-color: #fcf9f4; min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); max-width: 450px; width: 100%; border: 1px solid #f3eae1;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="font-family: 'Playfair Display', serif; color: #2d2117; font-size: 28px; margin-bottom: 10px; font-weight: bold;">Track Your Order</h2>
            <p style="color: #8c7e74; font-size: 14px;">Enter your details below to check the status of your furry companion or pet supplies.</p>
        </div>

        @if(session('error'))
            <div style="background-color: #fdf2f2; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 12px; border-radius: 10px; font-size: 14px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('order.track.search') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label for="order_id" style="display: block; color: #4a3b32; font-weight: 600; font-size: 14px; margin-bottom: 8px;">Order ID</label>
                <input type="text" name="order_id" id="order_id" placeholder="e.g., 10234" required value="{{ old('order_id') }}"
                       style="width: 100%; padding: 12px 16px; border: 1px solid #e6ded6; border-radius: 12px; background-color: #faf8f5; color: #2d2117; font-size: 15px; outline: none; transition: border-color 0.2s;">
                @error('order_id') <span style="color: #e53e3e; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 30px;">
                <label for="email" style="display: block; color: #4a3b32; font-weight: 600; font-size: 14px; margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" id="email" placeholder="yourname@email.com" required value="{{ old('email') }}"
                       style="width: 100%; padding: 12px 16px; border: 1px solid #e6ded6; border-radius: 12px; background-color: #faf8f5; color: #2d2117; font-size: 15px; outline: none; transition: border-color 0.2s;">
                @error('email') <span style="color: #e53e3e; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" style="width: 100%; background-color: #e07a2c; color: white; border: none; padding: 14px; border-radius: 30px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.2s; box-shadow: 0 4px 12px rgba(224, 122, 44, 0.2);">
                Track Order
            </button>
        </form>
    </div>
</div>
@endsection