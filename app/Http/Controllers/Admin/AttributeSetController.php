<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\AttributeSet;
use App\Requests\SaveAttributeSetRequest;
use Illuminate\Http\Request;
use DB;

class AttributeSetController extends AdminController
{

    public function list(Request $request)
    {
        $list =  AttributeSet::search($request->input('search'))
                            ->OrderBy('id', 'DESC')
                            ->paginate($request->input('per_page', 100));

        return  $this->sendResponse($list);
    }

    public function view($id)
    {
        $attributeSet = AttributeSet::select(['id', 'name'])->with(['attributes'])->findOrFail($id);
        $attributes = $attributeSet->attributes->map(function ($item) {
            return [$item->id];
        });

        unset($attributeSet->attributes);
        $attributeSet->attributes = $attributes;

        return  $this->sendResponse($attributeSet);
    }

    public function save(SaveAttributeSetRequest $request)
    {
        $data = $request->input('attribute_set');

        $attribute = AttributeSet::findOrNew($data["id"]);
        $attribute->fill($data);

        if($attribute->save())
            $attribute->attributes()->sync($data['attributes']);

        return  $this->sendResponse($attribute->id);
    }

    public function delete($id)
    {
        return  $this->sendResponse(AttributeSet::destroy($id) ? true : false);
    }
}