<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ecomm Admin</title>

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('css/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('css/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
  
  <!-- Plugins CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link href="{{ asset('js/select2/select2.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('js/select2-bootstrap-theme/select2-bootstrap.min.css') }}" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
  
  <link rel="shortcut icon" href="{{ asset('images/favico.png') }}" type="image/x-icon">

  @yield('style')
</head>
<body class="{{ isset($setting->data['dark_mode']) && $setting->data['dark_mode'] ? 'dark-mode' : '' }}">

  <style>
    body.dark-mode {
    background-color: #121212;
    color: #ffffff;
}

body.dark-mode .card {
    background-color: #1e1e1e;
    color: #ffffff;
}

body.dark-mode .navbar, 
body.dark-mode .sidebar {
    background-color: #1b1b1b;
}
body.dark-mode .nav-link {
    color: #b0b0b0; }
    body.dark-mode {
    background-color: #121212;
    color: #ffffff;
}

body.dark-mode .card, 
body.dark-mode .navbar, 
body.dark-mode .sidebar {
    background-color: #1e1e1e;
    color: #ffffff;
}

body.dark-mode a, 
body.dark-mode .text-dark {
    color: #ddd;
}

/* Add any specific overrides for Purple template */

  </style>

<div class="container-scroller">
  <!-- Navbar -->
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
      <a class="navbar-brand brand-logo" href="{{ route('admin.home') }}"><img src="{{ asset('images/favico.png') }}" alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="{{ route('admin.home') }}"><img src="{{ asset('images/favico.png') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      <div class="search-field d-none d-md-block">
        <form class="d-flex align-items-center h-100" action="#">
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <i class="input-group-text border-0 mdi mdi-magnify"></i>
            </div>
            <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
          </div>
        </form>
      </div>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <img src="{{ asset('images/faces/face1.jpg') }}" alt="image">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="#">
              <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
          </div>
        </li>
        <li class="nav-item d-none d-lg-block full-screen-link">
          <a class="nav-link"><i class="mdi mdi-fullscreen" id="fullscreen-button"></i></a>
        </li>
        <li class="nav-item nav-logout d-none d-lg-block">
          <a class="nav-link" href="#"><i class="mdi mdi-power"></i></a>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
  <!-- Main Content -->
  <div class="container-fluid page-body-wrapper">
  <!-- Sidebar -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile" />
            <span class="login-status online"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
            <span class="text-secondary text-small">Administrator</span>
            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
          </div>
        </a>
      </li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.home') }}"><span class="menu-title">Dashboard</span><i class="mdi mdi-view-dashboard menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.category') }}"><span class="menu-title">Category</span><i class="mdi mdi-format-list-bulleted menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.product') }}"><span class="menu-title">Products</span><i class="mdi mdi-cube-outline menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.showUserProfile') }}"><span class="menu-title">User Management</span><i class="mdi mdi-account-multiple menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.report') }}"><span class="menu-title">Reports</span><i class="mdi mdi-chart-bar menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings') }}"><span class="menu-title">Settings</span><i class="mdi mdi-cog menu-icon"></i></a></li>
      <li class="nav-item"><a class="nav-link" href=""><span class="menu-title">
        <form action="{{ route('logout') }}" method="POST">
          @csrf 
          <button type="submit" class="btn btn-primary">Logout <i class="mdi mdi-logout menu-icon"></i></button>
        </form></span> </a></li>
    </ul>
  </nav>


    <div class="main-panel">
      <div class="content-wrapper">
        @yield('main-content')
      </div>
      <!-- footer could go here -->
    </div>
  </div>
</div>

<!-- Core JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/js/vendor.bundle.base.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('js/select2/select2.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.tiny.cloud/1/kykmaaub6tinoxdghw2dz8w2zj9erlaxb82nr0gp31ujt96k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('js/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/misc.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>
<script src="{{ asset('js/todolist.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

<!-- Alertify session messages -->
<script>
alertify.set('notifier','position', 'top-right');
@if(session('success')) 
alertify.success("{{ session('success') }}"); 
@endif
@if(session('error')) 
alertify.error("{{ session('error') }}");
 @endif
</script>

@yield('script')
</body>
</html>
