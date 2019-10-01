<div class="g-mb-gtn" itemscope itemtype="http://schema.org/Product">
    <div class="item container g-pa0 g-bb0">


        <div class="item__images">
            <div class="swiper-container" id="product-slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item__image-wrapper">
                            <img itemprop="image" alt="{{ $product->name }}" title="{{ $product->name }}" class="item__image" src="{{ $product->pathPhoto(true) }}"/>
                        </div>
                    </div>

                    @foreach($product->images as $image)
                        <div class="swiper-slide">
                            <div class="item__image-wrapper">
                                <img itemprop="image" alt="{{ $product->name }}" title="{{ $product->name }}" class="item__image" src="{{ $image->imagePath(true) }}"/>
                            </div>
                        </div>
                    @endforeach

                    @if($product->youtube)
                        <div class="swiper-slide">
                            <div class="item__image-wrapper _video play-icon">
                                <img class="item__image" src="https://i.ytimg.com/vi/{{ $product->youtube }}/mqdefault.jpg">
                            </div>
                        </div>
                    @endif

                </div>

                @if(count($product->images) > 0)
                    <div class="swiper-pagination"></div>
                @endif
            </div>


            <div class="item__control">
                @if($product->youtube)
                    <div class="item__control-button _video _show"onclick="productSliderZoom({{ $product->id }})" style="z-index: 1">
                        <i class="icon icon_video"></i>
                        <span>Видео</span>
                    </div>
                @else
                    <div class="item__control-button"></div>
                @endif
                <div class="item__control-button _zoom _show" onclick="productSliderZoom({{ $product->id }})" style="z-index: 1">
                    <span>Увеличить</span>
                    <i class="icon icon_zoom"></i>
                </div>
            </div>

            <div class="item__badges _left">
                @foreach($product->attributes as $attribute)
                    @if($attribute->id == 49 and $attribute->pivot->value)
                        @if($attribute->pivot->value == 'Хит')
                            <div class="hit"><img src="/mobile/images/sticker_hit.png"> Хит</div>
                        @elseif($attribute->pivot->value == 'New!')
                            <div class="new">New!</div>
                        @else
                            <div class="new">{{ $attribute->pivot->value }}</div>
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="item__badges _right">
                <div onclick="productFeaturesWishlist(this, {{ $product->id }})"
                     class="product_features_wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}"></div>
                <div onclick="productFeaturesCompare(this, {{ $product->id }})"
                     class="product_features_compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}"></div>
            </div>

        </div>

        <div class="item__info container">
            <h1 class="item__name" itemprop="name">
                {{ $product->name }}
            </h1>
            <a class="item__rating">
                <span class="rating _{{ ($product->avgRating->avg_rating ?? 0) * 2}}"></span>
                <span class="rating-count">(<span> {{ $product->reviews_count }}</span>&nbsp;отзывов)</span>
            </a>
            <div class="item__sku">Код товара:&nbsp;{{ $product->sku }}</div>
        </div>

        <div class="item__info container text-center">
            <button
                    type="button"
                    class="button _white"
                    onclick="buyIn1Click({{ $product->id }})">
                Купить в 1 клик
            </button>
        </div>

        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <div class="item__prices">
                <div class="item__debet">
                    <span class="item__prices-price">
                        @if($product->specificPrice)
                            <span class="price-old">
                                 {{ \App\Tools\Helpers::priceFormat($product->price) }}
                            </span>
                            &nbsp;
                        @endif
                        <span itemprop="price">
                            {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                        </span>
                        <span itemprop="priceCurrency" content="KZT"></span>
                        <link itemprop="availability" href="http://schema.org/InStock">
                    </span>
                </div>
                <!--
                <div class="item__instalment">
                    <span class="item__prices-title">В кредит</span>
                    <span class="item__prices-price">19 654 ₸</span>
                    <span class="item__add-info">х24 мес</span>
                </div>-->
            </div>
        </div>




    </div>


    <div class="mount-sellers-offers _short-list" id="sellers">
        <div class="sellers-offers _short-list">

            <div class="container-title">Поховые товары</div>
            <div class="_sellers-offers">
                <div class="container loan-selector g-bb-fat">
                    <div class="loan-selector__text-before">Цвет</div>
                    <div class="loan-selector__els g-fl-r ">
                        <div class="loan-selector__els-row">

                            @foreach($group_products as $group_product)
                                @foreach($group_product->attributes as $attribute)
                                    @if($attribute->id == 50 and $attribute->pivot->value)
                                        <a title="{{ $attribute->pivot->value . '-' . $group_product->name }}" class="loan-selector__el" href="{{ $group_product->detailUrlProduct() }}">

                                            @php
                                                $attributeValue = $attribute->values()->where(function ($query) use ($attribute){
                                                    $query->where('value', $attribute->pivot->value);
                                                    $query->orWhere('id',  $attribute->pivot->value);
                                                })->first();
                                            @endphp

                                            <div style="background: {{ $attributeValue->props ?? '#fff' }}"></div>
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach

                            @foreach($product->attributes as $attribute)
                                @if($attribute->id == 50 and $attribute->pivot->value)
                                        <a title="{{ $attribute->pivot->value . '-' . $product->name }}" class="loan-selector__el _active">

                                            @php
                                                $attributeValue = $attribute->values()->where(function ($query) use ($attribute){
                                                    $query->where('value', $attribute->pivot->value);
                                                    $query->orWhere('id',  $attribute->pivot->value);
                                                })->first();
                                            @endphp

                                            <div style="background: {{ $attributeValue->props ?? '#fff' }}"></div>
                                        </a>
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            @include('mobile.includes.product_slider', ['products' => $group_products,  'title' => 'Похожие товары', 'url' => ''])
            @include('mobile.includes.product_slider', ['products' => $products_interested, 'title' => 'С этим товаром покупаю', 'url' => ''])

            <div class="container-title">Характеристики</div>
            <div class="short-specifications container">
                <ul class="short-specifications__list">
                    @php $i = 1; @endphp
                    @foreach($product->attributes as $k => $attribute)

                        @if(empty($attribute->attribute_group_id) or empty($attribute->pivot->value) or $attribute->show_product_detail == 0)
                            @continue
                        @endif

                        <li class="short-specifications__list-el">{{ $attribute->name }}: {{ $attribute->pivot->value }};</li>
                        @if($i == 5)
                            @php break; @endphp
                        @endif
                        @php $i++; @endphp
                    @endforeach
                </ul>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=attributes" class="link-more _link-specifications">Подробнее</a>
            </div>









            <div class="container-title">Отзывы</div>
            <div class="reviews__rating container ">
                <div class="reviews__rating-heading">Рейтинг товара</div>
                <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="reviews__rating-link">
                    <span class="rating _big _{{ ($product->avgRating->avg_rating ?? 0) * 2}}"></span>
                    <span class="rating-count g-fl-r">
                        <span>{{ $product->reviews_count }}</span>&nbsp;
                        отзывов
                    </span>
                </a>
            </div>

            @if(count($product->reviews) == 0)
                <p class="padding-4vw">Нет отзывы</p>
            @else
                @foreach($product->reviews as $review)
                    @include('mobile.product.review_item', ['review' => $review, 'like_show' => false, 'review_text_class' => '_short'])
                @endforeach
            @endif

            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="link-more _link-reviews">
                    Еще {{ $product->reviews_count }}&nbsp;отзывов
                </a>
            </div>


            <div class="container-title">Описание</div>
            <div class="container">
                <div class="short-description" itemprop="description">
                    {!! strip_tags(\App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($product->description, 30))) !!}
                </div>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=descriptions" class="link-more _link-description">
                    Подробнее
                </a>
            </div>

            @include('mobile.includes.product_slider', ['products' => $youWatchedProducts,  'title' => 'Вы смотрели', 'url' => ''])

            <button type="button" class="button _big-fixed button-sellers" onclick="_addToCart({{ $product->id }})">
                Оформить заказ
            </button>

        </div>
    </div>
</div>
