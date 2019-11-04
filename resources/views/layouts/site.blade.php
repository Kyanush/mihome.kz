@php
    $currentCity = \App\Services\ServiceCity::getCurrentCity();
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords"    content="@yield('keywords')">

    <meta name="csrf-token"               content="{{ csrf_token() }}" />

    <meta property="og:locale"       content="ru_KZ" />
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ url()->current() }}"/>
    <meta property="og:site_name"    content="{{ env('APP_NAME') }}" />
    <meta property="og:title"        content="@yield('title')"/>
    <meta property="og:description"  content="@yield('description')"/>
    <meta property="og:image"        content="@yield('og_image')"/>
    <meta property="og:image:width"  content="80">
    <meta property="og:image:height" content="80">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">



    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/site/css/bootstrap.min.css"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="/site/css/slick.css"/>
    <link type="text/css" rel="stylesheet" href="/site/css/slick-theme.css"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="/site/css/nouislider.min.css"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="/site/css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="/site/css/style.css"/>


    <!-- Vue js -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script src="/site/js/jquery.min.js"></script>

    <!-- axios -->
    <script type="text/javascript" src="/site/js/axios.min.js"></script>
    <script src="/global/config-axios.js"></script>
    <!-- axios -->

    @yield('add_in_head')

    @include('schemas.business')
    @include('schemas.organization')
    @yield('schemas_breadcrumb')
    @yield('schemas_product')



</head>
<body>

<!-- HEADER -->
<span id="header">
<header  style="display: none" v-bind:style="show_block">

    @php
        $address = config('shop.address');
        $number_phones = config('shop.number_phones');
    @endphp

    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li>
                    <i class="fa fa-phone"></i>

                    @foreach($number_phones as $phone)
                        <a href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                    @endforeach
                </li>
                <li>
                    <a href="{{ route('contact') }}">
                        <i class="fa fa-map-marker"></i>
                        {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                    </a>
                </li>
            </ul>
            <ul class="header-links pull-right">
                <li>
                    <a href="#" onclick="modalShow('.callback')">
                        <i class="fa fa-phone"></i>
                        Обратный звонок
                    </a>
                </li>
                <li>
                    <a href="#" onclick="modalShow('.select-city')">
                        <i class="fa fa-building-o" aria-hidden="true"></i>
                        Город: {{ $currentCity->name }}
                    </a>
                </li>
                @guest
                    <li><a href="/login"><i class="fa fa-sign-in"></i> Войти</a></li>
                    <li><a href="/register"><i class="fa fa-user-o"></i> Регистрация</a></li>
                @endguest
                @auth
                    <li><a href="{{ route('my_account') }}"><i class="fa fa-sign-in"></i>{{ Auth::user()->name }}</a></li>
                    <li><a href="{{ route('logout') }}">    <i class="fa fa-user-o"></i> Выйти</a></li>
                @endauth
            </ul>
        </div>
    </div>
        <!-- /TOP HEADER -->


        <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="/" class="logo">
                            <img class="lazy"
                                 data-original="{{ config('shop.logo') }}"
                                 title="{{ env('APP_NAME') }}"
                                 alt="{{ env('APP_NAME') }}"/>
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <input class="input product-search" placeholder="Поиск по товарам, например Xiaomi">
                        <!--
                        <form>
                            <select class="input-select">
                                <option value="0">All Categories</option>
                                <option value="1">Category 01</option>
                                <option value="1">Category 02</option>
                            </select>
                            <input class="input product-search" placeholder="Поиск по товарам, например Xiaomi">
                            <button class="search-btn">Поиск</button>
                        </form>
                        --->
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="{{ route('wishlist') }}" title="Мои закладки">
                                <i class="fa fa-heart-o"></i>
                                <span>Мои закладки</span>
                                <div class="qty" v-if="pfwc">@{{ pfwc }}</div>
                            </a>
                        </div>
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div class="dropdown" id="header-cart">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Корзина</span>
                                <div class="qty" v-if="cart_total.quantity > 0">@{{ cart_total.quantity }}</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    <div class="product-widget" v-for="(item, index) in list_cart">
                                        <div class="product-img">
                                            <img width="40"
                                                 v-bind:src="item.product_photo"
                                                 v-bind:alt="item.product_name"
                                                 v-bind:title="item.product_name">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name">
                                                <a  v-bind:href="item.product_url">
                                                    @{{ item.product_name }}
                                                </a>
                                            </h3>
                                            <h4 class="product-price">
                                                <span class="qty">@{{ item.quantity }}x</span>
                                                @{{ item.product_specific_price }}
                                            </h4>
                                        </div>
                                        <button class="delete" @click="deleteProductQuantity(item.product_id)">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small>Товар в корзине: @{{ cart_total.quantity }}</small>
                                    <h5>ИТОГО: @{{ cart_total.sum }}</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="#">&nbsp;</a>
                                    <a href="{{ route('checkout') }}">
                                        Оформить
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <div class="menu-toggle" onclick="modalShow('.catalog-menu')">
                            <a>
                                <i class="fa fa-bars"></i>
                                Каталог
                            </a>
                        </div>

                        <!-- Menu Toogle -->
                        <div class="menu-toggle" id="menu-mobile">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Меню</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
        <!-- /MAIN HEADER -->
</header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">


            <i class="fa fa-remove fa-2x" id="close-menu"></i>



            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="cat_menu_container">
                    <a class="catalog-products">
                        <i class="fa fa-bars firm-red"></i>
                        Каталог
                    </a>
                    @php
                        $categories1 = \App\Models\Category::orderBy('sort')->isActive()->where('parent_id', 0)->get();
                    @endphp
                    <ul class="cat_menu">
                        @foreach($categories1 as $category1)
                            @php
                                $categories2 = $category1->children()->isActive()->orderBy('sort')->get();
                            @endphp
                            <li @if($categories2->isNotEmpty()) class="hassubs" @endif>
                                <a href="{{ $category1->catalogUrl($currentCity->code) }}">
                                    <img src="{{ $category1->pathImage(true) }}"/>
                                    {{ $category1->name }}
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                                @if($categories2->isNotEmpty())
                                    <ul>
                                            @foreach($categories2 as $category2)
                                            @php
                                                $categories3 = $category2->children()->isActive()->orderBy('sort')->get();
                                            @endphp
                                            <li @if($categories3->isNotEmpty()) class="hassubs" @endif>
                                                    <a href="{{ $category2->catalogUrl($currentCity->code) }}">
                                                        <img src="{{ $category2->pathImage(true) }}"/>
                                                        {{ $category2->name }}
                                                        <i class="fa fa-chevron-right"></i>
                                                    </a>
                                                    @if($categories3->isNotEmpty())
                                                        <ul>
                                                                @foreach($categories3 as $category3)
                                                                    @php
                                                                        $categories4 = \App\Models\Category::orderBy('sort')
                                                                                ->isActive()
                                                                                ->whereIn('id', \App\Services\ServiceCategory::categoryChildIds($category3->id, false, true))
                                                                                ->get();
                                                                    @endphp
                                                                    <li @if($categories4->isNotEmpty()) class="hassubs" @endif>
                                                                        <a href="{{ $category3->catalogUrl($currentCity->code) }}">
                                                                            <img src="{{ $category3->pathImage(true) }}"/>
                                                                            {{ $category3->name }}
                                                                            <i class="fa fa-chevron-right"></i>
                                                                        </a>
                                                                        @if(count($categories4) > 0)
                                                                            <ul>
                                                                               @foreach($categories4 as $category4)
                                                                               <li>
                                                                                    <a href="{{ $category4->catalogUrl($currentCity->code) }}">
                                                                                         <img src="{{ $category4->pathImage(true) }}"/>
                                                                                        {{ $category4->name }}
                                                                                    </a>
                                                                               </li>
                                                                               @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="{{ Request::routeIs('delivery_payment') ? 'active' : '' }}"><a href="{{ route('delivery_payment') }}">Доставка/Оплата</a></li>
                <li class="{{ Request::routeIs('guaranty') ? 'active' : '' }}"><a href="{{ route('guaranty') }}">Гарантия</a></li>
                <li class="{{ Request::routeIs('wishlist') ? 'active' : '' }}">
                    <a href="{{ route('wishlist') }}">
                        Мои закладки
                        <span class="badge badge-error" v-if="pfwc > 0">
                            @{{  pfwc }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('compare_products') ? 'active' : '' }}">
                    <a href="{{ route('compare_products') }}">
                        Сравнение товаров
                        <span class="badge badge-error" v-if="pfwc > 0">
                            @{{  pfwc }}
                        </span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Контакты</a></li>
                <li class="{{ Request::routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">О нас</a></li>
                <li class="{{ Request::routeIs('checkout') ? 'active' : '' }}"><a href="{{ route('checkout') }}">Корзина</a></li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
    <!-- /NAVIGATION -->
</span>

@yield('content')




<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Подпишитесь на рассылку <strong>НОВОСТЕЙ</strong></p>
                    <form action="javascript:void(null);" onsubmit="subscribe(this); return false;" method="post" enctype="multipart/form-data">
                        @csrf
                        <input name="email" class="input" type="email" placeholder="Введите адрес электронной почты"/>
                        <button type="submit" class="newsletter-btn">
                            <i class="fa fa-envelope"></i>
                            Подписывайся
                        </button>
                    </form>
                    <ul class="newsletter-follow">

                            <li><b>Мы в соцсетях.</b></li>
                            @foreach(config('shop.social_network') as $item)
                                <li>
                                    <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" target="_blank">
                                        <img height="30"
                                             class="lazy"
                                             data-original="{{ $item['icon'] }}"/>
                                    </a>
                                </li>
                            @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /NEWSLETTER -->

<!-- FOOTER -->
<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <div class="footer">
                        <h3 class="footer-title">О нас</h3>
                        <p>
                            {{ env('APP_NO_URL') }} — интернет-магазин смартфонов, гаджетов и ноутбуков
                        </p>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('contact') }}">
                                    <i class="fa fa-map-marker"></i>
                                    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                @foreach($number_phones as $phone)
                                    <a href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
                                    <br/>
                                @endforeach
                            </li>
                            <li>
                                <a href="mailto:{{ config('shop.site_email') }}">
                                    <i class="fa fa-envelope-o"></i>
                                    {{ config('shop.site_email') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                @php
                    $city = $currentCity['code'] == 'almaty' ? '' : '/' . $currentCity['code'];
                @endphp
                <div class="col-md-3 col-xs-12">
                    <div class="footer">
                        <h3 class="footer-title">Каталог</h3>
                        <ul class="footer-links">
                            <li><a href="{{$city}}/catalog/smartfony-xiaomi">Смартфоны Xiaomi</a></li>
                            <li><a href="{{$city}}/catalog/gadzhety">Гаджеты и устройства</a></li>
                            <li><a href="{{$city}}/catalog/transport">Электронный транспорт</a></li>
                            <li><a href="{{$city}}/catalog/naushniki-i-kolonki">Наушники и колонки</a></li>
                            <li><a href="{{$city}}/catalog/aksessuary">Аксессуары</a></li>
                            <li><a href="{{$city}}/catalog/zaryadnye-ustroystva">Зарядные устройства</a></li>
                        </ul>
                    </div>
                </div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Меню</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('delivery_payment') }}">Доставка/Оплата</a></li>
                            <li><a href="{{ route('guaranty') }}">Гарантия</a></li>
                            <li><a href="{{ route('wishlist') }}">Мои закладки</a></li>
                            <li><a href="{{ route('compare_products') }}">Сравнение товаров</a></li>
                            <li><a href="{{ route('contact') }}">Контакты</a></li>
                            <li><a href="{{ route('about') }}">О нас</a></li>
                            <li><a href="{{ route('checkout') }}">Корзина</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Информация</h3>
                        <ul class="footer-links">
                            <li><a rel="nofollow" href="/login">Войти</a></li>
                            <li><a rel="nofollow" href="/register">Регистрация</a></li>
                            <li><a rel="nofollow" href="{{ route('my_account') }}">Личный кабинет</a></li>
                            <li><a rel="nofollow" href="{{ route('order_history') }}">Мои заказы</a></li>
                            <li><a rel="nofollow" href="{{ route('account_edit') }}">Личные данные</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /top footer -->

    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">

                    <ul class="footer-payments">
                        <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                        <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                    </ul>

                    <span class="copyright">
	    				Copyright &copy;{{date('Y')}} Все права защищены.
    				</span>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->

</footer>
<!-- /FOOTER -->


<div class="callback-button" title="Обратный звонок" onclick="modalShow('.callback')">
    <i class="fa fa-phone"></i>
</div>



<!-- Каталог товаров -->
<div class="modal fade catalog-menu" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    Каталог товаров
                </h4>
            </div>
            <div class="modal-body">



                <?php
                $categories = \App\Models\Category::orderBy('sort')->isActive()->where('parent_id', 0)->get();
                ?>

                <ul class="nav nav-tabs">
                    @php $active = true; @endphp
                    @foreach($categories as $k => $category)
                        <li @if($active) class="active" @php $active = false; @endphp @endif>
                            <a data-toggle="tab" href="#{{ $category->url }}">
                                <i class="{{ $category->class }}"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @php $active = true; @endphp
                    @foreach($categories as $k => $category)
                        <div id="{{ $category->url }}" class="tab-pane fade @if($active) in active @php $active = false; @endphp @endif">
                            <?php
                            $categories = [];
                            foreach($category->children()->isActive()->orderBy('sort')->get() as $category_children){
                                $categories[] = $category_children;

                                $childrens_all = \App\Models\Category::orderBy('sort')
                                    ->isActive()
                                    ->whereIn('id', \App\Services\ServiceCategory::categoryChildIds($category_children->id, false, true))
                                    ->get();

                                foreach ($childrens_all as $item)
                                    $categories[] = $item;
                            }
                            ?>

                            <ul>
                                <li>
                                    <a href="{{ $category->catalogUrl($currentCity->code) }}">
                                                        <span>
                                                            <i class="{{ $category->class }} fa-3x"></i>
                                                        </span>
                                        <span>Все {{ $category->name }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $key => $item)
                                    <li>
                                        <a href="{{ $item->catalogUrl($currentCity->code) }}">
                                                        <span>
                                                            @if($item->image)
                                                                <img src="{{ $item->pathImage(true) }}"/>
                                                            @endif
                                                        </span>
                                            <span>{{ $item->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Каталог товаров -->


<!-- Выбор города -->
@php
    $cities = \App\Services\ServiceCity::groupingFirstLetters();
@endphp
<div class="modal fade select-city" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    Выбор города
                </h4>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach($cities as $key => $item_cities)
                        @if(count($item_cities) == 1)
                            <li>
                                <ul>
                                    <li class="first_char">{{ $key }}</li>
                                    @foreach($item_cities as $city)
                                        <li>
                                            <a onclick="setCity('{{$city->code}}')" @if(in_array($city->id, [4,20])) class="special_town_a" @endif>
                                                {{ $city->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <ul>
                                    <li class="first_char">{{ $key }}</li>
                                    @foreach($item_cities as $city)
                                        <li>
                                            <a onclick="setCity('{{$city->code}}')" @if(in_array($city->id, [4,20])) class="special_town_a" @endif>
                                                {{ $city->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                Не нашли свой город? У нас есть доставка по <a href="{{ route('delivery_payment') }}">Казахстан</a>.
            </div>
        </div>
    </div>
</div>
<!-- Выбор города -->


<!-- Обратный звонок -->
<div class="modal fade callback" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    Обратный звонок
                </h4>
            </div>
            <form action="javascript:void(null);" onsubmit="callback(this); return false;" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="url" value="{{ url()->current() }}"/>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Введите номер телефона</label>
                        <input type="text"
                               name="phone"
                               class="form-control phone-mask"
                               @auth
                               value="{{ Auth::user()->phone }}"
                               @endauth
                               placeholder="+7 (___) ___-__-__">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-firm">
                        <img class="ajax-loader" src="/site/images/ajax-loader.gif"/>
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Обратный звонок -->


<!-- Быстрый просмотр -->
<div id="quickView" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <a :href="detailUrlProduct">
                        @{{ product.name }}
                    </a>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <a :href="detailUrlProduct">
                            <img :src="pathPhoto"/>
                        </a>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <ul>
                            <li>
                                <b>Цена:</b> @{{ price }}
                                <br/>
                            </li>
                            <li v-for="attribute in attributes" v-if="attribute.pivot.value && (attribute.id != 49 && attribute.id != 61 && attribute.id != 62)">
                                <b>@{{ attribute.name }}:</b> @{{  attribute.pivot.value }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- Быстрый просмотр -->





<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jquery-ui --->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<!-- jquery-ui --->




<!---- sweetalert2  ----->
<script src="/site/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<link rel="stylesheet" type="text/css" href="/site/sweetalert2/sweetalert2.min.css">
<!---- sweetalert2  ----->


<!-- Vue js -->

<!-- commentbook -->
<script src="/commentbook/script.js" data-jv-id="d5ShOZJS9K"></script>
<!-- commentbook -->



<!-- Mask --->
<script type="text/javascript" src="/site/js/jquery.maskedinput.min.js"></script>
<!-- Mask --->

<script src="/site/js/jquery.lazyload.min.js"></script>

<script src="/global/script.js"></script>
<script src="/site/js/script.js"></script>

<!-- jQuery Plugins -->
<script src="/site/js/bootstrap.min.js"></script>
<script src="/site/js/slick.min.js"></script>
<script src="/site/js/nouislider.min.js"></script>
<script src="/site/js/jquery.zoom.min.js"></script>
<script src="/site/js/main.js"></script>

<!-- jivosite -->
<script src="//code.jivosite.com/widget.js" data-jv-id="d5ShOZJS9K"></script>
<!-- jivosite -->

@yield('add_in_end')

@include('includes.analytics_body')

@include('includes.analytics')


</body>
</html>
