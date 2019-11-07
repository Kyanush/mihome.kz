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
            <a href="/c/{{ $category->url }}" class="catalog-item container">
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
        <h2 class="container-title">Мы в Instagram</h2>
        <div class="container g-pa0 g-bb-fat g-bg-c0">
            @include('instagram.widget')
        </div>
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
