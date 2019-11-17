<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function saveSetting(Request $request){

        $data = $request->all();

        foreach ($data as $item)
        {
            if($item['delete'])
            {
                Setting::destroy($item["id"]);
            }else{
                $setting = Setting::findOrNew($item["id"]);
                $setting->fill($item);
                $setting->save();
            }
        }

        return  $this->sendResponse(true);
    }

    public function getSetting(){
        $settings = Setting::all();
        return  $this->sendResponse($settings);
    }

}