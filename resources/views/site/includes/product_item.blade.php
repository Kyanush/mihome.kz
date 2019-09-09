<!-- product -->
<div class="product">
    <div class="product-img">

        <a href="{{ $product->detailUrlProduct() }}">
            <img title="{{ $product->name }}"
                 alt="{{ $product->name }}"
                 src="{{ $product->pathPhoto(true) }}">
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
                <i class="fa <?=(($product->avgRating->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
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
        @if($product->inCart)
            <a href="{{ route('checkout') }}">
                <button class="add-to-cart-btn product-in-basket">
                    <i class="fa fa-shopping-cart"></i>
                    Товар в корзине
                </button>
            </a>
        @else
            @if($product->stock > 0)
                <button class="add-to-cart-btn" onclick="addToCartSite(this, {{ $product->id }})">
                    <i class="fa fa-shopping-cart"></i>
                    Добавить в корзину
                </button>
            @else
                <button class="add-to-cart-btn not-available" onclick="location.href = '{{ route('checkout') }}';">
                    <i class="fa fa-shopping-cart"></i>
                    Нет в наличии
                </button>
            @endif
        @endif
    </div>
</div>
<!-- /product -->