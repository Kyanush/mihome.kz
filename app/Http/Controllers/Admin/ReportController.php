<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\Order;
use Mpdf\Mpdf;

use Maatwebsite\Excel\Facades\Excel;

use App\Excel\ExcelView;

class ReportController extends AdminController
{

    private $splitPageLimit = 400;


    public function yandexDirectory($format, Request $request){
        $title = $request->input('title', 'Отчет');

        $filters = $request->all();

        $products =  Product::with('category', 'attributes')
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

      if($format == 'pdf')
        {
          $mpdf = new Mpdf(['orientation' => 'L']);
          $mpdf->WriteHTML($result);
          return $mpdf->Output();

        }else{
            return Excel::download(new ExcelView([
                'title'          => $title,
                'format'         => $format,
                'products'       => $products,
                'date_start'     => false,
                'date_end'       => false
            ], 'reports.yandex_directory'), $title . '.xlsx');
        }
      
    }

    public function gis2Directory(Request $request){
        $title = $request->input('title', 'Отчет');

        $filters = $request->all();

        $products =  Product::with('category', 'attributes')
                            ->main()
                            ->filters($filters)
                            ->filtersAttributes($filters)
                            ->get();

            return Excel::download(new ExcelView([
                'products'       => $products,
            ], 'reports.gis2_directory'), $title . '.xlsx');

    }

    public function goods($format, Request $request){
        $title = $request->input('title', 'Отчет');
        $data = [];

        $category_id = $request->input('category_id');

        $orders =  Order::with(['products' => function ($query) use ($category_id){

                                    $query->filters(['category_id' => $category_id]);

                              }])->filters($request->all())->get();

        foreach ($orders as $order)
        {
            foreach ($order->products as $product)
            {
                if(!isset($data[$product->id]['sum']))
                {
                    $data[$product->id]['sum'] = 0;
                    $data[$product->id]['quantity'] = 0;
                    $data[$product->id]['profit'] = 0;
                }

                $data[$product->id]['product']  = $product;
                $data[$product->id]['sum']      += $product->pivot->price * $product->pivot->quantity;
                $data[$product->id]['quantity'] += $product->pivot->quantity;

                $productStock = ProductStock::find($product->pivot->product_stock_id);
                if($productStock)
                        $data[$product->id]['profit'] += ($product->pivot->price - $productStock->price) * $product->pivot->quantity;


            }
        }

       // dd($data);
        $data = collect($data)->sortBy('quantity')->reverse()->toArray();

        $blade = 'reports.goods';



        $date_start = $request->input('created_at_start');
        $date_end   = $request->input('created_at_end');

        $data = [
            'title'      => $title,
            'date_start' => $date_start,
            'date_end'   => $date_end,
            'data'       => $data,
            'format'     => $format
        ];

        if($format == 'pdf')
        {

            $result = view($blade, $data);

            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($result);
            $mpdf->SetTitle($title);
            return $mpdf->Output();

        }else{
            return Excel::download(new ExcelView($data, $blade), $title . '.xlsx');
        }

    }

}