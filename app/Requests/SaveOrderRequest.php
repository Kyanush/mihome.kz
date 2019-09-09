<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'order.id'                  => ($this->input('order.id') ? 'exists:orders,id' : 'nullable'),
            'order.user_id'             => 'exists:users,id',
            'order.status_id'           => 'exists:order_statuses,id',
            'order.carrier_id'          => 'exists:carriers,id',
            'order.shipping_address_id' =>  $this->input('order.shipping_address_id') ? 'exists:addresses,id' : 'nullable',
            'order.comment'             => 'max:500',
            'order.delivery_date'       => 'nullable|date_format:"Y-m-d H:i:s"',
          //'order.total'               => '',
            'order.payment_id'          => 'exists:payments,id',
            'order.paid'                => 'integer|min:0|max:1',
            'order.payment_date'        => 'nullable|date_format:"Y-m-d H:i:s"',
          //'order.payment_result'      => '',
            'order.created_at'          => 'required|date_format:"Y-m-d H:i:s"',
          //'order.updated_at'          => 'nullable|date_format:"Y-m-d H:i:s"',
            'order.products'            => 'required'
        ];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'order.id'                  => "'Заказ ID'",
            'order.user_id'             => "'Клиент'",
            'order.status_id'           => "'Статус'",
            'order.carrier_id'          => "'Курьер'",
            'order.shipping_address_id' => "'Адреса'",
            'order.comment'             => "'Комментарии'",
            'order.delivery_date'       => "'Дата доставки'",
          //'order.total'               => "''",
            'order.payment_id'          => "'Тип оплаты'",
            'order.paid'                => "'Оплачен'",
            'order.payment_date'        => "'Дата оплаты'",
          //'order.payment_result'      => "''",
            'order.created_at'          => "'Дата заказа'",
          //'order.updated_at'          => "''",
            'order.products'            => "'Товары'"
        ];

        return $attributes;
    }

}