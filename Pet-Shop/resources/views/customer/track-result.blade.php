@extends('layouts.app')

@section('content')
<div style="background-color: #fcf9f4; min-height: 80vh; padding: 40px 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Back Button -->
        <a href="{{ route('order.track') }}" style="display: inline-flex; align-items: center; color: #4a3b32; text-decoration: none; margin-bottom: 20px; font-weight: 600;">
            <span style="margin-right: 8px;">←</span> Back to Track Order
        </a>

        <!-- Order Status Card -->
        <div style="background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #f3eae1; margin-bottom: 30px;">
            
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 style="font-family: 'Playfair Display', serif; color: #2d2117; font-size: 32px; margin-bottom: 10px;">Order Details</h1>
                <p style="color: #8c7e74; font-size: 14px;">Order ID: <strong style="color: #e07a2c;">{{ $order->order_id }}</strong></p>
            </div>

            <!-- Status Badge -->
            <div style="text-align: center; margin-bottom: 40px;">
                @php
                    $statusColors = [
                        'Pending' => '#f59e0b',
                        'Processing' => '#3b82f6',
                        'Shipped' => '#8b5cf6',
                        'Completed' => '#10b981',
                        'Delivered' => '#10b981',
                        'Cancelled' => '#ef4444'
                    ];
                    $statusColor = $statusColors[$order->status] ?? '#6b7280';
                @endphp
                
                <div style="display: inline-block; padding: 12px 32px; border-radius: 30px; font-size: 18px; font-weight: bold; color: white; background-color: {{ $statusColor }};">
                    {{ $order->status }}
                </div>
            </div>

            <!-- Order Information Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                
                <!-- Customer Info -->
                <div style="background-color: #faf8f5; padding: 24px; border-radius: 12px;">
                    <h3 style="color: #2d2117; font-size: 16px; margin-bottom: 16px; font-weight: 600;">👤 Customer Information</h3>
                    <div style="margin-bottom: 12px;">
                        <span style="color: #8c7e74; font-size: 13px; display: block; margin-bottom: 4px;">Name</span>
                        <span style="color: #2d2117; font-weight: 600;">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span style="color: #8c7e74; font-size: 13px; display: block; margin-bottom: 4px;">Email</span>
                        <span style="color: #2d2117;">{{ $order->email }}</span>
                    </div>
                </div>

                <!-- Order Details -->
                <div style="background-color: #faf8f5; padding: 24px; border-radius: 12px;">
                    <h3 style="color: #2d2117; font-size: 16px; margin-bottom: 16px; font-weight: 600;">📦 Order Details</h3>
                    <div style="margin-bottom: 12px;">
                        <span style="color: #8c7e74; font-size: 13px; display: block; margin-bottom: 4px;">Item</span>
                        <span style="color: #2d2117; font-weight: 600;">{{ $order->item_name }}</span>
                    </div>
                    <div>
                        <span style="color: #8c7e74; font-size: 13px; display: block; margin-bottom: 4px;">Price</span>
                        <span style="color: #e07a2c; font-weight: bold; font-size: 18px;">₱{{ number_format($order->price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address (if exists) -->
            @if(isset($order->shipping_address) && $order->shipping_address)
            <div style="background-color: #faf8f5; padding: 24px; border-radius: 12px; margin-bottom: 30px;">
                <h3 style="color: #2d2117; font-size: 16px; margin-bottom: 12px; font-weight: 600;">📍 Shipping Address</h3>
                <p style="color: #4a3b32; line-height: 1.6;">{{ $order->shipping_address }}</p>
            </div>
            @endif

            <!-- Order Timeline -->
            <div style="margin-top: 40px;">
                <h3 style="color: #2d2117; font-size: 18px; margin-bottom: 24px; font-weight: 600; text-align: center;">Order Timeline</h3>
                
                <div style="position: relative; padding: 20px 0;">
                    <!-- Timeline Line -->
                    <div style="position: absolute; left: 50%; transform: translateX(-50%); top: 0; bottom: 0; width: 2px; background-color: #e6ded6;"></div>

                    <!-- Order Placed -->
                    <div style="position: relative; display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
                        <div style="position: absolute; left: 50%; transform: translateX(-50%); width: 16px; height: 16px; border-radius: 50%; background-color: #10b981; border: 3px solid white; box-shadow: 0 0 0 3px #10b981;"></div>
                        <div style="background-color: #f0fdf4; padding: 12px 24px; border-radius: 8px; margin-left: 40px;">
                            <p style="color: #166534; font-weight: 600; margin: 0;">Order Placed</p>
                            <p style="color: #166534; font-size: 13px; margin: 4px 0 0;">
                                {{ date('M d, Y h:i A', strtotime($order->created_at)) }}
                            </p>
                        </div>
                    </div>

                    <!-- Processing -->
                    <div style="position: relative; display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
                        <div style="position: absolute; left: 50%; transform: translateX(-50%); width: 16px; height: 16px; border-radius: 50%; background-color: {{ in_array($order->status, ['Processing', 'Shipped', 'Completed', 'Delivered']) ? '#3b82f6' : '#e6ded6' }}; border: 3px solid white; box-shadow: 0 0 0 3px {{ in_array($order->status, ['Processing', 'Shipped', 'Completed', 'Delivered']) ? '#3b82f6' : '#e6ded6' }};"></div>
                        <div style="background-color: {{ in_array($order->status, ['Processing', 'Shipped', 'Completed', 'Delivered']) ? '#eff6ff' : '#faf8f5' }}; padding: 12px 24px; border-radius: 8px; margin-right: 40px;">
                            <p style="color: {{ in_array($order->status, ['Processing', 'Shipped', 'Completed', 'Delivered']) ? '#1e40af' : '#8c7e74' }}; font-weight: 600; margin: 0;">Processing</p>
                            <p style="color: {{ in_array($order->status, ['Processing', 'Shipped', 'Completed', 'Delivered']) ? '#1e40af' : '#8c7e74' }}; font-size: 13px; margin: 4px 0 0;">Preparing your order</p>
                        </div>
                    </div>

                    <!-- Shipped -->
                    <div style="position: relative; display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
                        <div style="position: absolute; left: 50%; transform: translateX(-50%); width: 16px; height: 16px; border-radius: 50%; background-color: {{ in_array($order->status, ['Shipped', 'Completed', 'Delivered']) ? '#8b5cf6' : '#e6ded6' }}; border: 3px solid white; box-shadow: 0 0 0 3px {{ in_array($order->status, ['Shipped', 'Completed', 'Delivered']) ? '#8b5cf6' : '#e6ded6' }};"></div>
                        <div style="background-color: {{ in_array($order->status, ['Shipped', 'Completed', 'Delivered']) ? '#f5f3ff' : '#faf8f5' }}; padding: 12px 24px; border-radius: 8px; margin-left: 40px;">
                            <p style="color: {{ in_array($order->status, ['Shipped', 'Completed', 'Delivered']) ? '#6d28d9' : '#8c7e74' }}; font-weight: 600; margin: 0;">Shipped</p>
                            <p style="color: {{ in_array($order->status, ['Shipped', 'Completed', 'Delivered']) ? '#6d28d9' : '#8c7e74' }}; font-size: 13px; margin: 4px 0 0;">On the way</p>
                        </div>
                    </div>

                    <!-- Delivered -->
                    <div style="position: relative; display: flex; justify-content: center; align-items: center;">
                        <div style="position: absolute; left: 50%; transform: translateX(-50%); width: 16px; height: 16px; border-radius: 50%; background-color: {{ in_array($order->status, ['Completed', 'Delivered']) ? '#10b981' : '#e6ded6' }}; border: 3px solid white; box-shadow: 0 0 0 3px {{ in_array($order->status, ['Completed', 'Delivered']) ? '#10b981' : '#e6ded6' }};"></div>
                        <div style="background-color: {{ in_array($order->status, ['Completed', 'Delivered']) ? '#f0fdf4' : '#faf8f5' }}; padding: 12px 24px; border-radius: 8px; margin-right: 40px;">
                            <p style="color: {{ in_array($order->status, ['Completed', 'Delivered']) ? '#166534' : '#8c7e74' }}; font-weight: 600; margin: 0;">Delivered</p>
                            <p style="color: {{ in_array($order->status, ['Completed', 'Delivered']) ? '#166534' : '#8c7e74' }}; font-size: 13px; margin: 4px 0 0;">Order completed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes (if exists) -->
            @if(isset($order->tracking_notes) && $order->tracking_notes)
            <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-top: 30px;">
                <p style="color: #92400e; margin: 0;">
                    <strong>📝 Note:</strong> {{ $order->tracking_notes }}
                </p>
            </div>
            @endif

        </div>

        <!-- Help Section -->
        <div style="text-align: center; padding: 30px; background-color: #ffffff; border-radius: 12px; border: 1px solid #f3eae1;">
            <p style="color: #8c7e74; margin-bottom: 16px;">Need help with your order?</p>
            <a href="mailto:support@petshop.com" style="display: inline-block; background-color: #e07a2c; color: white; padding: 12px 32px; border-radius: 30px; text-decoration: none; font-weight: 600;">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection