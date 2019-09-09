<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SavePaymentRequest extends FormRequest
{

    public function rules()
    {
        $payment_id = $this->input('payment.id');

        return [
            'payment.id'             => ($payment_id ? 'exists:payments,id' : 'nullable'),
            'payment.name'           => 'required|max:255',
            'payment.logo'           => $this->file('payment.logo')  ? 'image|mimes:jpeg,jpg,png,gif|max:5000' : 'nullable',
        ];


    }

    public function attributes()
    {
        return [
            'payment.id'             => "'Курьер ID'",
            'payment.name'           => "'Название'",
            'payment.logo'           => "'Логотип'"
        ];
    }

}