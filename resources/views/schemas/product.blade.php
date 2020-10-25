<input id="product_id" type="hidden" value="{{ $product->id }}"/>


@php
    if($product->status_id == 10)
        $availability = "https://schema.org/InStock";
    elseif($product->status_id == 11)
        $availability = "https://schema.org/PreOrder";
    elseif($product->status_id == 12)
        $availability = "https://schema.org/OutOfStock";
    else
        $availability = "https://schema.org/InStock";
@endphp

@section('schemas_product')
<script type=application/ld+json>{
    "@context": "https://schema.org",
    "@type": "Product",
    "productID": "{{ $product->sku }}",
    "name": "{{ $product->name }}",
    "description": "{{ str_replace('\\', "", $product->description_schema ? $product->description_schema : $description_schema) }}",
    "image":"{{ $product->getPhoto() }}",
    "brand":"{{ $category->name }}",
    "sku":"{{ $product->sku }}",
    "gtin":"{{ $product->sku }}",
    "offers": {
        "@type": "Offer",
        "price": "{{ $product->getReducedPrice() }}",
        "priceCurrency": "KZT",
        "url": "{{ $product->detailUrlProduct() }}",
        "itemCondition": "https://schema.org/NewCondition",
        "priceValidUntil": "2030-01-01",
        "availability":"{{ $availability }}"
    },
    "aggregateRating": {
        "ratingValue": "{{ $product->reviews_rating_avg > 0 ? $product->reviews_rating_avg : 5 }}.0",
        "reviewCount": "{{ $product->reviews_count      > 0 ? $product->reviews_count      : 5 }}",
        "worstRating": 0,
        "bestRating": 5
    }
}
</script>

@stop