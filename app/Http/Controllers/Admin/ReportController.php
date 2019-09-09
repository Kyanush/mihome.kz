<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use Mpdf\Mpdf;
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

        return $this->render($format, $result, $title);
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

        return $this->render($format, $result, $title);
    }

    private function splitRedirect($request, $data){
            if(!$request->input('page') and $data->lastPage() > 1)
            {
                for ($i = 1; $i <= $data->lastPage(); $i++)
                {
                    $s = strpos($request->fullUrl(), '?') !== false ? '&' : '?';
                    $fullURL = $request->fullUrl() . $s . 'page=' . $i;

                    echo <<<HTML
                      <script>
                            window.open('$fullURL', '_blank');
                            setTimeout(function () {
                                window.close(); 
                            }.bind(this), 1000);
                      </script>
HTML;
                }
                exit();
            }
    }


    private function render($format, $result, $title){
        if($format == 'excel')
        {
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=$title.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            return $result;
        }else{
            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($result);
            $mpdf->Output();
        }
    }



}