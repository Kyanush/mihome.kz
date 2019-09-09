<?php
namespace App\Services;

use App\Models\AttributeValue;
use File;

class ServiceAttributeProductValue
{


    public static function deleteImage($attribute_id, $fileName)
    {
        $path = config('shop.attributes_path_file') . $fileName;

        if(File::exists($path))
            if(!AttributeValue::where('attribute_id', $attribute_id)->where('value', $fileName)->first())
                return File::delete($path) ? true : false;

        return false;
    }

}