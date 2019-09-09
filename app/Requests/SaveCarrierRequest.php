<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCarrierRequest extends FormRequest
{

    public function rules()
    {
        $carrier_id = $this->input('carrier.id');

        return [
            'carrier.id'             => ($carrier_id ? 'exists:carriers,id' : 'nullable'),
            'carrier.name'           => 'required|max:255',
            'carrier.price'          => 'min:0',
            'carrier.delivery_text'  => 'max:500',
            'carrier.logo'           => $this->file('carrier.logo')  ? 'image|mimes:jpeg,jpg,png|max:5000' : 'nullable',
        ];


    }

    public function attributes()
    {
        return [
            'carrier.id'             => "'Курьер ID'",
            'carrier.name'           => "'Название'",
            'carrier.price'          => "'Цена'",
            'carrier.delivery_text'  => "'Описание'",
            'carrier.logo'           => "'Логотип'"
        ];
    }

}