<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Carrier;
use App\Requests\SaveCarrierRequest;
use Illuminate\Http\Request;

class CarrierController extends AdminController
{

    public function list(Request $request)
    {
        $list =  Carrier::search($request->input('search'))
                        ->OrderBy('ID', 'DESC')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SaveCarrierRequest $request)
    {
        $data = $request->all();
        $data = $data['carrier'];

        $carrier = Carrier::findOrNew($data["id"]);
        $carrier->fill($data);
        $carrier->save();

        return  $this->sendResponse($carrier ? $carrier->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Carrier::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Carrier::destroy($id) ? true : false);
    }

}