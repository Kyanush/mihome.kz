
<input id="product_id" type="hidden" value="{{ $product->id }}"/>


@section('schemas_product')
    @php
       if($product->parent_id)
       {
           $category = \App\Models\Category::find($product->parent->categories[0]->id);
       }else{
           $category = \App\Models\Category::find($product->categories[0]->id);
       }
    @endphp

    <script type=application/ld+json>{
        "@context": "https://schema.org",
        "@type": "Product",
        "productID": "{{ $product->sku }}",
        "name": "{{ $product->name }}",
        "description": "{{ $product->description_short ? $product->description_short : $product->name }}",
        "url":"{{ $product->detailUrlProduct() }}",
        "image":"{{ env('APP_URL') . $product->pathPhoto(true) }}",
        "brand":"{{ $category->name }}",
        "sku":"{{ $product->sku }}",
        "offers": {
            "@type": "Offer",
            "price": "{{ $product->getReducedPrice() }}.00",
            "priceCurrency": "KZT",
            "url": "{{ $product->detailUrlProduct() }}",
            "itemCondition": "http://schema.org/NewCondition",

            @if($product->status_id == 10)
                "availability":"http://schema.org/InStock"
            @elseif($product->status_id == 11)
                "availability": "http://schema.org/PreOrder"
            @elseif($product->status_id == 12)
                "availability":"http://schema.org/OutOfStock"
            @endif
        }
        @if($product->reviews_rating_avg and $product->reviews_count)
        ,
        "aggregateRating": {
            "ratingValue": "{{ $product->reviews_rating_avg }}.0",
            "reviewCount": "{{ $product->reviews_count }}",
            "worstRating": 0,
            "bestRating": 5
        }
        @endif
    }



    </script>
@stop