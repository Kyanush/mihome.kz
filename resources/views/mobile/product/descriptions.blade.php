@include('mobile.includes.space', ['style' => ''])

@section('add_in_end')
    <link href="/css/uk.css" rel="stylesheet" />
    <script src="https://asuikit.com/app/assets/uikit/js/uikit.min.js?v=9b6b"></script>
    <script src="https://getuikit.com/v2/src/js/components/slideset.js"></script>
    <link rel="stylesheet" href="https://asuikit.com/app/assets/uikit/css/components/slideshow.min.css">
    <link rel="stylesheet" href="https://asuikit.com/app/assets/uikit/css/components/slidenav.min.css">
    <link rel="stylesheet" href="https://asuikit.com/app/assets/uikit/css/components/dotnav.min.css">
    <script src="https://asuikit.com/app/assets/uikit/js/components/slideshow.min.js"></script>
    <script src="https://asuikit.com/app/assets/uikit/js/components/slideshow-fx.min.js"></script>
@stop

<div class="@if(!$product->description_full_screen) description container @endif" id="description">
    {!! $product->description !!}
</div>