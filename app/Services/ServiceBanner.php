<?php
namespace App\Services;

use App\Models\Banner;

class ServiceBanner
{


    public static function getBanner($banner_id)
    {
        $banner = Banner::find($banner_id);
        if($banner)
            return "<a target='_blank' href='{$banner->link}' title='{$banner->name}' alt='{$banner->name}'>{$banner->body}</a>";
        else
            return 'Баннет не найден';
    }

}