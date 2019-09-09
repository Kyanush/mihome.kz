<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\News;
use App\Requests\SaveNewsRequest;
use Illuminate\Http\Request;

class NewsController extends AdminController
{

    public function list(Request $request)
    {
        $list =  News::search($request->input('search'))
                        ->OrderBy('ID', 'DESC')
                        ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function save(SaveNewsRequest $request)
    {
        $data = $request->all();
        $data = $data['news'];

        $news = News::findOrNew($data["id"]);
        $news->fill($data);
        $news->save();

        return  $this->sendResponse($news ? $news->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            News::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(News::destroy($id) ? true : false);
    }

}