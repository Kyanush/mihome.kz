<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Banner;
use App\Requests\SaveBannerRequest;
use Illuminate\Http\Request;

class BannerController extends AdminController
{

    public function list(Request $request)
    {
        $list =  Banner::search($request->input('search'))
                        ->OrderBy('id', 'desc')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SaveBannerRequest $request)
    {
        $data = $request->all();
        $data = $data['banner'];

        $banner = Banner::findOrNew($data["id"]);
        $banner->fill($data);
        $banner->save();

        return  $this->sendResponse($banner ? $banner->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Banner::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Banner::destroy($id) ? true : false);
    }

}