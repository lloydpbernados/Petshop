@extends('layouts.app')

@section('content')
<div style="background-color: #fcf9f4; min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); max-width: 500px; width: 100%; text-align: center; border: 1px solid #f3eae1;">
        
        <span style="font-size: 50px;">🎉</span>
        <h2 style="font-family: 'Fraunces', serif; color: #2d2117; font-size: 28px; margin-top: 10px;">Order Placed!</h2>
        <p style="color: #8c7e74; font-size: 15px;">Your order has been recorded at PawHaven.</p>
        
        <div style="background-color: #faf8f5; border: 1px solid #e6ded6; border-radius: 12px; padding: 20px; margin: 30px 0; text-align: left;">
            <p style="margin: 0 0 8px 0; color: #6e5e53; font-size: 14px;">
                <strong>Order Number:</strong> 
                <span style="color: #e07a2c; font-weight: bold; font-size: 18px;">#{{ session('order_id') ?? 'N/A' }}</span>
            </p>
            <p style="margin: 0; color: #8c7e74; font-size: 13px; line-height: 1.5;">
                Please take note of this number. You can search it along with your email address in our tracker to check your fulfillment status anytime!
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="{{ route('order.track.form') }}" style="background-color: #e07a2c; color: white; text-decoration: none; padding: 14px; border-radius: 30px; font-weight: bold; box-shadow: 0 4px 12px rgba(224, 122, 44, 0.2);">
                Track Your Package
            </a>
            <a href="{{ route('home') }}" style="color: #8c7e74; text-decoration: none; font-size: 14px; font-weight: 500;">
                Return to Storefront
            </a>
        </div>
    </div>
</div>
@endsection