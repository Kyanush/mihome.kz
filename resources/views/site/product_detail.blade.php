@extends('layouts.site')

@section('title',      	$seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])
@section('og_image',    $product->getPhoto())


@section('content')

    @include('schemas.product', [
        'product'            => $product,
        'group_products'     => $group_products,
        'category'           => $category,
        'description_schema' => $seo['description']
    ])

@section('add_in_head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@stop

@include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])



<!-- SECTION -->
<div class="section" id="product-detail" >
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    <div class="product-preview">
                        <a data-fancybox="gallery" href="{{ $product->getPhoto() }}">
                            <img data-lazy="{{ $product->getPhoto() }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
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
                                    <img data-lazy="{{ $image->imagePath(true) }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
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
                        <img data-lazy="{{ $product->getPhoto() }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
                    </div>
                    @if(count($product->images) > 0)
                        @foreach($product->images as $image)
                            <div class="product-preview">
                                <img data-lazy="{{ $image->imagePath(true) }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
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



                    <span>


                            @php
                                $sku = $product->sku;
                                if(!$sku and $product->parent_id)
                                    $sku = $product->parent->sku;
                            @endphp
                        @if($sku)
                            <p>Модель: {{ $sku }} </p>
                        @endif





                        @if($product->description_short)
                            <p class="text-center">{!! $product->description_short !!}</p>
                        @endif

                        <div>
                                <div class="product-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa <?=(($product->reviews_rating_avg ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
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


                                @if(false)
                                @include('includes.timer')
                                @endif


                                <h3 class="product-price" style="
                                    color: #729f40;
                                    margin-left: 60px;
                                    font-size: 18px;
                                    border: 2px solid;
                                    padding: 5px 5px;
                                    float: right;
                                    font-weight: bold;
                                    display: none;
                                ">+ {{ $product->getReducedPrice() * 0.02 }} тг бонус</h3>


                                <span class="product-available">

                                      <p class="text-center {{ $product->status->class }}">
                                        {{ $product->status->name }}
                                      </p>

                                    @if($product->status_id != 10)
                                        <script>
                                            $(document).ready(function() {
                                                setTimeout(function() {
                                                    $('.callback-button').remove();
                                                    $('#back-call').remove();
                                                }, 1000);
                                            });
                                        </script>
                                        <p class="firm-red">При поступлении товара, цена может отличаться</p>
                                    @endif
                                </span>

                            </div>

                        @if(count($group_products) > 0)
                            <div class="product-options">
                                    <label>
                                        <select class="input select-redirect" id="select-model-product">
                                            <option value="{{ $product->parent_id ? $product->parent->detailUrlProduct() : '' }}">Выберите вариант</option>
                                            @foreach($group_products as $group_product)
                                                <option value="{{ $group_product->detailUrlProduct() }}" @if($product->id == $group_product->id) selected  @endif>
                                                    {{ $group_product->name }}
                                                    ({{ \App\Tools\Helpers::priceFormat($group_product->getReducedPrice()) }})
                                                    - {{ $group_product->status->name }}
                                                </option>
                                            @endforeach
                                       </select>
                                    </label>
                                </div>
                        @endif

                        @if($product->status_id == 10)
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


                        @if($product->status_id == 10)
                            <br/>
                            <ul class="add-to-cart">
                                    <li>
                                        <a class="cursor-pointer" id="buy-in-one-click">
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
                                                <label>Когда товар появится, мы вам тут же позвоним</label>
                                                <input class="form-control phone-mask"
                                                       type="text"
                                                       name="phone"
                                                       required
                                                       @auth value="{{ Auth::user()->phone }}" @endauth
                                                       placeholder="+7(777)777-77-77"/>
                                            </div>
                                            <button type="submit" class="btn btn-firm">
                                                <i class="fa fa-bell"></i>
                                                Предзаказ
                                            </button>
                                        </form>
                                    </div>
                            <br/>
                        @endif

                        </span>
                </div>
            </div>
            <!-- /Product details -->



            @if($group_products->isNotEmpty() and false)
                <div class="col-md-12">
                    <br/>
                    <h3 class="aside-title">Другие варианты</h3>
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
                    <h3 class="aside-title">С этим товаром покупают</h3>
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



        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

    @if($product->youtube)
        <div class="tab-content">
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
        </div>
    @endif

    <!-- Product tab -->
    <div id="product-tab">


        <!-- product tab nav -->
        <ul class="tab-nav">
            @if($product->description)
                <li class="active">
                    <a data-toggle="tab" href="#description">Описание</a>
                </li>
            @endif
            <li @if(!$product->description) class="active" @endif>
                <a @if(!$product->description) class="active" @endif data-toggle="tab" href="#attributes">Характеристики</a>
            </li>
            @if(false)
                <li>
                    <a data-toggle="tab" href="#reviews">Отзывы({{ $product->reviews_count }})</a>
                </li>
            @endif
        </ul>
        <!-- /product tab nav -->

        <!-- product tab content -->
        <div class="tab-content">
            @if($product->description)
                <div id="description" class="tab-pane fade in active">
                    <!-- container -->
                        <div class="container">
                            <div class="row">
                                {!! $product->description  !!}
                            </div>
                        </div>
                </div>
            @endif
            <div id="attributes" class="tab-pane fade in @if(!$product->description) active @endif">
                <div class="container">
                    <div class="row">
                        @if($product->specifications)
                            {!! $product->specifications !!}
                        @else
                            <table class="table table-bordered">
                                @foreach($product->attributes as $attribute)
                                    @if($attribute->show_product_detail == 1)
                                        @php
                                           $name = $attribute->pivot->name ? $attribute->pivot->name : $attribute->name
                                        @endphp
                                        <tr>
                                            @if($name)
                                                <td>
                                                    @if($attribute->description and $attribute->description != 'null')
                                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $attribute->description }}"></i>
                                                    @endif
                                                    {{ $attribute->pivot->name ? $attribute->pivot->name : $attribute->name }}
                                                </td>
                                                <td>
                                                    {{ $attribute->pivot->value }}
                                                </td>
                                            @else
                                                <td colspan="2">
                                                    {{ $attribute->pivot->value }}
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            @if(false)
            <div id="reviews" class="tab-pane fade in">
                <div class="container">
                    <div class="row">
                        @include('includes.reviews', ['product' => $product])
                    </div>
                </div>
            </div>
            @endif
        </div>





        @if(false)
            <h2 class="text-center tab-title">Отзывы({{$product->reviews_count}})</h2>
            <!-- reviews  -->
            <div id="reviews">
                <div class="row">
                    <!-- Rating -->
                    <div class="col-md-3">
                        <div id="rating">
                            <div class="rating-avg">
                                <span>{{ $product->reviews_rating_avg ?? 0 }}</span>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa <?=(($product->reviews_rating_avg ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
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
        @endif




    </div>
    <!-- /product tab content  -->

</div>
<!-- /SECTION -->




<!-- Modal -->
<div class="modal fade one-click-order" role="dialog" id="popup-buy-in-one-click">
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
                        <label>Введите номер телефона:</label>
                        <input @auth value="{{ Auth::user()->phone }}" @endauth type="text" name="phone" placeholder="+7 (___) ___-__-__" class="phone-mask form-control"/>
                    </div>
                    <div class="form-group">
                        <label>E-mail(не обязательно):</label>
                        <input @auth value="{{ Auth::user()->email }}" @endauth type="email" name="email" placeholder="E-mail" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Доставка:</label>
                        @php $carriers = \App\Models\Carrier::OrderBy('id')->get(); @endphp
                        <select name="carrier_id" class="form-control" onchange="carrier(this)">
                            @foreach($carriers as $carrier)
                                <option value="{{ $carrier->id }}" @if($carrier->id == 2) selected @endif>
                                    {{ $carrier->name }}
                                    @if($carrier->price > 0)
                                        - {{ \App\Tools\Helpers::priceFormat($carrier->price) }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="city" style="display: none">
                        <label>Адрес *:</label>
                        <input type="text" placeholder="Адрес *" class="form-control" name="city"/>
                    </div>

                    <div class="form-group" id="address" style="display: none">
                        <label>Город *:</label>
                        <input type="text" placeholder="Город *" class="form-control" name="address"/>
                    </div>

                    <div class="form-group">
                        <label>Комментарий к заказу:</label>
                        <textarea name="comment" placeholder="Комментарий к заказу" class="form-control"></textarea>
                    </div>

                    <script>
                        function carrier(self) {
                            display = 'block';
                            if(self.value == 2)
                                display = 'none';

                            $('#city').css('display', display);
                            $('#address').css('display', display);
                        }
                    </script>

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

<script src="{{ asset('/site/js/jquery.zoom.min.js') }}"></script>


@endsection
