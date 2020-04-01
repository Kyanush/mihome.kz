@if(false)
<script type=application/ld+json> {
        "@context":"http://schema.org",
        "@type":"WebSite",
        "url":"{{ env('APP_URL') }}",
        "potentialAction": {
            "@type":"SearchAction",
            "target":"{{ env('APP_URL') }}/search?searchword={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
</script>
@endif