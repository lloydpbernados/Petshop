{{-- resources/views/emails/otp.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your PawHaven OTP</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #FDF8F1;
            padding: 40px 20px;
            color: #2D241E;
        }
        .wrapper {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #F3E9DC;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(45,36,30,0.08);
        }
        .header {
            background: linear-gradient(135deg, #FDF2E9, #FFF8F0);
            padding: 36px 40px 28px;
            text-align: center;
            border-bottom: 1px solid #F3E9DC;
        }
        .brand {
            font-size: 22px;
            font-weight: 800;
            color: #2D241E;
            letter-spacing: -0.02em;
        }
        .brand-sub {
            font-size: 12px;
            color: #A68B6D;
            margin-top: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .body {
            padding: 36px 40px;
        }
        .greeting {
            font-size: 15px;
            color: #5C4D3C;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .otp-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #A68B6D;
            text-align: center;
            margin-bottom: 12px;
        }
        .otp-box {
            background: #FDF2E9;
            border: 2px dashed #E68A39;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-bottom: 24px;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 800;
            color: #E68A39;
            letter-spacing: 0.3em;
            line-height: 1;
        }
        .otp-expiry {
            font-size: 12px;
            color: #A68B6D;
            margin-top: 10px;
            font-weight: 600;
        }
        .notice {
            background: #FFF8E1;
            border-left: 4px solid #F59E0B;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 13px;
            color: #78350F;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .footer {
            background: #FDF8F1;
            padding: 20px 40px;
            border-top: 1px solid #F3E9DC;
            text-align: center;
        }
        .footer p {
            font-size: 12px;
            color: #A68B6D;
            line-height: 1.7;
        }
        .footer strong { color: #5C4D3C; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="header">
            <div class="brand">🐾 PawHaven</div>
            <div class="brand-sub">Your trusted pet shop since 2014</div>
        </div>

        <div class="body">
            <p class="greeting">
                Hi <strong>{{ $customerName }}</strong>,<br><br>
                You're almost done! Use the one-time password below to confirm your order.
                Please do not share this code with anyone.
            </p>

            <div class="otp-label">Your One-Time Password</div>

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">⏱ Expires in <strong>10 minutes</strong></div>
            </div>

            <div class="notice">
                ⚠️ <strong>Didn't request this?</strong> If you didn't place an order on PawHaven,
                you can safely ignore this email. Your account is not at risk.
            </div>
        </div>

        <div class="footer">
            <p>
                © {{ date('Y') }} <strong>PawHaven</strong>. All rights reserved.<br>
                Questions? Email us at <strong>support@pawhaven.ph</strong>
            </p>
        </div>

    </div>
</body>
</html>