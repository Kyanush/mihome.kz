<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Services\ServiceDB;
use App\Services\ServicePrint;
use App\Services\ServiceModel;

class ExportController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function exportTable($table){
        $model = ServiceModel::getModel($table);
        $tableColumns = ServiceDB::tableColumns($table);
        $list  = $model::all();

        $result =  view('reports.table',[
            'list' => $list,
            'tableColumns' => $tableColumns
        ]);

        $print = new ServicePrint();
        $print->result = $result;
        $print->format = 'excel';
        $print->title  = $table;

        return $print->print();
    }

}