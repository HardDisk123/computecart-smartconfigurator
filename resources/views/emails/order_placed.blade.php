<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - ComputeCart</title>
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Roboto, sans-serif;
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            overflow: hidden;
            border-left: 2px solid #000; /* ✅ only left line */
            border-right: 2px solid #000; /* ✅ only right line */
        }
        .header {
            background: linear-gradient(135deg, #000, #333);
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .body {
            padding: 2rem;
            color: #333;
            line-height: 1.7;
        }
        h2 {
            margin-top: 0;
            color: #111;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #000; /* ✅ black lines */
            text-align: left;
        }
        th {
            font-weight: bold;
            color: #111;
        }
        .total {
            text-align: right;
            font-size: 1.1rem;
            margin-top: 1rem;
            font-weight: bold;
            color: #111;
        }
        /* ✅ Unified button style */
        .glow-btn {
            display: inline-block;
            background-color: #000;
            color: #fff !important;
            padding: 1rem 2rem;
            border-radius: 6px;
            text-decoration: none !important;
            font-weight: bold;
            font-size: 1rem;
            transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 0 14px rgba(255,255,255,0.9);
            transform: scale(1.07);
            background-color: #333;
            color: #fff !important;
        }
        .footer {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">ComputeCart</div>
        <div class="body">
            <h2>Order Confirmation 🎉</h2>
            <p>Hi {{ $order->user->name }},</p>
            <p>Thank you for shopping at <strong>ComputeCart</strong>!</p>
            <p>Your order ID is <strong>#{{ $order->id }}</strong>.</p>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->product->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total: ₱{{ number_format($order->total, 2) }}
            </div>

            <p style="text-align:center; margin: 2rem 0;">
                <a href="{{ route('orders.show', $order) }}" class="glow-btn">Track Your Order</a>
            </p>

            <p>We’ll notify you once your order ships.</p>

            <!-- ✅ Closing line with thank you -->
            <p style="margin-top:2rem;">Thank you for your order,<br><strong>ComputeCart Team</strong></p>
        </div>
        <div class="footer">
            © {{ date('Y') }} ComputeCart. All rights reserved.
        </div>
    </div>
</body>
</html>
