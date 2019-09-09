@if($products and count($products) > 0)
@php $number = rand(1, 1000); @endphp
<div class="col-md-4 col-xs-12">
    <div class="section-title">
        <h4 class="title">{{ $title }}</h4>
        <div class="section-nav">
            <div id="slick-nav-{{$number}}" class="products-slick-nav"></div>
        </div>
    </div>

    <div class="products-widget-slick" data-nav="#slick-nav-{{$number}}">
        @php $i = 1; @endphp
        @foreach($products as $k => $product)
        @if($i == 1)
            <div>
        @endif

            @include('site.includes.product-widget', ['product' => $product])

        @if($i == 3 or count($products) == $k + 1)
            </div>
            @php $i = 0; @endphp
        @endif
        @php $i++; @endphp
        @endforeach


    </div>
</div>
@endif