@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <div class="main-slider">
                @foreach($listSlidersHomePage as $item)
                    <a href="{{ $item->link }}" title="{{ $item->name }}" style="background-image: url('{{ $item->pathImage(true) }}')" title="{{ $item->name }}">
                        <!--
                        <img src="{{ $item->pathImage(true) }}" alt="{{ $item->name }}">
                        -->
                    </a>
                @endforeach
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->


    @include('site.includes.product_day')
    @include('site.includes.product_slider', ['products' => $productsDiscount, 'title' => 'Акции'])
    @include('site.includes.product_slider', ['products' => $elektrosamokaty, 'title' => 'Самокаты'])


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


    @include('site.includes.product_slider', ['products' => $pylesosy, 'title' => 'Пылесосы Xiaomi'])

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
    @endif

    <!-- SECTION -->
    <div class="section" id="main-about">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include('instagram.widget')
                </div>
                <div class="col-md-8">
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
                    <b>По городу Алматы, Казахстан</b>
                    <p>Доставка 1000-3000тг</p>
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
            <div class="text-center cursor-pointer firm-red" id="show-full">
                <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                Показать полностью
            </div>
        </div>
    </div>
    <!-- /SECTION -->



@endsection
