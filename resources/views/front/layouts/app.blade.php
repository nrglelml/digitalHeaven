<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="{{asset('assets/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">


    <link rel="stylesheet" href="{{asset('assets/css/aos.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.dsmcdn.com/web/master/account-navigation-v2.style.68e0d7f00ac9d6997cc17a77c6edfca7.css">
</head>
<body>

<div class="site-wrap">
    <header class="site-navbar" role="banner">
        <div class="site-navbar-top">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                        <form action="" class="site-block-top-search">
                            <span class="icon icon-search2"></span>
                            <input type="text" class="form-control border-0" placeholder="Search">
                        </form>
                    </div>

                    <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                        <div class="site-logo">
                            <a href="{{route('home')}}" class="js-logo-clone">Digital Heaven</a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                        <div class="site-top-icons">
                            <ul>
                                <li><a href="#"><span class="icon icon-person"></span></a></li>
                                <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                                <li>
                                    <a href="{{route('cart')}}" class="site-cart">
                                        <span class="icon icon-shopping_cart"></span>
                                        <span class="count">{{count(session('cart') ?? [])}}</span>
                                    </a>
                                </li>
                                <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <nav class="site-navigation text-right text-md-center" role="navigation">
            <div class="container">
                <ul class="site-menu js-clone-nav d-none d-md-block">
                    <li class=" {{Route::is('home') ?  "active" : ""}}">
                        <a href="{{route('home')}}">Ana Sayfa</a>
                    </li>
                    <li class="has-children {{ Route::is('products') ? 'active' : '' }}">
                        <a href="#">Kategoriler</a>
                        <ul class="dropdown">

                            @if (!empty($categories) && $categories->count() > 0)
                                @foreach ($categories->where('cat_alt',null) as $category)
                                    <li class="has-children">
                                        <a href="{{route($category->slug.'ürün')}}">{{$category->name}}</a>
                                        <ul class="dropdown">
                                            @foreach ($category->subcategory as $subCategory)
                                                <li><a href="{{route($category->slug.'ürün',$subCategory->slug)}}">{{$subCategory->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @else
                                <p>Ürün Bulunamadı</p>
                            @endif

                        </ul>
                    </li>



                    <li class=" {{Route::is('aboutus') ?  "active" : ""}}">
                        <a href="{{route('aboutus')}}">Hakkımızda</a>
                    </li>
                    <li class="has-children {{Route::is('products') ?  "active" : ""}}">
                        <a href="{{route('products')}}">Ürünler</a>
                        <ul class="dropdown">
                            <li><a href="#">Menu One</a></li>
                            <li><a href="#">Menu Two</a></li>
                            <li><a href="#">Menu Three</a></li>
                        </ul>
                    </li>
                    <li class="has-children {{Route::is('contact') ?  "active" : ""}}">
                        <a href="{{route('contact')}}">İletişim</a>

                    </li>

                </ul>
            </div>
        </nav>
    </header>

            @yield('content')

    <footer class="site-footer border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="footer-heading mb-4">Menü</h3>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <ul class="list-unstyled">
                                <li><a href="{{route('home')}}">Ana Sayfa</a></li>
                                <li><a href="{{route('aboutus')}}">Hakkımızda</a></li>
                                <li><a href="{{route('products')}}">Ürünler</a></li>
                                <li><a href="{{route('contact')}}">İletişim</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="block-5 mb-5">
                        <h3 class="footer-heading mb-4">İletişim</h3>
                        <ul class="list-unstyled">
                            <li class="address">{{ $settings['adres'] }}</li>
                            <li class="phone"><a href="tel:{{ str_replace(' ', '', $settings['phone']) }}">{{ $settings['phone'] }}</a></li>
                            <li class="email">{{ $settings['email'] }}</li>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <p>
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> Tüm hakları saklıdır

                    </p>
                </div>

            </div>
        </div>
    </footer>
</div>

<script src="{{asset('assets/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/aos.js')}}"></script>
@yield('customjs')
<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>
