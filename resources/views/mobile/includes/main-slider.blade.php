<div class="main-slider">
    <div class="swiper-container" id="main-slider">
        <div class="swiper-wrapper">

            @foreach($listSlidersHomePage as $item)
                <div class="swiper-slide">
                    <a title="{{ $item->name }}" class="main-slider__image-wrapper"  href="{{ $item->link }}">
                        <img alt="{{ $item->name }}" title="{{ $item->name }}" class="main-slider__image" src="{{ $item->pathImage(true) }}">
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>