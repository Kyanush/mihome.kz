<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Address;


class AddressController extends AdminController
{

    public function list()
    {
        return  $this->sendResponse(Address::all());
    }

}