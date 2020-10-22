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

                    
                    <!-- STORE -->
                    <div id="store" class="col-md-12">



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
