@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    <div class="topbar container _always-fixed">
        <a  class="topbar__icon icon icon_menu "><span></span></a>
        <h1 class="topbar__heading ">
            <a href="/" class="topbar__heading-link">
                <i class="topbar__heading-logo _icon"></i>
                {{ env('APP_NO_URL') }}
            </a>
        </h1>
        <a href="/login" class="topbar__icon icon icon_user"></a>
    </div>

    @include('mobile.includes.search-bar', ['class' => 'fixed-block _with-topbar _always-fixed'])

    @include('mobile.includes.space', ['style' => 'height: 17.073vw;'])

    <div class="catalog-items _grid">
        <?php $categories = \App\Models\Category::orderBy('sort')->where('parent_id', 0)->get();?>
        @foreach($categories as $category)
            <a href="{{ $category->redirect_url ? $category->redirect_url : route('category_menu_mobile',['category' => $category->url]) }}" class="catalog-item container">
                <span class="catalog-item__img">
                    <img width="24" data-original="{{ $category->pathImage(true) }}" class="lazy"/>
                </span>
                <span class="catalog-item__title">
                   {{ $category->name }}
                </span>
                <span class="catalog-item__icon icon icon_chevron"></span>
            </a>
        @endforeach
    </div>


    @include('mobile.includes.main-slider')


    @include('mobile.includes.product_slider', ['products' => $products1, 'title' => 'Redmi Note 8 Pro', 'url' => ''])
    @include('mobile.includes.product_slider', ['products' => $products2, 'title' => 'Redmi Note 8', 'url' => ''])

    @include('mobile.includes.product_slider', ['products' => $productsDiscount,  'title' => 'Акции', 'url' => ''])


    <div class="mount-item-teaser">
        <h2 class="container-title">Мы в социальных сетях</h2>
        <div class="container">
            @include('social-network.instagram')
        </div>
            @if(false)
            @section('add_in_head')
                <script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>
                <script  src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v5.0&appId=373541409772772&autoLogAppEvents=1"></script>
            @stop

            <div class="container">
                <!-- VK Widget -->
                <div id="vk_groups"></div>
                <script type="text/javascript">
                    VK.Widgets.Group("vk_groups", {mode: 4, no_cover: 1, height: "400"}, 188528698);
                </script>
            </div>
            <div class="container">
                <div id="fb-root"></div>
                <div class="fb-page" data-href="https://web.facebook.com/mihome.kz/" data-tabs="timeline" data-width="" data-height="400" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://web.facebook.com/mihome.kz/" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/mihome.kz/">Интернет-магазин MiHome.kz</a></blockquote></div>
            </div>
        @endif
    </div>

    <div class="mount-item-teaser">
        <div class="container g-bb-fat g-bg-c0 company-text">
            @include('includes.about_text')
        </div>
        <!--
        <div class="container g-bb-fat g-bg-c0">
            <a id="show-full">
                Показать полностью
                <br/>
            </a>
        </div>-->
    </div>

    @include('mobile.includes.footer')

@endsection
