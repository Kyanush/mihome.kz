<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Services\ServiceDB;
use App\Services\ServiceImport;
use App\Tools\Helpers;
use Illuminate\Http\Request;
use DB;

class ImportController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function tableList(){
        return $this->sendResponse(
            ServiceDB::tableList()
        );
    }

    public function tableColumns($table){
        return $this->sendResponse(
            ServiceDB::tableColumns($table)
        );
    }

    public function import(Request $request){
        $data = $request->input('data');
        $table = $request->input('table');
        $selected = $request->input('selected');
        $data_column = $request->input('data_column');
        $identification_column = $request->input('identification_column');

        $import = new ServiceImport();
        $import->data = $data;
        $import->table = $table;
        $import->selected = $selected;
        $import->data_column = $data_column;
        $import->identification_column = $identification_column;
        $result = $import->save();

        if($result)
            return $this->sendResponse($result);
        else
            return $this->sendResponse('Ошибка', 422);

    }

}
