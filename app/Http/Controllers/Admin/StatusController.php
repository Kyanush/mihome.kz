<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Status;


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

}
