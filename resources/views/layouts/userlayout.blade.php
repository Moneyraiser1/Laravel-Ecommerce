<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mega Ecommerce</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')  }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css')  }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css')  }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css')  }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css')  }}" type="text/css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
     
  <link rel="shortcut icon" href="{{ asset('images/favico.png') }}" type="image/x-icon">
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</head>
@if (session('success'))
    <script>
        alertify.success("{{ session('success') }}");
    </script>
@endif

@if (session('error'))
    <script>
        alertify.error("{{ session('error') }}");
    </script>
@endif
    @yield('style')
</head>

<body>
    <!-- Header / Navbar -->
    @yield('navbar')
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_heart_alt"></span>
            </a></li>
            <li>
    <a href="{{ route('cart.index') }}">
        <span class="icon_bag_alt"></span>
        <div class="tip">{{ $cartCount }}</div>
    </a>
</li>
</li>
        </ul>
        <div class="offcanvas__logo">
            <a href="{{ route('user.home') }}"><img src="{{ asset('images/favico.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
              </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{ route('user.home')}}"><img src="{{ asset('images/favico.png') }}" style="width: 200px; height: 100px;" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{ route('user.home') }}">Home</a></li>
                            <li><a href="{{ route('user.product') }}">Shop</a></li>
                             @if(Auth::check())
                            <li><a href="{{ route('cart.index')}}">Cart</a></li>
                            <li><a href="{{ route('user.profile') }}">
                                {{ Auth::user()->name }}</a>
                            </li>
      <li>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger p-2">Logout</button>
        </form>
    </li>
      @else
      <li>
        <a href="{{ route('login') }}">Login</a>  
      </li>
      <li>
        <a href="{{ route('register') }}">Register</a> 
      </li>
      @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            Naira 
                        </div>
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_bag_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    @yield('navbar')
    <!-- Header Section End -->
    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @yield('footer')

<!-- Instagram End -->

<!-- Footer Section Begin -->
<footer class="footer bg-dark text-light">
    <div class="container ">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7  ">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                    <p class="text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                    cilisis.</p>
                    <div class="footer__payment">
                        <a href="#"><img src="{{ asset('img/payment/payment-1.png') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('img/payment/payment-2.png') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('img/payment/payment-3.png') }}" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    <h6 class="text-light">Quick links</h6>
                    <ul>
                        <li class="text-light"><a href="#">Home</a></li>
                        <li class="text-light"><a href="#">Shop</a></li>
                        <li class="text-light"><a href="#">Cart</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    <h6 class="text-light">Account</h6>
                    <ul>
                        <li class="text-light"><a href="#">My Account</a></li>
                        <li class="text-light"><a href="#">Checkout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6 class="text-light">NEWSLETTER</h6>
                    <form action="#">
                        <input type="text" placeholder="Email">
                        <button type="submit" class="site-btn ">Shop</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->
    <!-- JS Dependencies -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
 @if(Auth::check())
<script>
   document.getElementById('payButton').addEventListener('click', function () {
    let handler = PaystackPop.setup({
        key: "{{ env('PAYSTACK_PUBLIC_KEY') }}",
        email: "{{ Auth::user()->email }}",
        amount: document.getElementById('orderTotal').value * 100,
        currency: "NGN",
        ref: ''+Math.floor((Math.random() * 1000000000) + 1),
        callback: function(response){
            document.getElementById('reference').value = response.reference;
            document.getElementById('checkoutForm').submit();
        },
        onClose: function(){
            alert('Transaction was not completed.');
        }
    });
    handler.openIframe();
});


    // ✅ Live update Google Map when address is typed
    const addressInput = document.getElementById('addressInput');
    const mapFrame = document.getElementById('mapFrame');

    addressInput.addEventListener('keyup', function() {
        let addr = encodeURIComponent(this.value.trim());

        if (addr.length > 2) { // only update when something meaningful is typed
            mapFrame.src = "https://www.google.com/maps?q=" + addr + "&output=embed";
        } else {
            // fallback to Lagos if input is empty
            mapFrame.src = "https://www.google.com/maps?q=Lagos,Nigeria&output=embed";
        }
    });
</script>
@endif
    @yield('script')
</body>
</html>

