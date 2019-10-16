@extends('layouts.site')

@section('title',    	$seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])
@section('og_image',    env('APP_URL') . $product->pathPhoto(true))

@section('content')

    @include('schemas.product', [
        'product'          => $product,
        'group_products'   => $group_products,
        'category'         => $category
    ])

    @section('add_in_head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
        <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    @stop

    @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- SECTION -->
    <div class="section" id="product-detail" itemtype="http://schema.org/Product" itemscope>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <a data-fancybox="gallery" href="{{ $product->pathPhoto(true) }}">
                                <img itemprop="image" src="{{ $product->pathPhoto(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>
                            </a>

                            <?php ob_start();?>
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
                            <?php
                            $label = ob_get_contents();
                            ob_end_clean();
                            ?>
                            {!! $label !!}
                        </div>
                        @if(count($product->images) > 0)
                            @foreach($product->images as $image)
                                <div class="product-preview">
                                    <a data-fancybox="gallery" href="{{ $image->imagePath(true) }}">
                                        <img itemprop="image" src="{{ $image->imagePath(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>
                                    </a>
                                    {!! $label !!}
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <p class="zoom-txt">Чтобы увеличить, нажмите на картинку</p>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        <div class="product-preview">
                            <img src="{{ $product->pathPhoto(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>
                        </div>
                        @if(count($product->images) > 0)
                            @foreach($product->images as $image)
                                <div class="product-preview">
                                    <img src="{{ $image->imagePath(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h1 class="product-name" itemprop="name" >
                            {{ $product->name }}
                        </h1>
                        <meta itemprop="mpn" content="{{ $product->sku }}" />
                        <meta itemprop="sku" content="{{ $product->sku }}" />
                        <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
                            <meta itemprop="name" content="{{ $category->name }}" />
                        </div>

                        @if(intval($product->avgRating[0]->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
                            <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                                <meta itemprop="reviewCount" content="{{ $product->reviews_count }}" />
                                <meta itemprop="ratingValue" content="{{ intval($product->avgRating[0]->avg_rating ?? 0) }}" />
                            </div>
                        @endif

                        <span itemprop="offers" itemtype="http://schema.org/Offer" itemscope>

                            <link itemprop="url" href="{{ $product->detailUrlProduct() }}" />
                            @if($product->stock > 0)
                                <meta itemprop="availability"  content="https://schema.org/InStock" />
                                <meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
                            @else
                                <meta itemprop="availability" content="https://schema.org/OutOfStock" />
                            @endif
                            <meta itemprop="priceCurrency" content="KZT" />
                            <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
                            @php
                                $specificPrice = $product->specificPrice(function ($query){
                                                              $query->DateActive();
                                                         })
                                                         ->first();
                            @endphp
                            @if($specificPrice)
                                @if($specificPrice->expiration_date)
                                    <meta itemprop="priceValidUntil" content="{{ date('Y-m-d', strtotime($specificPrice->expiration_date)) }}" />
                                @else
                                    <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
                                @endif
                            @else
                                <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
                            @endif
                            <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                                <meta itemprop="name" content="{{ env('APP_NAME') }}" />
                            </div>



                            <div>
                                <div class="product-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa <?=(($product->avgRating[0]->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
                                    @endfor
                                </div>
                                <a class="review-link" onclick="writeReviewShow()">
                                    {{ $product->reviews_count }} {{ $product->reviews_count > 1 ? 'отзывов' : 'отзыв' }} | Написать отзыв
                                </a>
                            </div>
                            <div>
                                <h3 class="product-price" itemprop="price" content="{{ $product->getReducedPrice() }}">
                                    {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                                    @if($product->specificPrice)
                                        <del class="product-old-price">
                                            {{ \App\Tools\Helpers::priceFormat($product->price) }}
                                        </del>
                                    @endif
                                </h3>
                                @if($product->stock > 0)
                                    <span class="product-available">
                                        <i class="fa fa-check"></i> В наличии
                                    </span>
                                @else
                                    <span class="product-no-available">
                                        <i class="fa fa-close"></i> Товар отсутствует
                                    </span>
                                    <p class="firm-red">При поступлении товара, цена может отличаться</p>
                                @endif
                            </div>




                            <div class="product-options">
                                <label>Цвет:</label>
                                <label>
                                    @foreach($product->attributes as $attribute)
                                        @if($attribute->id == 50 and $attribute->pivot->value)
                                            @php
                                                $attributeValue = $attribute->values()->where(function ($query) use ($attribute){
                                                    $query->where('value', $attribute->pivot->value);
                                                    $query->orWhere('id',  $attribute->pivot->value);
                                                })->first();
                                            @endphp
                                            @if($attributeValue)
                                                <a title="{{ $attributeValue->value }}"
                                                   class="color"
                                                   style="background-color: {{ $attributeValue->props ?? '#fff' }}"></a>
                                            @endif
                                        @endif
                                    @endforeach
                                    @foreach($group_products as $group_product)
                                        @foreach($group_product->attributes as $attribute)
                                            @if($attribute->id == 50 and $attribute->pivot->value)
                                                @php
                                                    $attributeValue = $attribute->values()->where(function ($query) use ($attribute){
                                                        $query->where('value', $attribute->pivot->value);
                                                        $query->orWhere('id',  $attribute->pivot->value);
                                                    })->first();
                                                @endphp
                                                <a style="background-color: {{ $attributeValue->props ?? '#fff' }}"
                                                   title="{{ $attribute->pivot->value }} - {{ $group_product->name }}"
                                                   class="color"
                                                   href="{{ $group_product->detailUrlProduct() }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </label>
                                <label>Артикул: {{ $product->sku }}</label>
                            </div>

                            @if($product->stock > 0)
                                <div class="add-to-cart">
                                    <div class="qty-label">
                                        <div class="input-number">
                                            <input type="number" value="1" id="quantity"/>
                                            <span class="qty-up">+</span>
                                            <span class="qty-down">-</span>
                                        </div>
                                    </div>
                                    @if($product->inCart)
                                        <a href="{{ route('checkout') }}">
                                            <button class="add-to-cart-btn product-in-basket1">
                                                <i class="fa fa-shopping-cart"></i>
                                                Товар в корзине
                                            </button>
                                        </a>
                                    @else
                                        <button class="add-to-cart-btn" onclick="addToCartSite(this, {{ $product->id }}, $('#quantity').val())">
                                            <i class="fa fa-shopping-cart"></i>
                                            Добавить в корзину
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <ul class="product-btns">
                                <li>
                                    <a class="{{ $product->oneProductFeaturesWishlist ? 'active' : '' }}" onclick="productFeaturesWishlist(this, {{ $product->id }})">
                                        <i class="fa fa-heart-o"></i> Закладку
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ $product->oneProductFeaturesCompare  ? 'active' : '' }}" onclick="productFeaturesCompare(this, {{ $product->id }})">
                                        <i class="fa fa-exchange"></i> Сравнить
                                    </a>
                                </li>
                            </ul>

                            <ul class="product-links">
                                <li>Категория:</li>
                                <li><a href="/catalog/{{ $category->url }}">{{ $category->name }}</a></li>
                            </ul>

                            <ul class="product-links">
                                <li>Поделиться:</li>
                                <li>
                                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                    <script src="//yastatic.net/share2/share.js"></script>
                                    <div class="ya-share2" data-services="vkontakte,facebook,whatsapp,telegram"></div>
                                </li>
                            </ul>

                            @if($product->stock > 0)
                                <br/>
                                <ul class="add-to-cart">
                                    <li>
                                        <a class="cursor-pointer" onclick="modalShow('.one-click-order')">
                                            <i class="fa fa-shopping-cart"></i>
                                            Купить в 1 клик
                                        </a>
                                        &nbsp; &nbsp;
                                        <a title="Пишите на WhatsApp" target="_blank" href="https://api.whatsapp.com/send?phone=77075162636&text=Я заинтересован в покупке {{ $product->name }}, Подробнее: {{ $product->detailUrlProduct() }}">
                                            <i class="fa fa-whatsapp"></i>
                                            Пишите на WhatsApp
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <div class="product-links">
                                    <form action="javascript:void(null);" onsubmit="subscribe(this); return false;" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="form-group">
                                            <label>Оставьте электронную почту, чтобы узнать о поступлении товара</label>
                                            <input class="form-control"
                                                   type="text"
                                                   name="email"
                                                   @auth value="{{ Auth::user()->email }}" @endauth
                                                   placeholder="Ваша электронная почта"/>
                                        </div>
                                        <button type="submit" class="btn btn-firm">
                                            <i class="fa fa-bell"></i>
                                            Подписаться
                                        </button>
                                    </form>
                                </div>
                                <br/>
                            @endif
                        </span>
                    </div>
                </div>
                <!-- /Product details -->


                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <td>
                                <p><i class="fa fa-truck firm-red2"  style="font-size: 20px;"></i> Доставка</p>
                                <p>Курьером по Алматы <b>бесплатно</b></p>
                                <p>Отправка по Казахстану <a href="{{ route('delivery_payment') }}">подробнее</a></p>
                            </td>
                            <td>
                                <p>
                                    <i class="fa fa-car firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                                    Самовывоз
                                </p>
                                <p>Магазины в <b>Алматы</b> <a href="{{ route('contact') }}">подробнее</a></p>
                            </td>
                            <td>
                                <p>
                                    <i class="fa fa-check firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                                    Гарантия и возврат
                                </p>
                                <p>
                                    Гарантия 12 мес <a href="{{ route('guaranty') }}">подробнее</a>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <i class="fa fa-credit-card firm-red2" aria-hidden="true"  style="font-size: 20px;"></i>
                                    Оплата
                                </p>
                                <p>Наличными или картой</p>
                            </td>
                        </tr>
                    </table>
                </div>

                @if($group_products->isNotEmpty())
                    <div class="col-md-12">
                        <br/>
                        <h3 class="aside-title">Похожие товары</h3>
                        <br/>
                        <div class="row">
                            @foreach($group_products as $product_item)
                                <div class="col-md-4">
                                    @include('site.includes.product-widget', ['product' => $product_item])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($products_interested->isNotEmpty())
                    <div class="col-md-12">
                        <br/>
                        <h3 class="aside-title">С этим товаром покупаю</h3>
                        <br/>
                        <div class="row">
                            @foreach($products_interested as $product_item)
                                <div class="col-md-4">
                                    @include('site.includes.product-widget', ['product' => $product_item])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif



                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                            <span itemprop="description">
                                @if($product->description)
                                    <h2 class="text-center tab-title">Описание</h2>
                                    <!-- description  -->
                                    <div id="description">
                                        {!! $product->description  !!}
                                    </div>
                                    <div class="show-full">
                                        <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                        Показать полностью
                                    </div>
                                    <!-- /description  -->
                                @endif

                                @php
                                    $attributes = [];
                                    foreach($product->attributes as $attribute)
                                    {
                                        if(empty($attribute->pivot->value) or $attribute->show_product_detail == 0)
                                            continue;
                                        $attributes[ (int)$attribute->attribute_group_id ][] = $attribute;
                                    }
                                @endphp
                                @if(count($attributes) > 0)
                                    <h2 class="text-center tab-title">Характеристики</h2>
                                    <!-- attributes  -->
                                    <div id="attributes">
                                            <table class="table table-bordered">
                                                @foreach(App\Models\AttributeGroup::OrderBy('sort')->get() as $attributeGroup)
                                                    @if(!isset($attributes[$attributeGroup->id]))
                                                        @continue
                                                    @endif
                                                        <tr>
                                                            <td colspan="2">
                                                                <b>{{ $attributeGroup->name }}</b>
                                                            </td>
                                                        </tr>
                                                        @foreach($attributes[$attributeGroup->id] as $attribute)
                                                            <tr>
                                                                <td>
                                                                    @if($attribute->description)
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $attribute->description }}"></i>
                                                                    @endif
                                                                    {{ $attribute->name }}:
                                                                </td>
                                                                <td>
                                                                    {{ $attribute->pivot->value }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @unset($attributes[$attributeGroup->id])
                                                @endforeach

                                                @if(count($attributes) > 0)
                                                    <tr>
                                                        <td colspan="2">
                                                            <b>Другие</b>
                                                        </td>
                                                    </tr>
                                                    @foreach($attributes as $attribute_items)
                                                        @foreach($attribute_items as $attribute)
                                                            <tr>
                                                                <td>
                                                                    @if($attribute->description)
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $attribute->description }}"></i>
                                                                    @endif
                                                                    {{ $attribute->name }}:
                                                                </td>
                                                                <td>
                                                                    {{ $attribute->pivot->value }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </table>

                                    </div>
                                    <!-- /attributes  -->
                                @endif
                            </span>

                            <h2 class="text-center tab-title">Отзывы({{$product->reviews_count}})</h2>
                            <!-- reviews  -->
                            <div id="reviews">
                                <div class="row">
                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>{{ $product->avgRating[0]->avg_rating ?? 0 }}</span>
                                                <div class="rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa <?=(($product->avgRating[0]->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <ul class="rating">
                                                @php
                                                    $total_all = collect($ratings_groups)->sum('total');
                                                @endphp
                                                @foreach($ratings_groups as $rating_group)
                                                    <li>
                                                        <div class="rating-stars">
                                                            <i class="fa {{ $rating_group->rating < 1 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                            <i class="fa {{ $rating_group->rating < 2 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                            <i class="fa {{ $rating_group->rating < 3 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                            <i class="fa {{ $rating_group->rating < 4 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                            <i class="fa {{ $rating_group->rating < 5 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                        </div>
                                                        <div class="rating-progress">
                                                            <div style="width: {{ ($rating_group->total / $total_all) * 100 }}%;"></div>
                                                        </div>
                                                        <span class="sum">{{ $rating_group->total }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Rating -->

                                    <!-- Reviews -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            @if($reviews->isEmpty())
                                                <p>Нет отзывы</p>
                                            @else
                                                <ul class="reviews">
                                                    @foreach($reviews as $review)
                                                        <li itemprop="review" itemtype="http://schema.org/Review" itemscope>
                                                            <div class="review-heading">

                                                                <div itemprop="author" itemtype="http://schema.org/Person" itemscope>
                                                                    <h5 class="name" itemprop="name">{{ $review->name }}</h5>
                                                                </div>
                                                                <p class="date" itemprop="datePublished" content="{{ date('Y-m-d', strtotime($review->created_at)) }}">
                                                                    {{ \App\Tools\Helpers::ruDateFormat($review->created_at) }}
                                                                </p>
                                                                <div class="review-rating">
                                                                    <i class="fa {{ $review->rating < 1 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                                    <i class="fa {{ $review->rating < 2 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                                    <i class="fa {{ $review->rating < 3 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                                    <i class="fa {{ $review->rating < 4 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                                    <i class="fa {{ $review->rating < 5 ? 'fa-star-o empty' : 'fa-star' }}"></i>
                                                                </div>
                                                                <div itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
                                                                    <meta itemprop="ratingValue" content="{{ $review->rating }}" />
                                                                    <meta itemprop="bestRating"  content="5" />
                                                                    <meta itemprop="worstRating" content="1" />
                                                                </div>
                                                            </div>
                                                            <div class="review-body">
                                                                <span itemprop="reviewBody">
                                                                    @if($review->plus)
                                                                        <p>
                                                                            <b>Достоинства</b>
                                                                            <br/>
                                                                            {{ $review->plus }}
                                                                        </p>
                                                                    @endif
                                                                    @if($review->minus)
                                                                        <p>
                                                                            <b>Недостатки</b>
                                                                            <br/>
                                                                            {{ $review->minus }}
                                                                        </p>
                                                                    @endif
                                                                    @if($review->comment)
                                                                        <p>
                                                                            <b>Комментарий</b>
                                                                            <br/>
                                                                            {{ $review->comment }}
                                                                        </p>
                                                                    @endif
                                                                </span>

                                                                <div class="review-like" id="review_{{ $review->id }}">
                                                                    <b>Вам понравился отзыв?</b>
                                                                    <span class="review_plus
                                                                        @if(isset($review->isLike->like))
                                                                    @if($review->isLike->like == 1) active @endif
                                                                    @endif" review_id="{{ $review->id }}">
                                                                        <i class="fa fa-thumbs-up"></i>
                                                                        <span class="review_number">{{ $review->likes_count ?? 0 }}</span>
                                                                    </span>
                                                                    <span class="review_minus
                                                                        @if(isset($review->isLike->like))
                                                                    @if($review->isLike->like == 0) active @endif
                                                                    @endif" review_id="{{ $review->id }}">
                                                                        <i class="fa fa-thumbs-down "></i>
                                                                        <span class="review_number">{{ $review->dis_likes_count ?? 0 }}</span>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                        @endif


                                            @if($reviews->isNotEmpty())
                                                {!! $reviews->links("pagination::default", ['class' => 'reviews-pagination']) !!}
                                            @endif


                                        </div>
                                    </div>
                                    <!-- /Reviews -->

                                    <!-- Review Form -->
                                    <div class="col-md-3">
                                        <div id="review-form">
                                            <form class="review-form" action="javascript:void(null);" onsubmit="writeReview(this); return false;" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                                <input  class="input" name="name" placeholder="Введите имя *" @auth value="{{ Auth::user()->name }}" @endauth type="text"/>
                                                <input  class="input" name="email" placeholder="Введите e-mail" @auth value="{{ Auth::user()->email }}" @endauth type="text"/>
                                                <textarea class="input" name="plus" placeholder="Что вам понравилось"></textarea>
                                                <textarea class="input" name="minus" placeholder="Опишите недостатки"></textarea>
                                                <textarea class="input" name="comment" placeholder="Введите комментарий *"></textarea>
                                                <div class="input-rating">
                                                    <span>Оценка *: </span>
                                                    <div class="stars">
                                                        <input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
                                                        <input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
                                                        <input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
                                                        <input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
                                                        <input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
                                                    </div>
                                                </div>
                                                <button class="primary-btn" type="submit">
                                                    <img class="ajax-loader" src="/site/images/ajax-loader.gif"/>
                                                    Отправить отзыв
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /Review Form -->
                                </div>
                            </div>
                            <!-- /reviews  -->

                            @if($product->youtube)
                                <h2 class="text-center tab-title">Видео обзор</h2>
                                <div class="text-center">
                                    <iframe
                                        frameborder="0"
                                        allowfullscreen="1"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        title="YouTube video player"
                                        width="640"
                                        height="360"
                                        src="https://www.youtube.com/embed/{{ $product->youtube }}?rel=0&amp;enablejsapi=1&amp;origin=https%3A%2F%2Fkaspi.kz&amp;widgetid=1">
                                    </iframe>
                                </div>
                            @endif

                        </div>
                        <!-- /product tab content  -->
                </div>
                <!-- /product tab -->

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    @include('site.includes.product_slider', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])



    <!-- Modal -->
    <div class="modal fade one-click-order" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        Быстрый заказ
                    </h4>
                </div>
                <form action="javascript:void(null);" onsubmit="oneClickOrder(this); return false;" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Имя:</label>
                            <input @auth value="{{ Auth::user()->name }}" @endauth type="text" name="name" placeholder="Имя" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>E-mail:</label>
                            <input @auth value="{{ Auth::user()->email }}" @endauth type="email" name="email" placeholder="E-mail" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Введите номер телефона:</label>
                            <input @auth value="{{ Auth::user()->phone }}" @endauth type="text" name="phone" placeholder="+7 (___) ___-__-__" class="phone-mask form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-firm">
                            <img class="ajax-loader" src="/site/images/ajax-loader.gif"/>
                            Заказать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
