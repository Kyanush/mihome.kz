@if($products and count($products) > 0)
    <div class="mount-item-teaser">
        <h2 class="container-title">
            {{ $title }}
            @if($url)
                <a href="{{ $url }}" class="container-more-link">
                    Смотреть все
                </a>
            @endif
        </h2>
        <div class="container g-pa0 g-bb-fat g-bg-c0 _scroll1 product-slider">

            @foreach($products as $product)
                @include('mobile.includes.product_item', ['product' => $product])
            @endforeach

        </div>
    </div>
@endif

<?php unset($products); ?>