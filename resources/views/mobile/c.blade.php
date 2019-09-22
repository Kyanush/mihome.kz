@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '',
        'title'       => $category->name,
        'search_show' => true,
        'menu_link'   => '',
        'menu_class'  => 'icon_menu'
    ])

    <div class="categories">

        @include('mobile.includes.search-bar', ['class' => 'fixed-block'])

        @include('mobile.includes.space', ['style' => 'height: 17.073vw;'])

        <div class="catalog-sub-items">
            <ul class="catalog-sub-items__list">
                @foreach($category->children()->orderBy('sort')->get() as $item)
                    <li class="catalog-sub-items__el">
                        <a href="{{ $item->catalogUrl($currentCity->code) }}" class="catalog-sub-item catalog-main">
                            <span class="catalog-sub-item__title">{{ $item->name }}</span>

                            @php
                                $items = $item->children()->orderBy('sort')->get();
                            @endphp

                            @if(count($items) > 0)
                                <span class="catalog-sub-item__icon catalog-sub-item__close icon icon_plus"></span>
                            @else
                                <span class="catalog-sub-item__icon icon icon_chevron"></span>
                            @endif
                        </a>
                        @if(count($items) > 0)
                            <ul class="catalog-sub-items__list">
                                @foreach($items as $item2)
                                    <li class="catalog-sub-items__el">
                                        <a href="{{ $item2->catalogUrl($currentCity->code) }}" class="catalog-sub-item">
                                            <span class="catalog-sub-item__title">{{ $item2->name }}</span>
                                            <span class="catalog-sub-item__icon icon icon_chevron"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    @include('mobile.includes.footer')

@endsection