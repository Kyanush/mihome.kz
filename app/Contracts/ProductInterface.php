<?php

namespace App\Contracts;

interface ProductInterface
{
    public static function productDelete($product_id);
    public static function productImagesSave(array $images, $product_id);
    public static function productAttributesSave(int $product_id, array $attributes);
    public static function priceMinMax($filters);
    public static function productsAttributesFilters($filters, $useInFilter = true);
}