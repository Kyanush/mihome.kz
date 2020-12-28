<!-- product -->
<div class="product">
    <div class="product-img">

        <a href="{{ $product->detailUrlProduct() }}">
            <img class="lazy"
                 title="{{ $product->name }}"
                 alt="{{ $product->name }}"
                 data-original="{{ $product->getPhoto() }}"/>
        </a>

        <div class="product-label">
            @if($product->specificPrice)
                <span class="sale">
                    {{ $product->getDiscountTypeinfo() }}
                </span>
            @endif

            @foreach($product->attributes as $attribute)
                @if($attribute->id == 49 and $attribute->pivot->value)
                    <span class="new {{ str_slug($attribute->pivot->value)  }}">
                        {{ $attribute->pivot->value  }}
                    </span>
                @endif
            @endforeach
        </div>
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

        <p class="text-center {{ $product->status->class }}">
            {{ $product->status->name }}
        </p>

        @if($product->description_short)
            <p class="text-center">{!! $product->description_short !!}</p>
        @endif
        <h4 class="product-price">
            {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
            @if($product->specificPrice)
                <del class="product-old-price">
                    {{ \App\Tools\Helpers::priceFormat($product->price) }}
                </del>
            @endif
        </h4>
        <div class="product-rating">
            @for($i = 1; $i <= 5; $i++)
                <i class="fa <?=(($product->reviews_rating_avg ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
            @endfor
        </div>
        <div class="product-btns">
            <button class="add-to-wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}" onclick="productFeaturesWishlist(this, {{ $product->id }})">
                <i class="fa fa-heart-o"></i>
                <span class="tooltipp">добавить в закладки</span>
            </button>
            <button class="add-to-compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}" onclick="productFeaturesCompare(this, {{ $product->id }})">
                <i class="fa fa-exchange"></i>
                <span class="tooltipp">Добавить к сравнению</span>
            </button>
            <button class="quick-view" onclick="quickView.getProduct({{ $product->id }})">
                <i class="fa fa-eye"></i>
                <span class="tooltipp">Быстрый просмотр</span>
            </button>
        </div>
    </div>
    <div class="add-to-cart">

        <a href="{{ $product->detailUrlProduct() }}">
            <button class="add-to-cart-btn">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                Подробнее
            </button>
        </a>

        @if(false)
            @if($product->inCart)
                <a href="{{ route('checkout') }}">
                    <button class="add-to-cart-btn product-in-basket">
                        <i class="fa fa-shopping-cart"></i>
                        Товар в корзине
                    </button>
                </a>
            @else
                <button class="add-to-cart-btn" onclick="addToCartSite(this, {{ $product->id }})">
                    <i class="fa fa-shopping-cart"></i>
                    Добавить в корзину
                </button>
            @endif
        @endif

    </div>
</div>
<!-- /product -->
