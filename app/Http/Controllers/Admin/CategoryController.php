<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Category;
use App\Requests\SaveCategoryRequest;
use App\Services\ServiceCategory;
use Illuminate\Http\Request;
use DB;

class CategoryController extends AdminController
{

    public function list(Request $request)
    {
        $list =  Category::with(['parent' => function($query){
                    $query->select(['id', 'name']);
                 }])
                ->search($request->input('search'))
                ->OrderBy('id', 'DESC')
                ->paginate($request->input('per_page', 10));

        foreach ($list as $k => $item)
            $list[ $k ]->path_image = $item->pathImage(true);

        return  $this->sendResponse($list);
    }

    public function save(SaveCategoryRequest $request)
    {
        $data = $request->all();
        $data = $data['category'];

        $category = Category::findOrNew($data["id"]);
        $category->fill($data);
        $category->save();

        return  $this->sendResponse($category ? $category->id : false);
    }


    public function view($id)
    {
        $category = Category::findOrFail($id);
        $category->path_image = $category->pathImage(true);

        return  $this->sendResponse($category);
    }

    public function delete($id)
    {
        return  $this->sendResponse(Category::destroy($id) ? true : false);
    }

    public function catalogsTree($type = 1)
    {
        return  $this->sendResponse(
            ServiceCategory::catalogsTree($type)
        );
    }

    public function reorderSave(Request $request)
    {
        $data = $request->input('reorder_send');

        foreach ($data as $item)
        {
            $category = Category::find($item["id"]);
            $category->fill($item);
            $category->save();
        }
        return  $this->sendResponse(true);
    }



}
