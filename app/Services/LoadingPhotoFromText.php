<?php


namespace App\Services;


class LoadingPhotoFromText
{

    public $text,
           $path_save,
           $img_path,
           $found = false;

    public function run(){
        preg_match_all( '@src="([^"]+)"@' , $this->text, $parse_urls );
        $parse_urls = $parse_urls[1] ?? false;

        $urls = [];
        foreach ($parse_urls as $url)
            $urls[$url] = $url;

        if($urls)
        {
            foreach ($urls as $url)
            {
                $url_parse = parse_url($url);
                if(isset($url_parse["scheme"]) and isset($url_parse["host"]))
                {
                    $site_url = $url_parse["scheme"] . "://" . $url_parse["host"];
                    if($site_url !== env('APP_URL'))
                    {
                        $serviceUploadUrl = new ServiceUploadUrl();
                        $serviceUploadUrl->url = $url;
                        $serviceUploadUrl->path_save = $this->path_save;
                        $filename = $serviceUploadUrl->copy();
                        if($filename)
                        {
                            $path = $this->img_path . $filename;
                            $this->text = str_replace($url, $path, $this->text);
                            $this->found = true;
                        }
                    }
                }
            }
        }
    }

}