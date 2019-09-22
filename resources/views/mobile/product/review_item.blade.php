<div class="reviews__review">
    <div class="reviews__review-meta">
        <div class="rating _{{ ($review->rating ?? 0) * 2 }}"></div>
        <div class="reviews__author">
            {{ $review->name }}
        </div>
        <time class="reviews__date">
            {{ \App\Tools\Helpers::ruDateFormat($review->created_at) }}
        </time>
    </div>
    @if($review->plus)
        <div class="revews__review-text {{ $review_text_class }}">
            <b>Достоинства:&nbsp;</b> {{ $review->plus }}
        </div>
    @endif
    @if($review->minus)
        <div class="revews__review-text {{ $review_text_class }}">
            <b>Недостатки:&nbsp;</b> {{ $review->minus }}
        </div>
    @endif
    <div class="revews__review-text {{ $review_text_class }}">
        <b>Комментарий:&nbsp;</b> {{ $review->comment }}
        @if($like_show)
            <footer class="reviews__like-rating">
                <div class="reviews__review-form">
                    <div class="reviews__review-state">
                        <div class="reviews__review-rating">
                            <span class="reviews__review-rating-pos">
                                {{ $review->likes_count ?? 0 }}
                            </span>
                            из
                            <span class="reviews__review-rating-total">
                                {{ ($review->likes_count ?? 0) + ($review->dis_likes_count ?? 0) }}
                            </span>
                            человек посчитали отзыв полезным
                        </div>
                    </div>
                    <div class="reviews__review-question">
                        <span class="reviews__review-question-text">Отзыв был полезен?</span>

                        <a class="reviews__review-question-link button
                            @if(isset($review->isLike->like))
                                @if($review->isLike->like == 1)
                                    _red
                                @else
                                    _white
                                @endif
                            @else
                                _white
                            @endif"
                            onclick="reviewLikeRating({{ $review->id }}, 1)">Да</a>

                        <a class="reviews__review-question-link button
                            @if(isset($review->isLike->like))
                                @if($review->isLike->like == 0)
                                    _red
                                @else
                                    _white
                                @endif
                            @else
                                _white
                            @endif"
                           onclick="reviewLikeRating({{ $review->id }}, 0)">Нет</a>

                    </div>
                </div>
                <div class="reviews__review-answer @if(!isset($review->isLike->like)) g-hide @endif">
                    <div class="reviews__review-answer-message">Спасибо за Вашу оценку!</div>
                </div>
            </footer>
        @endif
    </div>
</div>