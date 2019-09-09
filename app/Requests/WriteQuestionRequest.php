<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class WriteQuestionRequest extends FormRequest
{

    public function rules()
    {
        $isAdmin = false;
        if(Auth::check())
            if(Auth::user()->role->name == 'admin')
                $isAdmin = true;

        $rules = [
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|max:255',
            'email'      => ($isAdmin ? ''          : 'required|') . 'max:255',
            'question'   => 'required|max:1000',
            'answer'     => ($isAdmin ? 'required|' : '')          . 'max:1000',
        ];

        if($isAdmin)
            $rules['created_at'] = 'required|date_format:"Y-m-d H:i:s"';

        return $rules;
    }


    public function attributes()
    {
        return [
            'product_id' => "'Товар ID'",
            'name'       => "'Имя'",
            'email'      => "'Почта'",
            'question'   => "'Вопрос'",
            'answer'     => "'Ответ'",
            'created_at' => "'Дата'"
        ];
    }

}