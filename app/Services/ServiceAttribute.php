<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use File;
use App\Tools\Upload;

class ServiceAttribute
{

    public static function attributeSave($data)
    {
        $attribute = Attribute::findOrNew($data["id"]);
        $attribute->fill($data);
        if($attribute->save())
        {
            if(isset($data['values']))
            {
                foreach ($data['values'] as $key => $item)
                {

                    if(empty($item['id']))
                        continue;

                    if (intval($item['is_delete']) or (!empty($item['id']))){
                        AttributeValue::destroy($item['id']);
                    }else{

                        $value = $attribute->values()->findOrNew($item['id']);

                        if ($attribute->type == 'media') {
                            if (!empty($value->value) and (is_uploaded_file($item['value']) or empty($item['value'])))
                            {
                                $path_delete = config('shop.attributes_path_file') . $value->value;
                                if (File::exists($path_delete))
                                    File::delete($path_delete);
                            }

                            if (is_uploaded_file($item['value']))
                            {
                                $upload = new Upload();
                                $upload->setPath(config('shop.attributes_path_file'));
                                $upload->setFile($item['value']);

                                $item['value'] = $upload->save();
                            }
                        }

                        if ($attribute->type != 'color') {
                            unset($item['props']);
                        }

                        $value->fill($item);
                        $value->save();
                    }
                }
            }else{

            }

            return $attribute->id;
        }

        return false;
    }

}
