@extends('layouts.site')


@section('title',    	 $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('og_title',    	  $seo['title'])
@section('og_description',   $seo['description'])
@section('og_image',    	  env('APP_URL') . $product->pathPhoto(true))

@section('content')

    @include('schemas.product', [
        'product'          => $product,
        'group_products'   => $group_products,
        'category'         => $category
    ])

    @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <img src="{{ $product->pathPhoto(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>

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
                                    <img src="{{ $image->imagePath(true) }}" title="{{ $seo['title'] }}" alt="{{ $seo['title'] }}"/>
                                    {!! $label !!}
                                </div>
                            @endforeach
                        @endif
                    </div>
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
                        <h1 class="product-name">
                            {{ $product->name }}
                        </h1>


                        <div>
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa <?=(($product->avgRating->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
                                @endfor
                            </div>
                            <a class="review-link" onclick="writeReviewShow()">
                                {{ $product->reviews_count }} {{ $product->reviews_count > 1 ? 'отзывов' : 'отзыв' }} | Написать отзыв
                            </a>
                        </div>
                        <div>
                            <h3 class="product-price">
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
                        <p>
                            <a href="{{ route('delivery_payment') }}">Доставка по всему казахстану </a> от 1000 тг до 3000 тг.
                            По городам <a href="{{ route('delivery_payment') }}"> Казахстана</a>, работаем с курьерской компанией "Алем-Тат", срок доставки 3-4 рабочих дня.
                        </p>

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
                                        <button class="add-to-cart-btn product-in-basket">
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
                                    <i class="fa fa-heart-o"></i> закладку
                                </a>
                            </li>
                            <li>
                                <a class="{{ $product->oneProductFeaturesCompare  ? 'active' : '' }}" onclick="productFeaturesCompare(this, {{ $product->id }})">
                                    <i class="fa fa-exchange"></i> сравнить
                                </a>
                            </li>
                        </ul>

                        <ul class="product-links">
                            <li>Категория:</li>
                            <li><a href="/catalog/{{ $category->url }}">{{ $category->name }}</a></li>
                        </ul>

                        <ul class="product-links">
                            <li>поделиться:</li>
                            <li>
                                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                <script src="//yastatic.net/share2/share.js"></script>
                                <div class="ya-share2" data-services="vkontakte,facebook,whatsapp,telegram"></div>
                            </li>
                        </ul>

                        @if($product->stock > 0)
                            <br/>
                            <ul class="add-to-cart">
                                <button class="add-to-cart-btn" onclick="modalShow('.one-click-order')">
                                    <i class="fa fa-shopping-cart"></i>
                                    Купить в 1 клик
                                </button>
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
                        @endif

                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active">
                                <a data-toggle="tab" href="#description">Описание</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#attributes">Характеристики</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#reviews">Отзывы({{$product->reviews_count}})</a>
                            </li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">

                            <!-- description  -->
                            <div id="description" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! $product->description  !!}
                                    </div>
                                </div>
                            </div>
                            <!-- /description  -->

                            <!-- attributes  -->
                            <div id="attributes" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php $attributes = [];?>
                                        @foreach($product->attributes as $attribute)
                                            @if(empty($attribute->attribute_group_id) or empty($attribute->pivot->value))
                                                @continue
                                            @endif
                                            <?php $attributes[$attribute->attribute_group_id][] = $attribute;?>
                                        @endforeach

                                        @foreach(App\Models\AttributeGroup::OrderBy('sort')->get() as $attributeGroup)
                                            @if(!isset($attributes[$attributeGroup->id]))
                                                @continue
                                            @endif
                                            <br/>
                                            <p><b>{{ $attributeGroup->name }}</b></p>
                                            <ul>
                                                @foreach($attributes[$attributeGroup->id] as $attribute)
                                                    @if(empty($attribute->pivot->value))
                                                        @continue
                                                    @endif
                                                    <li><b>{{ $attribute->name }}:</b> {{ $attribute->pivot->value }}</li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /attributes  -->

                            <!-- reviews  -->
                            <div id="reviews" class="tab-pane fade in">
                                <div class="row">
                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>{{ $product->avgRating->avg_rating ?? 0 }}</span>
                                                <div class="rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa <?=(($product->avgRating->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <!--
                                            <ul class="rating">
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 80%;"></div>
                                                    </div>
                                                    <span class="sum">3</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 60%;"></div>
                                                    </div>
                                                    <span class="sum">2</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div></div>
                                                    </div>
                                                    <span class="sum">0</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div></div>
                                                    </div>
                                                    <span class="sum">0</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div></div>
                                                    </div>
                                                    <span class="sum">0</span>
                                                </li>
                                            </ul>
                                            --->
                                        </div>
                                    </div>
                                    <!-- /Rating -->

                                    <!-- Reviews -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            @if(count($product->reviews) == 0)
                                                <p>Нет отзывы</p>
                                            @else
                                                <ul class="reviews">
                                                    @foreach($product->reviews as $review)
                                                        <li>
                                                            <div class="review-heading">
                                                                <h5 class="name">{{ $review->name }}</h5>
                                                                <p class="date">{{ \App\Tools\Helpers::ruDateFormat($review->created_at) }}</p>
                                                                <div class="review-rating">
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star-o empty"></i>
                                                                </div>
                                                            </div>
                                                            <div class="review-body">
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
                                        <!---
                                            <ul class="reviews-pagination">
                                                <li class="active">1</li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                            </ul>
                                            --->
                                        </div>
                                    </div>
                                    <!-- /Reviews -->

                                    <!-- Review Form -->
                                    <div class="col-md-3">
                                        <div id="review-form">
                                            <form class="review-form" action="javascript:void(null);" onsubmit="writeReview(this); return false;" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                                <input
                                                    class="input"
                                                    name="name"
                                                    placeholder="Введите имя *"
                                                    @auth
                                                    value="{{ Auth::user()->name }}"
                                                    @endauth
                                                    type="text"/>
                                                <input
                                                    class="input"
                                                    name="email"
                                                    placeholder="Введите e-mail *"
                                                    @auth
                                                    value="{{ Auth::user()->email }}"
                                                    @endauth
                                                    type="text"/>
                                                <textarea class="input" name="plus" placeholder="Что вам понравилось"></textarea>
                                                <textarea class="input" name="minus" placeholder="Опишите недостатки"></textarea>
                                                <textarea class="input" name="comment" placeholder="Введите комментарий *"></textarea>
                                                <div class="input-rating">
                                                    <span>Оценка: </span>
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
                        </div>
                        <!-- /product tab content  -->
                    </div>
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
