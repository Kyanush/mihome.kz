<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\AttributeGroup;


class AttributeGroupController extends AdminController
{

    public function list()
    {
        return  $this->sendResponse(AttributeGroup::OrderBy('sort')->get());
    }

}