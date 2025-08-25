<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('layouts.userlayout') {{-- Adjust this to your actual layout file --}}

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ route('user.home') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ route('user.product') }}">Category</a>
                    <span>{{ $product->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product__details__pic">
                    <!-- Thumbnails -->
                    <div class="product__details__pic__left product__thumb nice-scroll">
                        @foreach($product->images as $index => $image)
                            <a class="pt {{ $loop->first ? 'active' : '' }}" href="#product-{{ $index }}">
                                <img src="{{ asset('uploads/' . $image) }}" alt="">
                            </a>
                        @endforeach
                    </div>

                    <!-- Main Carousel -->
                    <div class="product__details__slider__content">
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach($product->images as $index => $image)
                                <img data-hash="product-{{ $index }}" class="product__big__img" src="{{ asset('uploads/' . $image) }}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Text -->
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3>{{ $product->name }} <span>Category: {{ $product->category_name }}</span></h3>

                    <div class="rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span>( 138 reviews )</span>
                    </div>

                    <div class="product__details__price">₦ {{ number_format($product->price, 2) }}</div>

                    <p>{!! $product->description !!}</p>

                    <div class="product__details__button">
                          @if(Auth::check())
                          @if( $product->stock < 0)
                            <div
                                class="alert alert-primary alert-dismissible fade show"
                                role="alert"
                            >
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                >X</button>
                                <strong>Out of Stock</strong>
                            </div>
                  
                            <script>
                                var alertList = document.querySelectorAll(".alert");
                                alertList.forEach(function (alert) {
                                    new bootstrap.Alert(alert);
                                });
                            </script>
                            
                                    @else
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" name="quantity" value="1">
                                </div>
                            </div>
                            <button class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</button>
                        </form>

                        <ul>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_adjust-horiz"></span></a></li>
                        </ul>
                        @endif
                        @else
                        <p>Please <a href="{{ route('login') }}">log in</a> to add items to your cart.</p>
                        @endif
                    </div>

                    <div class="product__details__widget">
                        <ul>
                            <li><span>Availability:</span>
                                <div class="stock__checkbox">
                                    <label>
                                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                        <input type="checkbox" {{ $product->stock > 0 ? 'checked' : '' }} disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </li>
                            <li><span>Status:</span> <p>{{ ucfirst($product->status) }}</p></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Description Tab -->
            <div class="col-lg-12 mt-5">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <h6>Description</h6>
                            <p>{!! $product->description !!}</p>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <h6>Specification</h6>
                            <p>No specifications available.</p>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <h6>Reviews</h6>
                            <p>No reviews yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>
<!-- Product Details Section End -->
@endsection

@section('scripts')
<script>
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function () {
    // Quantity increment / decrement
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');

    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        var newVal = 1;

        if ($button.hasClass('inc')) {
            newVal = parseInt(oldValue) + 1;
        } else {
            // prevent below 1
            if (oldValue > 1) {
                newVal = parseInt(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }

        $button.parent().find('input').val(newVal);
    });
});


</script>

@endsection
