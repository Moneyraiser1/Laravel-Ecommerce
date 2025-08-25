@extends('layouts.userlayout')

@section('content')
@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}" class="checkout__form">
                @csrf
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-8">
                        <h5>Billing detail</h5>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Full name <span>*</span></p>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Phone number <span>*</span></p>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Address <span>*</span></p>
                                    <input type="text" name="address" id="addressInput" placeholder="Street Address" required>
                                </div>
                                <div class="checkout__form__input">
                                    <p>Town/City <span>*</span></p>
                                    <input type="text" name="city" required>
                                </div>
                                <div class="checkout__form__input">
                                    <p>Country <span>*</span></p>
                                    <input type="text" name="country" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    @foreach($cartItems as $item)
                                        <li>
                                            {{ $item->name }} × {{ $item->quantity }}
                                            <span>₦{{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Subtotal <span>₦{{ number_format($total, 2) }}</span></li>
                                    <li>Total <span>₦{{ number_format($total, 2) }}</span></li>
                                </ul>
                            </div>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="total" id="orderTotal" value="{{ $total }}">
                            <input type="hidden" name="reference" id="reference">

                            <!-- Paystack button -->
                            <button type="button" id="payButton" class="site-btn">Pay Now with Paystack</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->
    <p class="text-center mt-4">Take a screenshot of your map and send it to us on whatsapp.</p>

    <!-- Map Section at Bottom -->
    <section class="map-section mt-5">
        <div class="container">
            <h5 class="mb-3">Delivery Address Location</h5>
            <div class="contact__map">
                <iframe id="mapFrame"
                        src="https://www.google.com/maps?q={{ urlencode(Auth::user()->address ?? 'Lagos, Nigeria') }}&output=embed"
                        height="400" style="border:0; width:100%;" allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>
    <!-- WhatsApp Floating Icon -->
<a href="https://wa.me/2347082648913" target="_blank" id="whatsapp-button">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
</a>

<style>
    #whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
    #whatsapp-button img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        transition: transform 0.2s;
    }
    #whatsapp-button img:hover {
        transform: scale(1.1);
    }
</style>

@endsection

@section('scripts')

@endsection
