<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('sitemap.pages') }}</loc>
        <lastmod><?php echo date('c'); ?></lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('sitemap.news') }}</loc>
        <lastmod><?php echo date('c'); ?></lastmod>
    </sitemap>
    @foreach($cities as $city)
        <sitemap>
            <loc>{{ route('sitemap.' . $city->code) }}</loc>
            <lastmod><?php echo date('c'); ?></lastmod>
        </sitemap>
    @endforeach
</sitemapindex>