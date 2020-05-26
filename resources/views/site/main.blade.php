@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    <style>
        #responsive-nav{
            position: absolute;
            z-index: 1;
            width: 100%;
        }
    </style>

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <div class="main-slider" style="width: 100%">

                @foreach($listSlidersHomePage as $item)
                    <a href="{{ $item->link }}" title="{{ $item->name }}" title="{{ $item->name }}">
                        @if($item->typeFile() == 'video')
                            <video width="100%" uk-cover="" src="{{ $item->pathImage(true) }}" loop="" autoplay="" muted="" playsinline=""></video>
                        @elseif($item->typeFile() == 'image')
                            <img data-lazy="{{ $item->pathImage(true) }}" alt="{{ $item->name }}"  class="lazy"/>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


    @if(false)
    @include('site.includes.product_day')
    @endif

    @include('site.includes.product_slider', ['products' => $products1, 'title' => 'Флагманы - Mi'])
    @include('site.includes.product_slider', ['products' => $products2, 'title' => 'Недорогие - Redmi'])
    @include('site.includes.product_slider', ['products' => $products3, 'title' => 'Пылесосы'])

    @if(false)
        <!-- HOT DEAL SECTION -->
        <div id="hot-deal" class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="hot-deal">

                            <ul class="hot-deal-countdown">
                                <li>
                                    <div>
                                        <h3>1</h3>
                                        <span>НИЗКАЯ ЦЕНА</span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>2</h3>
                                        <span>Скидки </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>3</h3>
                                        <span>Акции </span>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <h3>4</h3>
                                        <span>Нашли дешевле?</span>
                                    </div>
                                </li>
                            </ul>

                            <h2 class="text-uppercase">Смартфоны</h2>
                            <p>Успей купить!</p>
                            <a class="primary-btn cta-btn" href="/catalog/smartfony">Посмотреть</a>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /HOT DEAL SECTION -->
    @endif


    @if(false)
        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->

                @include('site.includes.product_slider', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])

                <div class="row">
                    @include('site.includes.products-widget-slick', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])
                    @include('site.includes.products-widget-slick', ['products' => $popularProducts,    'title' => 'Популярные товары'])
                    <div class="clearfix visible-sm visible-xs"></div>
                    @include('site.includes.products-widget-slick', ['products' => $novinkiProducts,    'title' => 'Новинки товаров'])
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->

        @section('add_in_head')
            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>
            <script  src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v5.0&appId=373541409772772&autoLogAppEvents=1"></script>
        @stop

        <!-- SECTION -->
        <div class="section" id="main-about">
            <!-- container -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        @include('social-network.instagram')
                    </div>
                    <div class="col-md-4">
                        <!-- VK Widget -->
                        <div id="vk_groups"></div>
                        <script type="text/javascript">
                            VK.Widgets.Group("vk_groups", {mode: 4, no_cover: 1, height: "400"}, 188528698);
                        </script>
                    </div>
                    <div class="col-md-4">
                        <div id="fb-root"></div>
                        <div class="fb-page" data-href="https://web.facebook.com/mihome.kz/" data-tabs="timeline" data-width="" data-height="400" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://web.facebook.com/mihome.kz/" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/mihome.kz/">Интернет-магазин MiHome.kz</a></blockquote></div>
                    </div>
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->
    @endif



    <!-- SECTION -->
    <div class="section" id="main-about">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title">Новости</h3>
                    <br/>
                    @include('site.news.widget', ['news' => $news])
                    <p class="text-right">
                        <a href="{{ route('news_list') }}">Все новости</a>
                    </p>
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section" id="main-about">
        <!-- container -->
        <div class="container">
            <div class="row">

                <div class="col-md-3 col-xs-6">
                    <p>
                        <i class="fa fa-check-circle fa-3x"></i>
                    </p>
                    <b>12 месяцев гарантии<br/>для смартфонов</b>
                    <p>Качественное гарантийное<br/>обслуживание.</p>
                </div>
                <div class="col-md-3 col-xs-6">
                    <p>
                        <i class="fa fa-truck fa-3x"></i>
                    </p>
                    <b>Курьером по Алматы бесплатно</b>
                    <p>Доставка по казахстану 2000 тг</p>
                </div>
                <div class="col-md-3 col-xs-6">
                    <p>
                        <i class="fa fa-fire fa-3x"></i>
                    </p>
                    <b>6 месяцев гарантии<br/>для аксессуаров</b>
                    <p>Время, отведенное на диагностику<br/>и ремонт телефона.</p>
                </div>
                <div class="col-md-3 col-xs-6">
                    <p>
                        <i class="fa fa-users fa-3x"></i>
                    </p>
                    <b>Много<br>фанатов</b>
                    <p>Живые обсуждения<br>в наших группах</p>
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section main-info">
        <!-- container -->
        <div class="container">
            <div class="company-text">
                @include('includes.about_text')
            </div>
            <!--
            <div class="show-full">
                <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                Показать полностью
            </div>
            --->
        </div>
    </div>
    <!-- /SECTION -->



@endsection
