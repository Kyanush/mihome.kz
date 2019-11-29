<? echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach($products as $product)
        <url>
            <loc>{{ $product->detailUrlProduct() }}</loc>
            <lastmod><?php echo date('c', strtotime($product->updated_at)); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
            <image:image>
                <image:loc>
                    {{ $siteUrl . $product->pathPhoto(true) }}
                </image:loc>
            </image:image>
        </url>
    @endforeach

    @foreach($categories as $category)
        <url>
            <loc>{{ $category->catalogUrl() }}</loc>
            <lastmod><?php echo date('c', strtotime($category->updated_at)); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach


</urlset>