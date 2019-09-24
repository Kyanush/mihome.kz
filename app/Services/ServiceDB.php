<?php
namespace App\Services;

use DB;

class ServiceDB
{

    public static function tableList(){
        $list = [];

        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
            foreach ($table as $value)
                $list[] = $value;

        return $list;
    }

    public static function tableColumns($table){
        $list = [];

        $columns = DB::select("SHOW FULL COLUMNS FROM $table");
        foreach ($columns as $column)
            $list[] = [
                'column' => $column->Field,
                'title'  => $column->Comment
            ];

        return $list;
    }

    public static function tableNextId($tableName){
        $statement = DB::select("show table status like '" . env('DB_TABLE_PREFIX') . $tableName . "'");
        return $statement[0]->Auto_increment;
    }

}