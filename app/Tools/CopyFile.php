<?php

namespace App\Tools;

use File;

class CopyFile
{
    private $oldPath, $newPath;



    public function getOldPath()
    {
        return $this->oldPath;
    }
    public function setOldPath(string $oldPath)
    {
        $this->oldPath = $oldPath;
    }


    public function getNewPath()
    {
        return $this->newPath;
    }
    public function setNewPath(string $newPath)
    {
        $this->newPath = $newPath;
    }


    public function copy(){

        $oldPath = $this->getOldPath();
        $newPath = $this->getNewPath();

        if(!File::exists($oldPath))
            return false;

        //формат файла
        $fileExtension = File::extension($oldPath);

        //новое имя
        $fileName = md5(uniqid('', true)) . '.' . $fileExtension;

        //создаем папку, если нет
        if(!File::isDirectory($newPath))
            File::makeDirectory($newPath);

        return File::copy($oldPath , $newPath . $fileName) ? $fileName : false;
    }

}
