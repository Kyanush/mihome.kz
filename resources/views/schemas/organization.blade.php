@php
    //социальные сети
    $sameAs = '';
    $social_network = config('shop.social_network');
    foreach ($social_network as $name => $link)
        $sameAs.= '"' . $link . '",';

    $sameAs = mb_substr($sameAs, 0, -1);

    //контакты
    $contactPoint = [];
    $number_phones = config('shop.number_phones');

    //адресы
    $address_data = [];
    $address = config('shop.address');

    //seo
    $seo = \App\Tools\Seo::main();
@endphp

<script type="application/ld+json">
    {
       "@context"     : "https://schema.org",
       "@type"        : "Organization",
       "name"         : "{{ $seo["title"] }}",
       "description"  : "{{ $seo["description"] }}",
       "url"          : "{{ env('APP_URL') }}",
       "logo"         : "{{ config('shop.logo') }}",
       "image"        : "{{ config('shop.logo') }}",
       "telephone"    : "{{ $number_phones[0]['format'] }}",
       "contactPoint" : [
            @foreach($number_phones as $k => $v)
                {
                    "@type"       : "ContactPoint",
                    "telephone"   : "{{ $v['format'] }}",
                    "contactType" : "customer service"
                }<?=(count($number_phones) > $k + 1) ? ',' : '';?>
            @endforeach
       ],
       "sameAs"       : [ {!! $sameAs !!} ],
       "address"      : [
            @foreach ($address as $k => $v)
                {
                    "@type"           : "PostalAddress",
                    "streetAddress"   : "{{ $v["streetAddress"] }}",
                    "addressLocality" : "{{ $v["addressLocality"] }}",
                    "postalCode"      : "{{ $v["postalCode"] }}",
                    "addressCountry"  : "{{ $v["addressCountry"] }}"
                }<?=(count($address) > $k + 1) ? ',' : '';?>
            @endforeach
       ]
 }
</script>