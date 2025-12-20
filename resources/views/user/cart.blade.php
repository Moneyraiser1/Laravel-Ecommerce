@extends('layouts.userlayout')

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ route('user.home') }}"><i class="fa fa-home"></i> Home</a>
                    <span>Shopping cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body">
                            @php $subtotal = 0; @endphp
                            @foreach ($cartItems as $item)
                                @php $lineTotal = $item->price * $item->quantity; $subtotal += $lineTotal; @endphp
                                <tr data-id="{{ $item->id }}">
                                    <td class="cart__product__item">
                                        <img src="{{ asset('uploads/' . $item->product_image) }}" 
                                             alt="{{ $item->product_name }}" width="100">
                                        <div class="cart__product__item__title">
                                            <h6>{{ $item->product_name }}</h6>
                                        </div>
                                    </td>
                                    <td class="cart__price" data-price="{{ $item->price }}">
                                        ₦{{ number_format($item->price, 2) }}
                                    </td>
                                  <td class="cart__quantity">
    <form action="{{ route('cart.update', $item->id) }}" method="POST" 
          class="update-form d-flex align-items-center gap-2" style="margin:0;">
        @csrf
        <div class="pro-qty" style="flex:0 0 auto; width:80px;">
            <input type="number" name="quantity" class="quantity-input form-control form-control-sm"
                value="{{ $item->quantity }}" min="1" style="width:100%; text-align:center;">
        </div>
        <button type="submit" class="btn btn-outline-primary btn-sm">
            Update
        </button>
    </form>
</td>


                                    <td class="cart__total">₦
                                        <span class="line-total">{{ number_format($lineTotal, 2) }}</span>
                                    </td>
                                    <td class="cart__close">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="border: none; background: none;">
                                                <span class="icon_close"></span>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cart Total Section -->
        <div class="row mt-4">
            <div class="col-lg-4 offset-lg-8">
                <div class="cart__total__procced">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Subtotal <span id="subtotal">₦{{ number_format($subtotal, 2) }}</span></li>
                        <li>Total <span id="total">₦{{ number_format($subtotal, 2) }}</span></li>
                    </ul>
                    <a href="{{ route('checkout.index') }}" class="primary-btn">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    // Intercept per-row update form to do AJAX (no page reload)
    $(document).on('submit', '.update-form', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $row = $form.closest('tr');
        const quantity = parseInt($form.find('.quantity-input').val(), 10);

        if (isNaN(quantity) || quantity < 1) return;

        $.ajax({
            url: $form.attr('action'),
            method: "POST",
            data: $form.serialize(), // includes _token & quantity
            success: function (res) {
                // Update row total
                $row.find('.line-total').text(res.itemTotal);

                // Update subtotal + total
                $('#subtotal').text("₦" + res.subtotal);
                $('#total').text("₦" + res.subtotal);
            },
            error: function (xhr) {
                console.error("Update failed", xhr.responseText);
                // Fallback: if anything fails, submit normally
                $form.off('submit').submit();
            }
        });
    });
});
</script>

@endpush

@endsection
