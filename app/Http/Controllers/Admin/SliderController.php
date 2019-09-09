<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Slider;
use App\Requests\SaveSliderRequest;
use Illuminate\Http\Request;

class SliderController extends AdminController
{

    public function list(Request $request)
    {
        $list =  Slider::search($request->input('search'))
                        ->OrderBy('ID', 'DESC')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SaveSliderRequest $request)
    {
        $data = $request->all();
        $data = $data['slider'];

        $slider = Slider::findOrNew($data["id"]);
        $slider->fill($data);
        $slider->save();

        return  $this->sendResponse($slider ? $slider->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Slider::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Slider::destroy($id) ? true : false);
    }

}