<div class="main-slider">
    <div class="swiper-container" id="main-slider">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <a class="main-slider__image-wrapper">
                    <video width="100%" uk-cover="" src="/video/videoplayback.mp4" loop="" autoplay="" muted="" playsinline=""></video>
                </a>
            </div>

            @foreach($listSlidersHomePage as $item)
                <div class="swiper-slide">
                    <a title="{{ $item->name }}" class="main-slider__image-wrapper"  href="{{ $item->link }}">
                        <img alt="{{ $item->name }}"
                             title="{{ $item->name }}"
                             class="main-slider__image swiper-lazy"
                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                             data-src="{{ $item->pathImage(true) }}"/>
                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>