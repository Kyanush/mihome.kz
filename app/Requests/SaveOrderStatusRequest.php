<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrderStatusRequest extends FormRequest
{

    public function rules()
    {
        $order_status_id = $this->input('order_status.id');

        return [
            'order_status.id'      => ($order_status_id ? 'exists:order_statuses,id' : 'nullable'),
            'order_status.name'    => 'required|max:255',
            'order_status.description'    => 'required|max:500',
            'order_status.class'     => 'required|max:45',
            'order_status.notification'   => 'required|integer|min:0|max:1',
        ];
    }

    public function attributes()
    {
        return [
            'order_status.id'      => "'Статус заказа'",
            'order_status.name'    => "'Название'",
            'order_status.description'   => "'Описание'",
            'order_status.class'    => "'Класс иконки'",
            'order_status.notification'  => "'Отправить уведомление'"
        ];
    }

}