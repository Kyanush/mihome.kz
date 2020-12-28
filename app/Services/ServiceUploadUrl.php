<?php
namespace App\Services;

class ServiceUploadUrl
{

    public $name;
    public $url;
    public $path_save;

    public function copy(){

        $this->url = str_replace(' ', "%20", $this->url);
        $pathinfo  = pathinfo($this->url);

        if($this->name)
            $filename  = trim($this->name) . '.' . trim(mb_strtolower($pathinfo['extension']));
        else{
            $filename = $pathinfo['basename'];
        }

        $downloadedFileContents = @file_get_contents($this->url);
        if($downloadedFileContents === false)
            return false;

        $save = file_put_contents($this->path_save . $filename, $downloadedFileContents);

        if($save)
            return $filename;
        else
            return false;
    }

    public static function validUrlImage($image_full_path){

        $image_full_path = mb_strtolower($image_full_path);

        $count = 0;
        $format_img  = ['.jpeg', '.jpg', '.png', 'https://', 'http://'];
        foreach ($format_img as $format)
        {
            if(strpos($image_full_path, $format) !== false)
            {
                $count++;
            }
        }

        return $count == 2 ? true : false;
    }

}
