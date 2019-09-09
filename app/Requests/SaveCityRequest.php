<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCityRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'name'       => 'max:255',
            'code'       => 'max:255',
            'sort'       => 'numeric',
            'active'     => 'numeric'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name'       => 'Название',
            'code'       => 'Код',
            'sort'       => 'Сортировка',
            'active'     => 'Активно'
        ];
    }

}