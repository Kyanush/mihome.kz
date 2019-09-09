@php
     $serviceApiInstagram = new \App\Services\ServiceApiInstagram();
     $INSTAGRAM_ACCOUNT_DATA = $serviceApiInstagram->userInfo();
     $INSTAGRAM_DATA = $serviceApiInstagram->data();
@endphp

@if($INSTAGRAM_ACCOUNT_DATA and $INSTAGRAM_DATA)
    <link href="/instagram/widget.css" rel="stylesheet" />
    <div class="widget_block">
        <div class="data-profile">
            <div class="profile_picture_block">
                <a target="_blank" href="https://www.instagram.com/{{ $INSTAGRAM_ACCOUNT_DATA->username }}">
                    <img class="profile_picture" src="{{ $INSTAGRAM_ACCOUNT_DATA->profile_picture }}" />
                </a>
            </div>
            <div class="data-photo-block">
                <div>
                    <span style="line-height: 30px;">Мы в Instagram</span>
                </div>

                <div class="followed_by">
                    <span class="instagram-data">{{ $INSTAGRAM_ACCOUNT_DATA->counts->followed_by }}</span>
                    <span class="instagram-data-title">подписчиков</span>
                </div>
                <div class="follows">
                    <span class="instagram-data">{{ $INSTAGRAM_ACCOUNT_DATA->counts->follows }}</span>
                    <span class="instagram-data-title">подписки</span>
                </div>
                <div class="item-media">
                    <span class="instagram-data">{{ $INSTAGRAM_ACCOUNT_DATA->counts->media }}</span>
                    <span class="instagram-data-title">публикаций</span>
                </div>
                <div class="subscribe-block">
                    <a target="_blank" href="https://www.instagram.com/{{ $INSTAGRAM_ACCOUNT_DATA->username }}" class="subscribe">Подписаться</a>
                </div>
            </div>
        </div>
        <div class="list-photo-block">
            @foreach($INSTAGRAM_DATA as $key => $result)
                @if($key == 20) @break @endif
                <a  target="_blank"
                    class="img_insta"
                    alt="{{ $result->caption->text ?? '' }}"
                    title="{{ $result->caption->text ?? '' }}"
                    href="{{ $result->link }}">
                    <img class="list-photo" src="{{ $result->images->thumbnail->url }}"/>
                </a>
            @endforeach
        </div>
    </div>
@else
    <p>Instagram пусто</p>
@endif
