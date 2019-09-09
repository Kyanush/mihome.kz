<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCategoryRequest extends FormRequest
{

    public function rules()
    {
        $data = $this->request->all();
        $category_id   = $data['category']['id'] ?? 0;

        return [
            'category.name' => ['required', 'unique:categories,name' . ($category_id ? (',' . $category_id . ',id') : '')],
            'category.url'  => ['nullable', 'unique:categories,url'  . ($category_id ? (',' . $category_id . ',id') : '')]
        ];
    }

    public function attributes()
    {
        return [
            'category.name' => "'Название'",
            'category.url' => "'Url'"
        ];
    }

}