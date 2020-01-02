@include('mobile.includes.space', ['style' => ''])

@if($product->description_style_id)

    <div id="description">
        {!! $product->description  !!}
    </div>

    @section('add_in_end')
        {!! $product->descriptionStyle->name !!}
    @stop

@else
    <div class="description container" id="description">
        {!! $product->description !!}
    </div>
@endif