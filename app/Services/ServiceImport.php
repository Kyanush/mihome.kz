<?php
namespace App\Services;

use App\Models\Category;
use App\Models\ProductGroup;
use DB;

class ServiceImport
{

    public $data;
    public $table;
    public $selected;
    public $data_column;
    public $identification_column;
    public $attribute_group_id;


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
                    $value_new = $data_item[ $data_column_index ];
                    $value_old = $insert[$data_key][ $data_column_item ] ?? false;

                    if($value_old)
                    {
                        if(is_array($value_old)){
                            $insert[$data_key][ $data_column_item ][] = $value_new;
                        }else{
                            $insert[$data_key][ $data_column_item ] = [
                                $value_old, $value_new
                            ];
                        }
                    }else
                        $insert[$data_key][ $data_column_item ] = $value_new;
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

        $products_groups = [];

        if($insert)
        {
            foreach ($insert as $item)
            {

                if($this->table == 't_products')
                {

                    if($this->attribute_group_id)
                        $item['attribute_set_id'] = $this->attribute_group_id;

                    $group_id = $item['group_id'] ?? false;
                    if($group_id)
                    {
                        if(!isset($products_groups[ $group_id ]))
                        {
                            $item['group_id'] = ProductGroup::create()->id;
                            $products_groups[ $group_id ] = $item['group_id'];
                        }else{
                            $item['group_id'] = $products_groups[ $group_id ];
                        }
                    }
                }

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

                if($this->table == 't_products')
                {

                    //Атрибуты
                    $attributes = [];
                    foreach ($item as $attribute_id => $value)
                    {
                        if(is_numeric($attribute_id))
                        {
                            $attributes[] = [
                                'attribute_id' => $attribute_id,
                                'value'        => $value
                            ];
                        }
                    }
                    if(count($attributes) > 0)
                    {
                        ServiceProduct::productAttributesSave(
                            $element->id,
                            $attributes,
                            false
                        );
                    }

                    //Категория
                    $categories = $item['categories'] ?? false;
                    if($categories)
                    {
                        $categories = (array)$categories;
                        $categories_ids = [];

                        foreach ($categories as $name)
                        {
                            $category = Category::firstOrNew(['name' => $name]);
                            $category->name = $name;
                            $category->save();

                            if($category)
                                $categories_ids[] = $category->id;
                        }

                        if(count($categories_ids) > 0)
                            $element->categories()->sync($categories_ids);
                    }

                    //Картинки
                    $images = $item['images'] ?? false;
                    if($images)
                    {
                        $format_images = [];
                        $images = (array)$images;

                        foreach($images as $image)
                        {
                            $format_images[] = [
                                'id'        => 0,
                                'is_delete' => 0,
                                'value'     => $image
                            ];
                        }

                        if(count($format_images) > 0)
                        {
                            ServiceProduct::productImagesSave($format_images, $element->id);
                        }
                    }



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
