@php
    $breadcrumbs_new = [];

    foreach ($breadcrumbs as $item)
        if($item['link'] and $item['link'] != '/')
                $breadcrumbs_new[] = $item;
@endphp

@section('schemas_breadcrumb')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
        @foreach($breadcrumbs_new as $key => $item)
            @if(!empty($item['link']))
                  {
                        "@type": "ListItem",
                        "position": "{{ $key + 1 }}",
                        "name": "{{ $item['title'] }}",
                        "item": "{{ $item['link'] }}"
                  }<?=(count($breadcrumbs_new) > $key + 1) ? ',' : '';?>
            @endif
        @endforeach
  ]
}
</script>
@stop