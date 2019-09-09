<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveBannerRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'banner.name' => 'max:255|required',
            'banner.link' => 'max:255|required',
            'banner.body' => 'required',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'banner.name' => 'Название',
            'banner.link' => 'Ссылка',
            'banner.body' => 'Тело',
        ];
    }

}