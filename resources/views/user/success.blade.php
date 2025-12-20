@extends('layouts.userlayout')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #74ebd5 0%, #9face6 100%);
    }
    .success-wrapper {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    /* Floating confetti */
    .confetti-piece {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #fff;
        opacity: 0.8;
        animation: fall 5s linear infinite;
    }
    .confetti-piece:nth-child(odd) { background: #ff7675; }
    .confetti-piece:nth-child(even) { background: #55efc4; }
    @keyframes fall {
        0% { transform: translateY(-100vh) rotate(0deg);}
        100% { transform: translateY(100vh) rotate(720deg);}
    }

    .success-card {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        position: relative;
        z-index: 2;
        animation: fadeUp 0.9s ease;
    }
    @keyframes fadeUp {
        0% { transform: translateY(50px); opacity: 0;}
        100% { transform: translateY(0); opacity: 1;}
    }

    .success-icon {
        font-size: 4rem;
        color: #2ecc71;
        margin-bottom: 1rem;
        animation: pop 0.8s cubic-bezier(.68,-0.55,.27,1.55);
    }
    @keyframes pop {
        0% { transform: scale(0.5);}
        70% { transform: scale(1.2);}
        100% { transform: scale(1);}
    }

    .success-title {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        color: #2d3436;
    }
    .success-sub {
        color: #636e72;
        margin-bottom: 1.5rem;
    }

    .order-summary {
        background: #f1f8ff;
        border-radius: 12px;
        padding: 1.2rem;
        text-align: left;
        margin-bottom: 1.5rem;
    }
    .order-summary div {
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .order-summary div strong {
        color: #2d3436;
    }

    .items-list {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
        border-top: 1px dashed #dfe6e9;
        border-bottom: 1px dashed #dfe6e9;
        padding: 1rem 0;
    }
    .items-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 1rem;
        color: #2d3436;
    }

    .btn-shop {
        display: inline-block;
        margin-top: 2rem;
        background: linear-gradient(135deg, #00b894, #00997a);
        color: #fff;
        border: none;
        padding: 0.9rem 2rem;
        border-radius: 10px;
        font-size: 1.1rem;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 6px 20px rgba(0,184,148,0.4);
    }
    .btn-shop:hover {
        background: linear-gradient(135deg, #00997a, #00b894);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,184,148,0.6);
    }
</style>

<div class="success-wrapper">
    <!-- Floating confetti pieces -->
    @for($i = 0; $i < 25; $i++)
        <div class="confetti-piece" style="left: {{ rand(0,100) }}%; animation-delay: {{ rand(0,5) }}s;"></div>
    @endfor

    <div class="success-card">
        <div class="success-icon">🎉</div>
        <h2 class="success-title">Order Successful!</h2>
        <p class="success-sub">Thanks for shopping with us. Your order has been confirmed.</p>

        <div class="order-summary">
            <div><strong>Reference:</strong> {{ $order->reference }}</div>
            <div><strong>Total Paid:</strong> ₦{{ number_format($order->total, 2) }}</div>
        </div>

        <h4 style="margin-bottom:1rem; font-weight:600;">Your Items</h4>
        <ul class="items-list">
            @foreach($order->items as $item)
                <li>
                    <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                    <span>₦{{ number_format($item->price * $item->quantity, 2) }}</span>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('user.home') }}" class="btn-shop">Continue Shopping</a>
    </div>
</div>
@endsection
