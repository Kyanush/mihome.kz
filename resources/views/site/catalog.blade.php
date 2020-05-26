@extends('layouts.site')

@section('title',    	 $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')




        @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])



        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">



                @php
                    $subcategories = $category->children()->isActive()->orderBy('sort')->get();
                @endphp
                @if(count($subcategories) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Подкатегории</h3>
                            <br/>
                            @foreach($subcategories as $children_sub)
                                <div class="col-md-3">
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img class="lazy"
                                                 title="{{ $children_sub->name }}"
                                                 alt="{{ $children_sub->name }}"
                                                 data-original="{{ $children_sub->pathImage(true) }}"/>
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name">
                                                <a href="{{ $children_sub->catalogUrl() }}">
                                                    {{ $children_sub->name }}
                                                </a>
                                            </h3>
                                            <!--
                                            <p class="product-category">Category</p>
                                            <h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
                                            --->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <br/>
                @endif


                <h1 class="text-center">{{ $category->name }}</h1>


                <!-- row -->
                <div class="row">
                    @if(false)
                    <!-- ASIDE -->
                    <div id="aside" class="col-md-3">
                        <!-- aside Widget -->
                        <div class="aside">
                            <form id="filterpro">
                                <!-- aside Widget -->
                                <div class="aside">
                                    <div class="aside-title">Цена</div>
                                    <div class="price-filter">
                                        <div id="price-slider"></div>
                                        <div class="input-number price-min">
                                            <input name="price_start" id="price-min" type="number"/>
                                            <span class="qty-up">+</span>
                                            <span class="qty-down">-</span>
                                        </div>
                                        <span>-</span>
                                        <div class="input-number price-max">
                                            <input name="price_end" id="price-max" type="number"/>
                                            <span class="qty-up">+</span>
                                            <span class="qty-down">-</span>
                                        </div>
                                    </div>
                                </div>
                                <input id="catalog-price-min"   type="hidden" value="{{ $priceMinMax['min'] }}"/>
                                <input id="catalog-price-max"   type="hidden" value="{{ $priceMinMax['max'] }}"/>
                                <input id="catalog-price-value" type="hidden" value='{{ json_encode([round($filters['price_start'] ?? $priceMinMax['min'] ?? 0), round($filters['price_end'] ?? $priceMinMax['max'] ?? 0)]) }}'>




                                @foreach($productsAttributesFilters as $attribute)
                                    <!-- aside Widget -->
                                    <div class="aside">
                                        <div class="aside-title">
                                            {{ $attribute->name }}
                                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $attribute->description }}"></i>
                                        </div>
                                        <div class="checkbox-filter active {{ !isset($filters[$attribute->code]) ? '' : 'active' }}">
                                            @foreach($attribute->values as $k => $value)
                                                <div class="input-checkbox {{ $k > 3 ? 'hide' : '' }}">

                                                    <input onclick="urlParamsGenerate()"
                                                           value="{{ $value->code }}"
                                                           @if(isset($filters[$attribute->code]))
                                                               @if(is_array($filters[$attribute->code]))
                                                                   @foreach($filters[$attribute->code] as $filter_value)
                                                                       @if($filter_value == $value->code)
                                                                            checked
                                                                       @endif
                                                                   @endforeach
                                                               @else
                                                                    @if($filters[$attribute->code] == $value->code)
                                                                        checked
                                                                    @endif
                                                               @endif
                                                           @endif
                                                           type="checkbox"
                                                           id="attribute_value_{{$attribute->id}}{{$value->id}}"
                                                           name="{{ $attribute->code }}"/>

                                                    <label for="attribute_value_{{$attribute->id}}{{$value->id}}">
                                                        <span></span>
                                                        @if($attribute->type == 'color')
                                                            <span class="color" style="background-color: {{ $value->props }};"></span>
                                                            {{ $value->value }}
                                                        @else
                                                            {{ $value->value }}
                                                        @endif
                                                        <!--<small>(578)</small>--->
                                                    </label>
                                                </div>
                                                @if($k == 3)
                                                    <div class="input-checkbox show-more-filters">
                                                        <a>Показать еще <i class="fa fa-angle-down"></i></a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- /aside Widget -->
                                @endforeach

                                 <a onclick="filtersClear()" class="catalog-clear-filter">
                                     <i class="fa fa-filter"></i>
                                     Сбросить фильтр
                                 </a>
                            </form>
                        </div>
                        <!-- /aside Widget -->

                    </div>
                    <!-- /ASIDE -->
                    @endif

                    <!-- STORE -->
                    <div id="store" class="col-md-12">
                        <!-- store top filter -->
                        <div class="store-filter clearfix">
                            <div class="store-sort">
                                <label>
                                    Сортировать по:
                                    <?php
                                        $orderBy = \App\Tools\Helpers::getSortedToFilter($filters);
                                        $column  = $orderBy['sorting_product']['column'];
                                        $order   = $orderBy['sorting_product']['order'];
                                    ?>
                                    <select class="input-select sort_select">
                                        @foreach(\App\Tools\Helpers::listSortingProducts() as $item)
                                            <option
                                                    @if($item['column'] == $column && mb_strtolower($item['order']) == mb_strtolower($order))
                                                        selected
                                                    @endif
                                                    value="{{ $item['value'] }}">{{ $item['title'] }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <!--
                                <label>
                                    показ:
                                    <select class="input-select">
                                        <option value="0">20</option>
                                        <option value="1">50</option>
                                    </select>
                                </label>
                                --->
                            </div>
                            <ul class="store-grid">
                                <li class="active"><i class="fa fa-th"></i></li>
                                <li><a href="#"><i class="fa fa-th-list"></i></a></li>
                            </ul>
                        </div>
                        <!-- /store top filter -->

                        <!-- store products -->
                        @php $row = 1; @endphp
                            @foreach($catalog as $k => $product)
                                @if($row == 1)
                                    <div class="row">
                                        @endif
                                        <div class="col-md-4 col-xs-12">
                                            @include('site.includes.product_item', ['product' => $product])
                                        </div>
                                        @php $row++; @endphp
                                        @if($row == 4 or $k+1 == count($catalog))
                                    </div>
                                @php $row = 1; @endphp
                            @endif
                        @endforeach
                        <!-- /store products -->

                        <!-- store bottom filter -->
                        <div class="store-filter clearfix">
                            <span class="store-qty">
                                Товар {{$catalog->currentpage() * $catalog->perpage()}} из {{$catalog->total()}}
                            </span>
                            {!! $catalog->links("pagination::default") !!}
                        </div>
                        <!-- /store bottom filter -->
                    </div>
                    <!-- /STORE -->
                </div>
                <!-- /row -->

                {!! $category->description  !!}

            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->

        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="{{ asset('/site/css/nouislider.min.css') }}"/>
        <script src="{{ asset('/site/js/nouislider.min.js') }}"></script>


@endsection
