@php
    $number_phones = config('shop.number_phones');
@endphp

<script type=application/ld+json> {
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "{{ env('APP_URL') }}",
        "name": "{{ env('APP_NAME') }}",
        "sameAs": [
            "{{ config('shop.social_network.instagram.url') }}",
            "{{ config('shop.social_network.facebook.url') }}",
            "{{ config('shop.social_network.vk.url') }}"
         ]
    }
</script>

<script type=application/ld+json> {
        "@context":"http://schema.org",
        "@type":"Organization",
        "url":"{{ env('APP_URL') }}",
        "logo":"{{ config('shop.logo') }}",
        "contactPoint": [
            @foreach($number_phones as $k => $v)
                {
                     "@type": "ContactPoint",
                     "telephone": "{{ $v['format'] }}",
                     "contactType": "sales",
                     "contactOption": [""],
                     "areaServed": ["Казахстан"],
                     "availableLanguage": ["Русский"]
                }<?=(count($number_phones) > $k + 1) ? ',' : '';?>
            @endforeach
        ]
    }
</script>