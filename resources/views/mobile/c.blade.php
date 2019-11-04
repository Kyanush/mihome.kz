@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    @section('add_in_head')
        <meta name="robots" content="noindex"/>
    @stop

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => $category->name,
        'search_show' => true,
        'menu_link'   => $category->parent_id ? route('category_menu_mobile', ['category' => $category->parent->url]) : route('index'),
        'menu_class'  => 'icon_back'
    ])

    <div class="categories">

        @include('mobile.includes.search-bar', ['class' => 'fixed-block'])

        @include('mobile.includes.space', ['style' => 'height: 17.073vw;'])

        <div class="catalog-sub-items">
            <ul class="catalog-sub-items__list">
                <li class="catalog-sub-items__el">
                    <a href="{{ $category->catalogUrl($currentCity->code) }}" class="catalog-sub-item">
                        <img class="lazy" width="50px" data-original="{{ $category->pathImage(true) }}"/>
                        <b class="catalog-sub-item__title">Все {{ $category->name }}</b>
                        <span class="catalog-sub-item__icon icon icon_chevron"></span>
                    </a>
                </li>
                @foreach($category->children as $item)
                    <li class="catalog-sub-items__el">
                        @php
                            $items = $item->children()->orderBy('sort')->get();
                        @endphp
                        <a href="{{ $items->isNotEmpty() ? route('category_menu_mobile', ['category' => $item->url]) : $item->catalogUrl($currentCity->code) }}" class="catalog-sub-item">

                            <img class="lazy" width="50px" data-original="{{ $item->pathImage(true) }}"/>

                            <span class="catalog-sub-item__title">{{ $item->name }}</span>
                            @if($items->isNotEmpty())
                                <span class="catalog-sub-item__icon catalog-sub-item__close icon icon_plus"></span>
                            @else
                                <span class="catalog-sub-item__icon icon icon_chevron"></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    @include('mobile.includes.footer')

@endsection
