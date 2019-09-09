<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\City;
use App\Requests\SaveCityRequest;
use Illuminate\Http\Request;

class CityController extends AdminController
{

    public function list(Request $request)
    {
        $list =  City::search($request->input('search'))
                        ->OrderBy('sort', 'ASC')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SaveCityRequest $request)
    {
        $data = $request->all();
        $data = $data['city'];

        $city = City::findOrNew($data["id"]);
        $city->fill($data);
        $city->save();

        return  $this->sendResponse($city ? $city->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            City::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(City::destroy($id) ? true : false);
    }

}