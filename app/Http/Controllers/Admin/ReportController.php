<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Services\ServicePrint;
use Illuminate\Http\Request;
use App\Models\Order;


class ReportController extends AdminController
{

    private $splitPageLimit = 400;


    public function yandexDirectory($format, Request $request){
        $title = $request->input('title', 'Отчет');

        $filters = $request->all();

        $products =  Product::with('categories', 'attributes')
                            ->filters($filters)
                            ->filtersAttributes($filters)
                            ->get();

        $result = view('reports.yandex_directory', [
            'title'          => $title,
            'format'         => $format,
            'products'       => $products,
            'date_start'     => false,
            'date_end'       => false
        ]);

        $print = new ServicePrint();
        $print->result = $result;
        $print->format = $format;
        $print->title  = $title;

        return $print->print();
    }

    public function goods($format, Request $request){
        $title = $request->input('title', 'Отчет');
        $data = [];

        if($format == 'excel')
            $orders =  Order::with('products')
                ->Filters($request->all())
                ->get();
        else{
            $orders =  Order::with('products')
                ->Filters($request->all())
                ->paginate($this->splitPageLimit);
        }


        foreach ($orders as $order)
        {
            foreach ($order->products as $product)
            {
                if(!isset($data[$product->id]['sum']))
                {
                    $data[$product->id]['sum'] = 0;
                    $data[$product->id]['quantity'] = 0;
                }

                $data[$product->id]['product']  = $product;
                $data[$product->id]['sum']      += $product->pivot->price * $product->pivot->quantity;
                $data[$product->id]['quantity'] += $product->pivot->quantity;
            }
        }

        $result = view('reports.goods', [
            'title'          => $title,
            'format'         => $format,
            'data'           => $data,
            'date_start'     => $request->input('created_at_start'),
            'date_end'       => $request->input('created_at_end')
        ]);

        $print = new ServicePrint();
        $print->result = $result;
        $print->format = $format;
        $print->title  = $title;

        return $print->print();
    }

}