<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SetLikeRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'review_id' =>  'exists:reviews,id',
            'like' => 'required_if:0,1'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'review_id' => "'ID отзыва'",
            'like' => "'like'"
        ];
    }

}