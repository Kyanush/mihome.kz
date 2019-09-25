<?php
namespace App\Services;

class ServiceUploadUrl
{

    public $name;
    public $url;
    public $path_save;

    public function copy(){

        $pathinfo = pathinfo($this->url);

        $filename = trim($this->name) . '.' . trim(mb_strtolower($pathinfo['extension']));

        $downloadedFileContents = @file_get_contents($this->url);

        if($downloadedFileContents === false)
            return false;

        $save = file_put_contents($this->path_save . '/' . $filename, $downloadedFileContents);

        if($save)
            return $filename;
        else
            return false;
    }

    public static function validUrlImage($image_full_path){
        $is = @getimagesize($image_full_path);
        if (!$is)
            return false;
        elseif ( !in_array($is[2], array(1,2,3))   )
            return false;
        elseif ( ($is['bits']>=8) )
            return true;
        return false;
    }

}
