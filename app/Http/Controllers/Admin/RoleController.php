<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Role;


class RoleController extends AdminController
{

    public function list()
    {
        return  $this->sendResponse(Role::all());
    }

}