<?php
namespace App\Services;

use DB;

class ServiceModel
{

    public static function getModels(){
        $dir = app_path('Models');
        $models = [];
        $classes = \File::allFiles($dir);
        foreach ($classes as $class) {
            $models[] = str_replace(
                [app_path(), '/', '.php'],
                ['\App', '\\', ''],
                $class->getRealPath()
            );
        }
        return $models;
    }

    public static function getModel($table){
        $models = self::getModels();
        foreach ($models as $model_item)
        {
            $obj = new $model_item();
            if(env('DB_TABLE_PREFIX') . $obj->getTable() == $table)
            {
                return $model_item;
            }
        }
        return false;
    }

}