<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class WriteReviewRequestSite extends FormRequest
{

    public function rules()
    {
        $rules = [
            'product_id' => 'exists:products,id',
            'minus'      => 'max:500',
            'plus'       => 'max:500',
            'email'      => 'max:255',
            'comment'    => 'required|',
            'name'       => 'required|max:500',
            'rating'     => 'required|integer|max:5|min:1'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'product_id' => "'Товар ID'",
            'minus'      => "'Недостатки'",
            'plus'       => "'Достоинства'",
            'email'      => "'Ваш e-mail'",
            'comment'    => "'Комментарий'",
            'name'       => "'Ваше имя'",
            'rating'     => "'Оценка'"
        ];
    }

}
