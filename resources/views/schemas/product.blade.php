@php

    $images = '';
    $images.= '"' . env('APP_URL') . $product->pathPhoto(true) . '",';

    if($product->images)
        foreach($product->images as $image)
            $images.= '"' . env('APP_URL') . $image->imagePath(true) . '",';
    $images = mb_substr($images, 0, -1);
@endphp

@section('schemas_product')

    <script type="application/ld+json">
{
    "@context"    :  "https://schema.org",
    "@type"       :  "Product",
    "description" :  "{{ $seo['description'] }}",
    "name"        :  "{{ $product->name }}",
    "sku"         :  "{{ $product->sku }}",
    "mpn"         :  "{{ $product->sku }}",
    "url"         :  "{{ $product->detailUrlProduct() }}",
    "category"    :  "{{ $category->name }}",
    "brand"       :  "{{ $category->name }}",
    "productID"   :  "{{ $product->id }}",
    "image"       :  [ {!! $images !!} ],

    @if(intval($product->avgRating->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ intval($product->avgRating->avg_rating ?? 0) }}",
        "reviewCount": "{{ $product->reviews_count }}"
    },
    @endif

        "offers": {
            "@type"         : "Offer",
            "url"           : "{{ $product->detailUrlProduct() }}",
        "price"         : "{{ $product->getReducedPrice() }}",
        "priceCurrency" : "KZT",

        @php
            $specificPrice = $product->specificPrice(function ($query){
                                          $query->DateActive();
                                     })
                                     ->first();
        @endphp
        @if($specificPrice)
            @if($specificPrice->expiration_date)
                "priceValidUntil": "{{ date('Y-m-d', strtotime($specificPrice->expiration_date)) }}",
            @else
                "priceValidUntil" : "{{date('Y')+1}}-12-31",
            @endif
        @else
            "priceValidUntil" : "{{date('Y')+1}}-12-31",
        @endif

        @if($product->stock > 0)
            "availability" : "https://schema.org/InStock",
            "itemCondition": "http://schema.org/NewCondition"
        @else
            "availability" : "https://schema.org/OutOfStock"
        @endif
        },

@php $reviews = $product->reviews; @endphp
        @if($reviews)
            "review": [
@foreach($reviews as $key => $review)
                {
                    "@type": "Review",
                    "author": "{{ $review->name }}",
                "datePublished": "{{ date('Y-m-d', strtotime($review->created_at)) }}",
                "description": "{{ strip_tags($review->comment) }}",
                "reviewRating": {
                    "@type": "Rating",
                    "bestRating": "5",
                    "worstRating": "1",
                    "ratingValue": "{{ $review->rating }}"
                }
            }<?=(count($reviews) > $key + 1) ? ',' : '';?>
            @endforeach
            ],
@endif

        @if($group_products)
            "isRelatedTo": [
@foreach($group_products as $gp_key => $group_product)
                {
                       "@type"        : "Product",
                        "image"       : "{{ env('APP_URL') . $group_product->pathPhoto(true) }}",
                        "url"         : "{{ $group_product->detailUrlProduct() }}",
                        "name"        : "{{ $group_product->name }}",
                        "description" : "{{ strip_tags($group_product->description_mini) }}",
                        "offers"      : {
                            "@type": "Offer",
                            "price": "{{ $group_product->getReducedPrice() }}",
                            "priceCurrency": "KZT"
                        }
                }<?=(count($group_products) > $gp_key + 1) ? ',' : '';?>
            @endforeach
            ]
@endif

        }
</script>
@stop



<div>
    <div itemtype="http://schema.org/Product" itemscope>
        <meta itemprop="mpn" content="{{ $product->sku }}" />
        <meta itemprop="name" content="{{ $product->name }}" />

        <link itemprop="image" href="{{ env('APP_URL') . $product->pathPhoto(true) }}" />
        @foreach($product->images as $image)
            <link itemprop="image" href="{{ env('APP_URL') . $image->imagePath(true) }}" />
        @endforeach

        <meta itemprop="description" content="{{ $seo['description'] }}" />

        <div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
            <link itemprop="url" href="{{ $product->detailUrlProduct() }}" />

            @if($product->stock > 0)
                <meta itemprop="availability"  content="https://schema.org/InStock" />
                <meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
            @else
                <meta itemprop="availability" content="https://schema.org/OutOfStock" />
            @endif

            <meta itemprop="priceCurrency" content="KZT" />
            <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
            <meta itemprop="price" content="{{ $product->getReducedPrice() }}" />

            @if($specificPrice)
                @if($specificPrice->expiration_date)
                    <meta itemprop="priceValidUntil" content="{{ date('Y-m-d', strtotime($specificPrice->expiration_date)) }}" />
                @else
                    <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
                @endif
            @else
                <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
            @endif

            <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                <meta itemprop="name" content="{{ env('APP_NAME') }}" />
            </div>
        </div>

        @if(intval($product->avgRating->avg_rating ?? 0) > 0 and $product->reviews_count > 0)
            <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                <meta itemprop="reviewCount" content="{{ $product->reviews_count }}" />
                <meta itemprop="ratingValue" content="{{ intval($product->avgRating->avg_rating ?? 0) }}" />
            </div>
        @endif

        @php $reviews = $product->reviews; @endphp
        @if($reviews)
            @foreach($reviews as $key => $review)
                <div itemprop="review" itemtype="http://schema.org/Review" itemscope>
                    <div itemprop="author" itemtype="http://schema.org/Person" itemscope>
                        <meta itemprop="name" content="{{ $review->name }}" />
                    </div>
                    <meta itemprop="datePublished" content="{{ date('Y-m-d', strtotime($review->created_at)) }}" />
                    <meta itemprop="description"   content="{{ strip_tags($review->comment) }}" />
                    <div itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
                        <meta itemprop="ratingValue" content="{{ $review->rating }}" />
                        <meta itemprop="bestRating"  content="5" />
                        <meta itemprop="worstRating" content="1" />
                    </div>
                </div>
            @endforeach
        @endif

        <meta itemprop="sku" content="{{ $product->sku }}" />
        <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
            <meta itemprop="name" content="{{ $category->name }}" />
        </div>

    </div>
</div>
