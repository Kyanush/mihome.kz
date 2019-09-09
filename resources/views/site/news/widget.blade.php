<div class="bs-example" data-example-id="media-alignment">
    @foreach($news as $item)
        <div class="media">
            <div class="media-left">
                <a href="{{ $item->detailUrl() }}">
                    <img src="{{ $item->pathImage(true) }}"
                         class="media-object"
                         style="width: 64px; height: 64px;"
                         title="{{ $item->title }}"
                         alt="{{ $item->title }}"/>
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="{{ $item->detailUrl() }}">
                        {{ $item->title }}
                    </a>
                </h4>
                <p>{!! $item->preview_text !!}</p>
            </div>
        </div>
    @endforeach
</div>
