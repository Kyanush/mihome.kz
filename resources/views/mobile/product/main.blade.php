<div class="g-mb-gtn" itemscope itemtype="http://schema.org/Product">

    <div class="item container g-pa0 g-bb0">

        <div class="item__images">
            <div class="swiper-container" id="product-slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item__image-wrapper">
                            <img
                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                    itemprop="image"
                                    alt="{{ $product->name }}"
                                    title="{{ $product->name }}"
                                    class="item__image  swiper-lazy"
                                    data-src="{{ $product->pathPhoto(true) }}"/>
                            <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        </div>
                    </div>

                    @foreach($product->images as $image)
                        <div class="swiper-slide">
                            <div class="item__image-wrapper">
                                <img
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        itemprop="image" alt="{{ $product->name }}"
                                        title="{{ $product->name }}"
                                        class="item__image  swiper-lazy"
                                        data-src="{{ $image->imagePath(true) }}"/>
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                        </div>
                    @endforeach

                    @if($product->youtube)
                        <div class="swiper-slide">
                            <div class="item__image-wrapper _video play-icon">
                                <img
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        class="item__image  swiper-lazy"
                                        data-src="https://i.ytimg.com/vi/{{ $product->youtube }}/mqdefault.jpg"/>
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
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
                <span class="rating _{{ ($product->reviews_rating_avg ?? 0) * 2}}"></span>
                <span class="rating-count">(<span> {{ $product->reviews_count }}</span>&nbsp;отзывов)</span>
            </a>

            @php
                $sku = $product->sku;
                if(!$sku and $product->parent_id)
                    $sku = $product->parent->sku;
            @endphp
            @if($sku)
                <div class="item__sku">Модель:&nbsp;{{ $sku }}</div>
            @endif

        </div>

        <div class="item__info container" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
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

                <div class="item__instalment">
                    @if($product->stock > 0)
                        <span class="item__prices-title">В наличии</span>
                        <span class="item__prices-price"><i class="fa fa-check"></i></span>
                    @else
                        <span class="item__prices-title">Нет в наличии</span>
                        <span class="item__prices-price"><i class="fa fa-close"></i></span>
                        <span class="item__add-info">При поступлении товара, цена может отличаться</span>
                    @endif
                </div>
                <!--
                <div class="item__instalment">
                    <span class="item__prices-title">В кредит</span>
                    <span class="item__prices-price">19 654 ₸</span>
                    <span class="item__add-info">х24 мес</span>
                </div>-->
            </div>
        </div>


        @if(count($group_products) > 0)
            <div class="item__info container">
                <select class="select-redirect" id="select-model-product">
                    <option value="{{ $product->parent_id ? $product->parent->detailUrlProduct() : '' }}">Выберите вариант</option>
                    @foreach($group_products as $group_product)
                        <option value="{{ $group_product->detailUrlProduct() }}" @if($product->id == $group_product->id) selected @endif>
                            {{ $group_product->name }}
                            -
                            {{ \App\Tools\Helpers::priceFormat($group_product->getReducedPrice()) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif


        <div class="item__info container text-center">
            @if($product->stock > 0)
                <button
                    style="padding: 1.867vw 2vw;"
                    type="button"
                    class="button _white"
                    onclick="buyIn1Click({{ $product->id }})">
                    {{ $product->stock > 0 ? 'Купить в 1 клик' : 'Быстрый предзаказ' }}
                </button>
                &nbsp;
                <a style="padding: 1.867vw 2vw;"
                   class="button _white"
                   title="Пишите на WhatsApp"
                   target="_blank"
                   href="https://api.whatsapp.com/send?phone=77075162636&text=Я заинтересован в покупке {{ $product->name }}{{ $product->stock > 0 ? '' : '(Оформить предзаказ)' }}, Подробнее: {{ $product->detailUrlProduct() }}">
                    <i class="fa fa-whatsapp"></i>
                    Пишите на WhatsApp
                </a>
            @else
                    <form action="javascript:void(null);" onsubmit="subscribe(this); return false;" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <p>Оставьте электронную почту, чтобы узнать о поступлении товара</p>
                        <p>
                            <input class="search__input"
                                   type="text"
                                   name="email"
                                   @auth value="{{ Auth::user()->email }}" @endauth
                                   placeholder="Ваша электронная почта"/>
                        </p>
                        <p>
                            <button type="submit" class="button">
                                <i class="fa fa-bell"></i>
                                Подписаться
                            </button>
                        </p>
                    </form>
            @endif
        </div>

        <div class="item__info container">
            <h2 style="color: #3c92c3;">
                <i class="fa fa-truck firm-red2"  style="font-size: 20px;"></i> Доставка
            </h2>
            <ul class="short-specifications__list">
                <li class="short-specifications__list-el">
                    Курьером по Алматы <b>бесплатно</b>
                </li>
                <li class="short-specifications__list-el">
                    Отправка по Казахстану <a href="{{ route('delivery_payment') }}">подробнее</a>
                </li>
            </ul>


            <h2 style="color: #3c92c3;">
                <i class="fa fa-car firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                Самовывоз
            </h2>
            <ul class="short-specifications__list">
                <li class="short-specifications__list-el">
                    Магазины в <b>Алматы</b> <a href="{{ route('contact') }}">подробнее</a>
                </li>
            </ul>


            <h2 style="color: #3c92c3;">
                <i class="fa fa-check firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                Гарантия и возврат
            </h2>
            <ul class="short-specifications__list">
                <li class="short-specifications__list-el">
                    Гарантия 12 мес <a href="{{ route('guaranty') }}">подробнее</a>
                </li>
            </ul>


            <h2 style="color: #3c92c3;">
                <i class="fa fa-credit-card firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                Оплата
            </h2>
            <ul class="short-specifications__list">
                <li class="short-specifications__list-el">
                    Наличными или картой
                </li>
            </ul>
        </div>

    </div>


    <div class="mount-sellers-offers _short-list" id="sellers">
        <div class="sellers-offers _short-list">

            @include('mobile.includes.product_slider', ['products' => $products_interested, 'title' => 'С этим товаром покупают', 'url' => ''])

            <div class="container-title">Характеристики</div>
            <div class="short-specifications container">
                <ul class="short-specifications__list">
                    @php $i = 1; @endphp
                    @foreach($product->attributes as $k => $attribute)
                       @if($attribute->show_product_detail == 1)
                            <li class="short-specifications__list-el">
                                {{ $attribute->pivot->name ? $attribute->pivot->name : $attribute->name }}: {{ $attribute->pivot->value }};
                            </li>
                            @if($i == 5)
                                @php break; @endphp
                            @endif
                            @php $i++; @endphp
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=attributes" class="link-more _link-specifications">Подробнее</a>
            </div>













            @if(false)
                <div class="reviews__rating container ">
                    <div class="reviews__rating-heading">Рейтинг товара</div>
                    <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="reviews__rating-link">
                        <span class="rating _big _{{ ($product->reviews_rating_avg ?? 0) * 2}}"></span>
                        <span class="rating-count g-fl-r">
                            <span>{{ $product->reviews_count }}</span>&nbsp;
                            отзывов
                        </span>
                    </a>
                </div>

                @if($reviews->isEmpty())
                    <p class="padding-4vw">Нет отзывы</p>
                @else
                    @foreach($reviews as $review)
                        @include('mobile.product.review_item', ['review' => $review, 'like_show' => false, 'review_text_class' => '_short'])
                    @endforeach
                @endif

                <div class="container g-pa0 g-bb-fat">
                    <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="link-more _link-reviews">
                        Еще {{ $product->reviews_count }}&nbsp;отзывов
                    </a>
                </div>
            @endif


            <div class="container-title">Описание</div>
            <div class="container">
                <div class="short-description" itemprop="description">
                    {!! strip_tags(\App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($product->description, 60))) !!}
                </div>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=descriptions" class="link-more _link-description">
                    Подробнее
                </a>
            </div>


            <div class="container-title">Отзывы</div>
            <div class="container">
                <div type="lis-comments"
                     lis-widget="reviews"
                     data-id="{{    $product->parent_id ? $product->parent_id    : $product->id }}"
                     data-title="{{ $product->parent_id ? $product->parent->name : $product->name }}">
                </div>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="link-more _link-reviews">
                    Еще отзывов
                </a>
            </div>


            @if($product->stock > 0)
                <button type="button" class="button _big-fixed button-sellers" onclick="_addToCart({{ $product->id }})">
                    Оформить заказ
                </button>
            @endif

        </div>
    </div>
</div>
