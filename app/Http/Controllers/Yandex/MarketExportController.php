<?php

namespace App\Http\Controllers\Yandex;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class MarketExportController extends Controller
{

    public function marketExport(){

        $products   = Product::with('categories', 'attributes')->filters(['active' => 1])->get();
        $categories = Category::isActive()->get();

        return response()->view('yandex.market_export', [
            'products' => $products,
            'categories' => $categories
        ])->header('Content-Type', 'text/xml');
    }

}
