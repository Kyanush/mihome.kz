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


                <!-- row -->
                <div class="row">
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
                                        <div class="checkbox-filter {{ !isset($filters[$attribute->code]) ? '' : 'active' }}">
                                            @foreach($attribute->values as $k => $value)
                                                <div class="input-checkbox">

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

                        <br/>

                        @php
                            $detect = new \Mobile_Detect();
                        @endphp
                        @if(!$detect->isMobile())
                            <!-- aside Widget -->
                            <div class="aside">
                                <h3 class="aside-title">ВЫ СМОТРЕЛИ</h3>
                                @foreach($youWatchedProducts as $product)
                                    @include('site.includes.product-widget', ['product' => $product])
                                @endforeach
                            </div>
                            <!-- /aside Widget -->
                        @endif
                    </div>
                    <!-- /ASIDE -->

                    <!-- STORE -->
                    <div id="store" class="col-md-9">
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
                        <div class="row">

                            @foreach($products as $product)
                                <!-- product -->
                                    <div class="col-md-4 col-xs-12">
                                        @include('site.includes.product_item', ['product' => $product])
                                    </div>
                               <!-- /product -->
                            @endforeach

                        </div>
                        <!-- /store products -->



                        <!-- store bottom filter -->
                        <div class="store-filter clearfix">
                            <span class="store-qty">
                                Товар {{$products->currentpage() * $products->perpage()}} из {{$products->total()}}
                            </span>


                            {!! $products->links("pagination::default") !!}

                        </div>
                        <!-- /store bottom filter -->
                    </div>
                    <!-- /STORE -->
                </div>
                <!-- /row -->

                @include('site.includes.product_slider', ['products' => $productsHitViewed, 'title' => 'Хиты'])

                @if(isset($category->description))
                    <div>
                        <br/>
                        <h2>{{ $category->name }}</h2>
                        <br/>
                        @if($category->description)
                            {!! $category->description  !!}
                            <br/>
                            <br/>
                        @endif
                        <h2>Где купить {{ $category->name }}</h2>
                        <br/>
                        <p>
                            Заказать товар с доставкой на дом в пределах <b>{{ $currentCity->name }}</b>, <b>Казахстан</b> можно круглосуточно, через корзину на сайте.
                            Интернет-магазин официальных товаров {{ env('APP_NO_URL') }} предлагает доставку заказов и в
                            другие города Республики Казахстан. К оплате принимаются банковские карты и наличные средства.
                        </p>
                    </div>
                @endif



            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->


@endsection
