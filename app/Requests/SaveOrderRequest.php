<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
{

    public function rules()
    {
        $order = $this->input('order');

        $rules = [
            'order.id'                  => $order['id']      ? 'exists:orders,id' : 'nullable',
            'order.user_id'             => $order['user_id'] ? 'exists:users,id'  : 'nullable',
            'order.status_id'           => 'exists:order_statuses,id',
            'order.carrier_id'          => ($order['carrier_id'] ? 'exists:carriers,id' : 'nullable'),
            'order.comment'             => 'max:500',
            'order.delivery_date'       => 'nullable|date_format:"Y-m-d H:i:s"',
            'order.payment_id'          => ($order['payment_id'] ? 'exists:payments,id' : 'nullable'),
            'order.paid'                => 'integer|min:0|max:1',
            'order.payment_date'        => 'nullable|date_format:"Y-m-d H:i:s"',
            'order.created_at'          => 'required|date_format:"Y-m-d H:i:s"',

            'order.address'             => 'max:255',
            'order.city'                => 'max:255',
            'order.user_name'           => 'max:255',
            'order.user_phone'          => 'max:255' . ($order['user_phone'] ? '|phone' : 'nullable'),
            'order.user_email'          => 'max:255' . ($order['user_email'] ? '|email' : 'nullable'),

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
            'order.comment'             => "'Комментарии'",
            'order.delivery_date'       => "'Дата доставки'",
          //'order.total'               => "''",
            'order.payment_id'          => "'Тип оплаты'",
            'order.paid'                => "'Оплачен'",
            'order.payment_date'        => "'Дата оплаты'",
          //'order.payment_result'      => "''",
            'order.created_at'          => "'Дата заказа'",
          //'order.updated_at'          => "''",

            'order.address'             => 'Адрес',
            'order.city'                => 'Город',
            'order.user_name'           => 'Имя клиента',
            'order.user_phone'          => 'Телефон клиента',
            'order.user_email'          => 'Почта клиента',

            'order.products'            => "'Товары'"
        ];

        return $attributes;
    }

}
