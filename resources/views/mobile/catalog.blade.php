@extends('layouts.mobile')

@section('title',    	 $seo['title'])
@section('description',  $seo['description'])
@section('keywords',     $seo['keywords'])

@section('content')

        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => $category->name ?? 'Каталог',
            'search_show' => true,
            'menu_link'   => '',
            'menu_class'  => 'icon_menu'
        ])

        @include('mobile.includes.space', ['style' => ''])

        <div class="mount-catalog-grid">

            <div class="fixed-block _with-topbar">

                @include('mobile.includes.search-bar', ['class' => ''])

                <div class="filters _top">
                    <div class="filters__filter">
                        <div class="filters__filter-button @if(count($filters) != 2) _active @endif" @click="showFilters = true">
                            Фильтры
                            @if(count($filters) != 2)
                                <i class="icon icon_check"></i>
                            @endif
                        </div>
                    </div>
                    <div class="filters__sort ">
                        <div class="slelect-box">
                            <div class="slelect-box__inner">

                                @php
                                    $orderBy = \App\Tools\Helpers::getSortedToFilter($filters);
                                @endphp

                                <div class="select__title" @click="open_sort_catalog = !open_sort_catalog">
                                    <div class="select__title-overflow">
                                        {{ $orderBy['sorting_product']['title'] }}
                                    </div>
                                    <span class="icon icon_triangle"></span>
                                </div>

                                <div class="select__overlay" v-if="open_sort_catalog" @click="open_sort_catalog = !open_sort_catalog"></div>

                                <ul class="select__list" :class="{'_opened': open_sort_catalog}">
                                    @foreach(\App\Tools\Helpers::listSortingProducts() as $item)
                                        <li class="select__list-item @if($item['value'] == $orderBy['sorting_product']['value']) _selected @endif"
                                            @click="catalogSort('{{ $item['value'] }}')">
                                            <a>{{ $item['title'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <select class="sort_select" style="display: none;">
                                    @foreach(\App\Tools\Helpers::listSortingProducts() as $item)
                                        <option
                                            @if($item['value'] == $orderBy['sorting_product']['value'])
                                                selected
                                            @endif
                                            value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="filters__view ">
                        <div class="filters__view-button _grid ">
                            <span class="icon icon_grid"></span>
                        </div>
                        <div class="filters__view-button _list _active">
                            <span class="icon icon_list"></span>
                        </div>
                    </div>
                </div>
            </div>

            @include('mobile.includes.space', ['style' => 'height: 36.273vw;'])

            <div class="catalog-grid _list _top">
                @foreach($products as $product)
                    @include('mobile.includes.product_item', ['product' => $product])
                @endforeach
            </div>

            {!! $products->links("pagination::mobile") !!}

        </div>

        <div v-show="showFilters">
            <filters></filters>
        </div>

        <input id="productsAttributesFilters" type="hidden" value='<?=json_encode($productsAttributesFilters);?>'/>
        <input id="filters"                   type="hidden" value='<?=json_encode($filters);?>'/>

        @include('mobile.includes.footer')

@endsection