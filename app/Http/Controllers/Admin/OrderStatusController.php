<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\OrderStatus;
use App\Requests\SaveOrderStatusRequest;
use Illuminate\Http\Request;
use DB;

class OrderStatusController extends AdminController
{

    public function list(Request $request)
    {
        $list   =  OrderStatus::Search($request->input('search'))
                                ->OrderBy('id', 'asc')
                                ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    public function save(SaveOrderStatusRequest $request)
    {
        $data = $request->input('order_status');

        $attribute = OrderStatus::findOrNew($data["id"]);
        $attribute->fill($data);
        return  $this->sendResponse($attribute->save() ? $attribute->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            OrderStatus::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(OrderStatus::destroy($id) ? true : false);
    }

}