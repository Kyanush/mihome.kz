<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Requests\SaveAttributeRequest;
use App\Services\ServiceAttribute;
use Illuminate\Http\Request;
use App\Models\Attribute;
use DB;
use File;

class AttributeController extends AdminController
{


    public function list(Request $request)
    {
        $list =  Attribute::search($request->input('search'))
                            ->OrderBy('id', 'DESC')
                            ->with('attributeGroup')
                            ->paginate($request->input('per_page', 100));
        return  $this->sendResponse($list);
    }

    public function save(SaveAttributeRequest $request)
    {
         $data = $request->all();
         $data = $data['attribute'];
         $result = ServiceAttribute::attributeSave($data);
         return  $this->sendResponse($result);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Attribute::with(['values'])->findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Attribute::destroy($id) ? true : false);
    }

}