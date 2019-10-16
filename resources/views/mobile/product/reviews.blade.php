@include('mobile.includes.space', ['style' => ''])

<div class="reviews">
    <div class="reviews__inner">

        <div class="reviews__rating container g-bb-fat">
            <div class="reviews__rating-heading">Рейтинг товара</div>
            <span class="reviews__rating-link">
                <span class="rating _big _{{ ($product->avgRating[0]->avg_rating ?? 0) * 2}}"></span>
                <span class="rating-count g-fl-r">
                    <span>{{ $product->reviews_count }}</span>&nbsp;отзывов
                </span>
            </span>
        </div>

        <?php $like = $_GET['like'] ?? -1;?>

        <div class="nav-tab reviews-nav container fixed-block g-pa0 g-bb-fat _with-topbar">
            <ul class="nav-tab__scroll reviews-nav__scroll _filter">
                <li class="nav-tab__scroll-el reviews-nav__scroll-el @if($like == -1) _active @endif">
                    <a href="{{ $product->detailUrlProduct() }}?view=reviews" class="nav-tab__scroll-link reviews-nav__scroll-link">Все сразу</a>
                </li>
                <li class="nav-tab__scroll-el reviews-nav__scroll-el @if($like == 1) _active @endif">
                    <a href="{{ $product->detailUrlProduct() }}?view=reviews&like=1" class="nav-tab__scroll-link reviews-nav__scroll-link">Положительные</a>
                </li>
                <li class="nav-tab__scroll-el reviews-nav__scroll-el @if($like == 0) _active @endif">
                    <a href="{{ $product->detailUrlProduct() }}?view=reviews&?like=0" class="nav-tab__scroll-link reviews-nav__scroll-link">Отрицательные</a>
                </li>
            </ul>
        </div>

        @include('mobile.includes.space', ['style' => 'height: 22.100vw;'])

        <div class="reviews__reviews-wrapper">
            @if($reviews->isEmpty())
                <p class="padding-4vw">Нет отзывы</p>
            @else
                @foreach($reviews as $review)
                    @if($like == -1)
                        @include('mobile.product.review_item', ['review' => $review, 'like_show' => true, 'review_text_class' => ''])
                    @elseif($review->rating >= 4 and $like == 1)
                        @include('mobile.product.review_item', ['review' => $review, 'like_show' => true, 'review_text_class' => ''])
                    @elseif($review->rating <= 3 and $like == 0)
                        @include('mobile.product.review_item', ['review' => $review, 'like_show' => true, 'review_text_class' => ''])
                    @endif
                @endforeach
            @endif
        </div>

    </div>
</div>

<a id="write-review" class="button _big-fixed button-sellers" data-product_id="{{ $product->id }}">
    Написать отзыв
</a>
