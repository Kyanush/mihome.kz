<?php
namespace App\Services;

use DB;

class ServiceImport
{

    public $data;
    public $table;
    public $selected;
    public $data_column;
    public $identification_column;



    private function clearData(){
        foreach ($this->selected as $key => $value)
            if(!$value)
                unset($this->data[ $key ]);
    }

    private function dataConvertToArray(){
        $insert = [];

        foreach($this->data as $data_key => $data_item)
        {
            foreach($this->data_column as $data_column_index => $data_column_item)
            {
                if($data_column_item)
                {
                    $insert[$data_key][ $data_column_item ] = $data_item[ $data_column_index ];
                }
            }
        }
        return $insert;
    }

    public function save(){
        $new = $update = 0;

        $this->clearData();

        $model = ServiceModel::getModel($this->table);
        if(!$model)
            return false;

        $insert = $this->dataConvertToArray();
        $identification_column = $this->identification_column;

        if($insert)
        {
            foreach ($insert as $item)
            {
                if($identification_column)
                {
                    $value = mb_strtolower($item[ $identification_column ]);

                    $element = $model::where(DB::raw("LOWER($identification_column)"), 'LIKE', "%{$value}%")->first();
                    if($element){
                        $update++;
                    }else{
                        $new++;
                        $element = new $model();
                    }

                    $element->fill($item);
                    $element->save();
                }else{
                    $element = new $model();
                    $element->fill($item);
                    $element->save();
                    $new++;
                }
            }
        }

        return [
            'total'  => count($insert),
            'new'    => $new,
            'update' => $update
        ];
    }

}