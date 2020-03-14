<input id="product_id" type="hidden" value="{{ $product->id }}"/>

@section('schemas_product')
    <script type=application/ld+json>{
        "@context": "https://schema.org",
        "@type": "Product",
        "productID": "{{ $product->sku }}",
        "name": "{{ $product->name }}",
        "description": "{{ str_replace('\\', "", $product->description_schema ? $product->description_schema : $description_schema) }}",
        "url":"{{ $product->detailUrlProduct() }}",
        "image":"{{ env('APP_URL') . $product->pathPhoto(true) }}",
        "brand":"{{ $category->name }}",
        "sku":"{{ $product->sku }}",
        "gtin":"{{ $product->sku }}",
        "offers": {
            "@type": "Offer",
            "price": "{{ $product->getReducedPrice() }}.00",
            "priceCurrency": "KZT",
            "url": "{{ $product->detailUrlProduct() }}",
            "itemCondition": "http://schema.org/NewCondition",
            "priceValidUntil": "2030-01-01",
            @if($product->status_id == 10)
            "availability":"http://schema.org/InStock"
@elseif($product->status_id == 11)
            "availability": "http://schema.org/PreOrder"
@elseif($product->status_id == 12)
            "availability":"http://schema.org/OutOfStock"
@else
            "availability":"http://schema.org/InStock"
@endif
        }
        @if($product->reviews_rating_avg > 0 and $product->reviews_count > 0)
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