<?php $attributes = [];?>

@foreach($product->attributes as $attribute)
    @if(empty($attribute->attribute_group_id) or empty($attribute->pivot->value) or $attribute->show_product_detail == 0)
        @continue
    @endif
    <?php $attributes[$attribute->attribute_group_id][] = $attribute;?>
@endforeach


@include('mobile.includes.space', ['style' => ''])

@foreach(App\Models\AttributeGroup::OrderBy('sort')->get() as $attributeGroup)
    @if(!isset($attributes[$attributeGroup->id]))
        @continue
    @endif
    <div class="container specifications-list">
        <h4 class="specifications-list__heading">
            {{ $attributeGroup->name }}
        </h4>
        <dl class="specifications-list__specs">
            @foreach($attributes[$attributeGroup->id] as $attribute)

                @if(empty($attribute->pivot->value))
                    @continue
                @endif

                <dt class="specifications-list__term">
                    {{ $attribute->name }}
                </dt>
                <dd class="specifications-list__specification">
                    {{ $attribute->pivot->value }}
                </dd>
            @endforeach
        </dl>
    </div>
@endforeach
