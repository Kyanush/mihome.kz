<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

   <url>
      <loc>{{ $siteUrl }}</loc>
      <changefreq>weekly</changefreq>
      <priority>1.0</priority>
   </url>

   @foreach(\App\Tools\Seo::pageSeo() as $link => $item)
       <url>
          <loc>{{ $siteUrl }}/{{ $link }}</loc>
          <changefreq>weekly</changefreq>
          <priority>0.5</priority>
       </url>
   @endforeach

</urlset>