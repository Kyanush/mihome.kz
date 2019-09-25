<?php

namespace App\Tools;

use File;
use Intervention\Image\ImageManagerStatic as Image;

class Upload
{

    private $width = 0, $height = 0, $file = null, $path = '';
    public $fileName = '';

    public function getWidth()
    {
        return $this->width;
    }
    public function setWidth(int $width)
    {
        $this->width = $width;
    }



    public function getHeight()
    {
        return $this->height;
    }
    public function setHeight(int $height)
    {
        $this->height = $height;
    }



    public function getFile()
    {
        return $this->file;
    }
    public function setFile($file)
    {
        $this->file = $file;
    }



    public function getPath()
    {
        return $this->path;
    }
    public function setPath(string $path)
    {
        $this->path = $path;
    }


    public function save()
    {
        $file = $this->getFile();
        $path = $this->getPath();

        if(empty($file) or empty($path))
            return '';

        if(is_uploaded_file($file))
        {

            $fileName = ($this->fileName ? $this->fileName : md5(uniqid('', true)));
            $ext = $file->extension();
            $fileName.= '.' . $ext;

            if($file->move($path, $fileName)){

                if (in_array($ext, array("png", "jpeg", "gif")))
                {
                    if($this->getWidth() > 0 or $this->getHeight() > 0)
                    {
                        Image::make(public_path($path . $fileName))->resize($this->getWidth(), $this->getHeight(), function ($constraint) {
                            $constraint->aspectRatio();
                        })->save();
                    }
                }

                return $fileName;
            }
            else
                return '';
        }
        return $file;
    }


}
