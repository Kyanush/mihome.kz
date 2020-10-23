@include('mobile.includes.space', ['style' => ''])

    <div class="container specifications-list">
        <!--
        <h4 class="specifications-list__heading"></h4>
        --->
        <dl class="specifications-list__specs">
            @if($product->specifications)
                {!! $product->specifications !!}
            @else
                @foreach($product->attributes as $attribute)
                    @if($attribute->show_product_detail == 1)
                        <dt class="specifications-list__term">
                            {!! $attribute->pivot->name ? $attribute->pivot->name : '&nbsp;' !!}
                        </dt>
                        <dd class="specifications-list__specification">
                            {{ $attribute->pivot->value }}
                        </dd>
                    @endif
                @endforeach
            @endif
        </dl>
    </div>