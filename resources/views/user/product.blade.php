@extends('layouts.userlayout') 
@section('navbar') 
@endsection 
@section('content') 

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{ route('user.home') }}"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar: Categories and Price Filter -->
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <!-- Categories -->
                    <div class="sidebar__categories mb-4">
                        <div class="section-title mb-3">
                            <h4>Categories</h4>
                        </div>

                        <ul class="list-unstyled ps-2">
                            @foreach($categories as $category)
                                <li class="mb-2">
                                    <a href="{{ route('shop.category', $category->id) }}"  class="text-dark text-decoration-none d-block py-1">
                                        {{ $category->category }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Price Filter -->
                    <div class="sidebar__filter">
                        <div class="section-title mb-3">
                            <h4>Shop by price</h4>
                        </div>

                        @php
                            $minPrice = $products->min('price') ?? 0;
                            $maxPrice = $products->max('price') ?? 1000;
                        @endphp

                        <form method="GET" class="price-input d-flex flex-column gap-2">
                            <div class="form-group">
                                <label for="minamount">Min Price:</label>
                                <input type="number" id="minamount" name="min_price" value="{{ $minPrice }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="maxamount">Max Price:</label>
                                <input type="number" id="maxamount" name="max_price" value="{{ $maxPrice }}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-dark mt-2">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Products Grid -->
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    @foreach($products as $product)
                    @php
                        $firstImage = $product->images[1] ?? null;
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset('uploads/' . $firstImage) }}">
                                @if($product->status == 'new')
                                <div class="label new">New</div>
                                @elseif($product->status == 'trending')
                                <div class="label">Trending</div>
                                @elseif($product->status == 'popular')
                                <div class="label">Popular</div>
                                @endif
                                @if($product->stock == 0)
                                <div class="label stockout stockblue">Out Of Stock</div>
                                @endif
                                @if($product->stock < 0)
                                <div class="label stockout danger">Out Of Stock</div>
                                @endif
                                <ul class="product__hover">
                                    <li><a href="{{ asset('uploads/' . $firstImage) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                    <li>
                                        <a href="{{ route('product.details', $product->id) }}">
                                            <span class="icon_info_alt"></span>
                                        </a>
                                    </li>
                                 <li>
    @if(Auth::check() && in_array($product->id, $cartProductIds))
        <button disabled style="border: none; background: transparent;">
            <span class="icon_check text-success"></span> <!-- Optional: checkmark icon -->
        </button>
    @else
            @if(Auth::check())
               @if($product->stock > 0)
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" style="border: none; background: transparent;">
                <span class="icon_bag_alt text-primary"></span>
            </button>
        </form>
        @else
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Out of Stock</strong>
            @endif
        @endif
    @endif
</li>

                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{ $product->name }}</a></h6>
                                <div class="rating">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>
                                <div class="product__price">${{ number_format($product->price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="col-lg-12 text-center">
                        <div class="pagination__option">
                            <a href="#">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Shop Section End -->

@endsection
