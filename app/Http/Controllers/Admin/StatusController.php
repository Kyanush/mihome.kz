<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Status;


class StatusController extends AdminController
{

    public function list($where_use)
    {
        $statuses = Status::WhereUse($where_use)->OrderBy('sort')->get();
        return  $this->sendResponse($statuses);
    }

}