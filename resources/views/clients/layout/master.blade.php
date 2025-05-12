<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/js/jquery.prettyPhoto.min.js"></script>
    <meta name="author" content="">
    <title>@yield('title', 'Trang Chủ')</title>
    <script>
      if(screen.width <= 736){
          document.getElementById("viewport").setAttribute("content", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");
      }
  </script>
    <!-- Fonts -->
<link rel="shortcut icon" href="assets/images/logos/favicon.png" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('clients/assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/fontawesome-5.14.0.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/flaticon.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/magnific-popup.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/nice-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/slick.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('clients/assets/css/style.css') }}">

</head>
<body>
<div class="page-wrapper">
  <div class="preloader"><div class="custom-loader"></div></div>
   @include('clients.layout.header')
   <section>
   @yield('content')
</section>
   @include('clients.layout.footer')
</div>
  <script src="{{asset('clients/assets/js/aos.js')}}"></script>
  <script src="{{asset('clients/assets/js/appear.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/contact-form-script.js')}}"></script>
  <script src="{{asset('clients/assets/js/form-validator.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/jquery-3.6.0.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/jquery-ui.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/jquery.ajaxchimp.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/jquery.nice-select.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/script.js')}}"></script>
  <script src="{{asset('clients/assets/js/skill.bars.jquery.min.js')}}"></script>
  <script src="{{asset('clients/assets/js/slick.min.js')}}"></script>
</body>
</html>
