<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

   <url>
        <loc>{{ route('news_list') }}</loc>
        <lastmod><?php echo date('c'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
   </url>

   @foreach($news as $item)
       <url>
          <loc>{{ $item->detailUrl() }}</loc>
          <lastmod><?php echo date('c', strtotime($item->updated_at)); ?></lastmod>
          <changefreq>weekly</changefreq>
          <priority>0.4</priority>
       </url>
   @endforeach

</urlset>