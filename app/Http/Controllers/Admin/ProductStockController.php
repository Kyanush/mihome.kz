<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\ProductStock;
use App\Tools\Helpers;
use Illuminate\Http\Request;
use App\Models\Product;
use Mpdf\Mpdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Excel\ExcelView;


class ProductStockController extends AdminController
{

    public function list(){
        $prodcutStock = ProductStock::all();
        return  $this->sendResponse($prodcutStock);
    }

    public function get($product_id)
    {
        $prodcutStock = ProductStock::withCount(['orderProducts' => function ($query){
                                        $query->whereHas('order', function ($query){
                                            $query->whereNotIn('status_id', [6]);
                                        });
                                        $query->select(\DB::raw('sum(quantity)'));
                                    }])
                                    ->with('arrival')
                                    ->where('product_id', $product_id)
                                    ->get();

        return  $this->sendResponse($prodcutStock);
    }

    public function save(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item)
        {
            $productStock = ProductStock::findOrNew($item['id'] ?? 0);
            $productStock->fill($item);
            $productStock->save();
        }

        return  $this->sendResponse(true);
    }

    public function productStockReport(Request $request){

        $filters = $request->all();

        $sort = Helpers::sortConvert($filters['sort'] ?? false);
        $column = $sort['column'];
        $order  = $sort['order'];

        $blade  = 'reports.product_stock';
        $format = $request->input('format', 'excel');
        $title  = $request->input('title', 'Количество на складе');
        $arrival_id = $request->input('arrival_id');


        $data =  Product::with(['stock' => function($query) use ($arrival_id){
                $query->selectRaw('product_id, sum(quantity) as quantity, price');
                $query->groupBy(['product_id', 'price']);

                if($arrival_id)
                    $query->where('arrival_id', $arrival_id);

            }])
            ->where(function ($query) use ($arrival_id){
                    $query->whereHas('stock', function ($query) use ($arrival_id){

                        $query->where('price', '>', 0);

                        if($arrival_id)
                            $query->where('arrival_id', $arrival_id);

                    });
            })
            ->filters($filters)
            ->filtersAttributes($filters)
            ->OrderBy($column, $order)
            ->paginate($request->input('perPage', 10));


        foreach ($data as $key => $item)
        {
            $data[$key]->format_price = Helpers::priceFormat($item->price);
            $data[$key]->balance = $item->balance($arrival_id);
        }

        if($format == 'pdf')
        {

            $result = view($blade, $data);

            $mpdf = new Mpdf(['orientation' => 'L']);
            $mpdf->WriteHTML($result);
            $mpdf->SetTitle($title);
            return $mpdf->Output();

        }else{
            return Excel::download(new ExcelView(['data' => $data], $blade), $title . '.xlsx');
        }

    }

}