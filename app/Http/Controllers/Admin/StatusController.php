<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends AdminController
{

    public function callbacksStatusId()
    {
        $statuses = Status::callbacksStatusId()->OrderBy('sort')->get();
        return  $this->sendResponse($statuses);
    }

    public function ordersType()
    {
        $statuses = Status::ordersType()->OrderBy('sort')->get();
        return  $this->sendResponse($statuses);
    }

    public function list(Request $request){

        $where_use = $request->input('where_use');

        if($where_use)
            $statuses = Status::where('where_use', $where_use)->OrderBy('sort')->get();
        else
            $statuses = Status::OrderBy('sort')->get();

        return  $this->sendResponse($statuses);
    }

}