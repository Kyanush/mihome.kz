@extends('layouts.mobile')

@section('title',    	$seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])
@section('og_image',    env('APP_URL') . $product->pathPhoto(true))

@section('content')

    @include('schemas.product', [
        'product'          => $product,
        'group_products'   => $group_products,
        'category'         => $category
    ])

    @php $view = $_GET['view'] ?? false; @endphp
    @if(empty($view))
        @include('mobile.includes.topbar', [
            'class'       => 'g-bb0 g-bg-c0',
            'title'       => '',
            'search_show' => true,
            'menu_link'   => '',
            'menu_class'  => 'icon_menu'
        ])
    @elseif($view == 'attributes')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => 'Характеристики',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
    @elseif($view == 'reviews')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed _fixed-top',
            'title'       => 'Отзывы',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
    @elseif($view == 'descriptions')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => 'Описание',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
    @endif


    @if(empty($view))
        @include('mobile.product.main')
    @elseif($view == 'attributes')
        @include('mobile.product.attributes')
    @elseif($view == 'reviews')
        @include('mobile.product.reviews')
    @elseif($view == 'descriptions')
        @include('mobile.product.descriptions')
    @endif


@endsection
