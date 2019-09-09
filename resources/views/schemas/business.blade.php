@php
//online generate
//https://microdatagenerator.org/localbusiness-microdata-generator/

$seoMain = \App\Tools\Seo::main();
$address = config('shop.address');
$number_phones = config('shop.number_phones');
@endphp


<script type="application/ld+json">
    {
        "@context"   : "https://schema.org",
        "@type"      : "Store",
        "name"       : "{{ $seoMain['title'] }}",
        "image"      : "{{ config('shop.logo') }}",
        "email"      : "{{ config('shop.site_email') }}",
        "telePhone"  : "{{ $number_phones[0]['format'] }}",
        "url"        : "{{ env('APP_URL') }}",
        "priceRange" : "tg",

        "address" : {
            "@type"           : "PostalAddress",
            "streetAddress"   : "{{ $address[0]['streetAddress'] }}",
            "addressLocality" : "{{ $address[0]['addressLocality'] }}",
            "addressRegion"   : "KZT",
            "postalCode"      : "{{ $address[0]['postalCode'] }}"
        },
        "geo" : {
            "@type"     : "GeoCoordinates",
            "latitude"  : "{{ $address[0]['geo']['latitude'] }}",
            "longitude" : "{{ $address[0]['geo']['longitude'] }}"
        },
        "paymentAccepted" : [
            "cash",
            "credit card",
            "invoice"
        ],
        "openingHours"    : "Mo,Tu,We,Th,Fr,Sa,Su 10:00-19:00",
        "openingHoursSpecification" : [
            {
                "@type" : "OpeningHoursSpecification",
                "dayOfWeek" : [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                    "Sunday"
                ],
                "opens"  : "10:00",
                "closes" : "19:00"
            }
        ]
    }
</script>
