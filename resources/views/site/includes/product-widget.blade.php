<!-- product widget -->
<div class="product-widget">
    <div class="product-img">
        <a href="{{ $product->detailUrlProduct() }}">
            <img title="{{ $product->name }}"
                 alt="{{ $product->name }}"
                 src="{{ $product->pathPhoto(true) }}">
        </a>
    </div>
    <div class="product-body">
        <p class="product-category">
            <i class="fa fa-comment"></i>
            {{ $product->reviews_count }}
        </p>
        <h3 class="product-name">
            <a href="{{ $product->detailUrlProduct() }}">
                {{ $product->name }}
            </a>
        </h3>
        <h4 class="product-price">
            {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
            @if($product->specificPrice)
                <del class="product-old-price">
                    {{ \App\Tools\Helpers::priceFormat($product->price) }}
                </del>
            @endif
        </h4>
    </div>
</div>
<!-- /product widget -->