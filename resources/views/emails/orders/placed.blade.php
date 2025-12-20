@component('mail::message')
# Order Confirmation

Hi {{ $order->user->name }},

Your order **{{ $order->reference }}** has been placed successfully ✅

**Order Summary:**
@foreach($order->items as $item)
- {{ $item->product->name }} (x{{ $item->quantity }}) - ₦{{ number_format($item->price * $item->quantity, 2) }}
@endforeach

**Total:** ₦{{ number_format($order->total, 2) }}

@component('mail::button', ['url' => route('checkout.success', $order->reference)])
View My Order
@endcomponent

Thanks for shopping with us!  
{{ config('app.name') }}
@endcomponent
