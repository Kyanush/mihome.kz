
<?php
$productsDay =  \App\Models\Product::productInfoWith()
    ->filtersAttributes(['product_day' => 'da'])
    ->limit(3)
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->get();
?>

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <div class="section-title">
            <h3 class="title">Товар дня</h3>
        </div>

        <!-- row -->
        <div class="row">
        @foreach($productsDay as $productDay)
            <!-- shop -->
                <div class="col-md-4 col-xs-12">
                    <a class="shop" href="{{ $productDay->detailUrlProduct() }}">
                        <div class="shop-img">
                            <img src="{{ $productDay->pathPhoto(true) }}"
                                 title=" {{ $productDay->name }}"
                                 alt=" {{ $productDay->name }}"/>
                        </div>
                        <div class="shop-body">
                            <h3>{{ $productDay->name }}</h3>
                            <div  class="cta-btn">
                                {{ \App\Tools\Helpers::priceFormat($productDay->getReducedPrice()) }}
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- /shop -->
            @endforeach
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->