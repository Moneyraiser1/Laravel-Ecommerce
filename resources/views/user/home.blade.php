@extends('layouts.userlayout') 
@section('navbar') 
@endsection 
@section('content') 
<!-- Categories Section Begin --> 
<section class="categories"> 
    <div class="container-fluid"> 
        <div class="row"> 
            <div class="col-lg-6 p-0"> 
                <div class="categories__item categories__large__item set-bg" data-setbg="{{ asset('img/categories/category-1.jpg') }}"> 
                    <div class="categories__text"> 
                        <h1>Women’s fashion</h1> 
                        Retro-inspired wide-leg design.&nbsp;Made with soft, stretchable denim.</em></p> 
                        <a href="{{ route('user.product') }}">Shop now</a> 
                    </div> 
                </div> 
            </div> 
            <div class="col-lg-6"> 
                <div class="row"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0"> 
                        <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/category-2.jpg') }}"> 
                            <div class="categories__text"> 
                                <h4>Men’s fashion</h4> 
                                <a href="{{ route('user.product') }}">Shop now</a> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0"> 
                        <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/category-3.jpg') }}"> 
                            <div class="categories__text"> 
                                <h4>Girls fashion</h4> 
                                <a href="{{ route('user.product') }}">Shop now</a> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0"> 
                        <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/category-4.jpg') }}"> 
                            <div class="categories__text"> 
                                <h4>Jeans</h4> 
                                <a href="{{ route('user.product') }}">Shop now</a> 
                            </div> 
                        </div> 
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0"> 
                        <div class="categories__item set-bg" data-setbg="{{ asset('img/categories/category-5.jpg') }}"> 
                            <div class="categories__text"> 
                                <h4>Shorts</h4> 
                                <a href="{{ route('user.product') }}">Shop now</a> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</section> 
<!-- Categories Section End --> 

<!-- Product Section Begin --> 
<section class="product spad"> 
    <div class="container"> 
        <div class="row"> 
            <div class="col-lg-4 col-md-4"> 
                <div class="section-title"> 
                    <h4>All products</h4> 
                </div> 
            </div> 
            <div class="col-lg-8 col-md-8"> 
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    @foreach($labels as $label)
                        <li data-filter=".{{ $label }}">{{ ucfirst($label) }}</li>
                    @endforeach
                </ul>

            </div> 
        </div> 
 <div class="row property__gallery">
    @foreach($products as $product)
    @php

    $firstImage = $product->images[1] ?? null; // get first image from array

       // get first image or null if empty
    @endphp
    <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $product->status ?? '' }}">
        <div class="product__item {{ $product->status ?? '' }}">
            <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/' . $firstImage) }}">
                @if($product->status)
                    <div class="label {{ $product->status }}">{{ ucfirst($product->status) }}</div>
                @endif
                <ul class="product__hover">
                    <li><a href="{{ asset('uploads/' . $firstImage) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                       <a href="{{ route('product.details', $product->id) }}">
                                            <span class="icon_info_alt"></span>
                                        </a>
                     <li>
                            
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
                <button type="submit" style="border: none; background: transparent;">
                    <span class="icon_bag_alt text-primary"></span>
                </button>
            </form>
            @endif
            @endif
    </li>
                </ul>
            </div>
            <div class="product__item__text">
                <h6><a href="#">{{ $product->name }}</a></h6>
                <div class="rating">
                    @for($i=0; $i < 5; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                </div>
                <div class="product__price">
                    ${{ $product->price }}
                    @if($product->old_price)
                        <span>${{ $product->old_price }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

    </div> 
</section> 
<!-- Product Section End --> 

<!-- Banner Section Begin --> 
<section class="banner set-bg" data-setbg="{{ asset('img/banner/banner-1.jpg') }}"> 
    <div class="container"> 
        <div class="row"> 
            <div class="col-xl-7 col-lg-8 m-auto"> 
                <div class="banner__slider owl-carousel"> 
                    <div class="banner__item"> 
                        <div class="banner__text"> 
                            <span>The Chloe Collection</span> 
                            <h1>The Project Jacket</h1> 
                            <a href="{{ route('user.product') }}">Shop now</a> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</section> 
<!-- Banner Section End --> 
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter__controls li');
    const products = document.querySelectorAll('.property__gallery .mix');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter'); // e.g., ".new" or "*"

            // Hide all products first
            products.forEach(p => p.style.display = 'none');

            if (filter === '*') {
                // Show max 10 products for "All"
                let count = 0;
                products.forEach(p => {
                    if (count < 10) {
                        p.style.display = 'block';
                        count++;
                    }
                });
            } else {
                // Show max 5 products for this label/status
                let count = 0;
                const statusClass = filter.replace('.', '');
                products.forEach(p => {
                    if (p.classList.contains(statusClass) && count < 5) {
                        p.style.display = 'block';
                        count++;
                    }
                });
            }

            // Optional: update active class on buttons
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Trigger initial filter (All)
    document.querySelector('.filter__controls li.active').click();
});

</script>