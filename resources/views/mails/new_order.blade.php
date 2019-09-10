@extends('layouts.mail')
@section('content')

    <div style="font-size:13px;color:#272727;">Ваш заказ принят в обработку, № заказа

        <a href="{{ route('order_history_detail', ['order_id' => $order->id]) }}" style="color:#ff7835;"  class="daria-goto-anchor" target="_blank" rel="noopener noreferrer">
            {{ $order->id }}
        </a>

        от <span class="wmi-callto">{{ date('d.m.Y H:i', strtotime($order->created_at))  }}</span>.<br>
        ​В ближайшее время с вами свяжется наш мененджер.</div>

    <div>
        <div style="margin-top:33px;"><table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                <thead>
                <tr>
                    <td style="font-size:12px;background-color:#f1f1f1;text-align:left;padding:7px 7px 7px 15px;color:#545454;line-height:29px;border-radius:21px 0 0 21px;">Артикул</td>
                    <td style="font-size:12px;background-color:#f1f1f1;text-align:left;padding:7px;color:#545454;line-height:29px;width: 250px;">Товар</td>
                    <td style="font-size:12px;background-color:#f1f1f1;text-align:left;padding:7px;color:#545454;line-height:29px;">Количество</td>
                    <td style="font-size:12px;background-color:#f1f1f1;text-align:left;padding:7px;color:#545454;line-height:29px;">Цена</td>
                    <td style="font-size:12px;background-color:#f1f1f1;text-align:left;padding:7px;color:#545454;line-height:29px;border-radius:0 21px 21px 0;">Стоимость</td>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td style="font-size:12px;text-align:left;padding:20px 7px 20px 15px;border-bottom:1px solid #ececec;color:#aeaeae;">{{ $product->pivot->sku }}</td>
                        <td style="width: 250px;font-size:12px;text-align:left;padding:20px 7px;border-bottom:1px solid #ececec;">
                            <a href="{{ $product->detailUrlProduct() }}" target="_blank" class="daria-goto-anchor" rel="noopener noreferrer">
                                <img style="float: left;" width="40" src="{{ env('APP_URL') . $product->pathPhoto(true) }}"/>
                                <div style="float: left;margin-left: 10px;margin-top: 16px;">
                                    {{ $product->pivot->name }}
                                </div>
                            </a>
                        </td>
                        <td style="font-size:12px;text-align:left;padding:20px 7px;border-bottom:1px solid #ececec;">
                            {{ $product->pivot->quantity }}
                        </td>
                        <td style="font-size:12px;text-align:left;padding:20px 7px;border-bottom:1px solid #ececec;">
                            {{ \App\Tools\Helpers::priceFormat($product->pivot->price) }}
                        </td>
                        <td style="font-size:12px;text-align:left;padding:20px 7px;border-bottom:1px solid #ececec;">
                            {{ \App\Tools\Helpers::priceFormat($product->pivot->quantity * $product->pivot->price) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>

        @if(isset($order->carrier))
            <div style="padding:13px 20px 15px 80px;overflow:hidden;">
                <div style="float:left;width:356px;">
                    <span style="font-weight:bold;color:#434343;">Доставка:</span>
                    <span style="color:#8d8c8c;">
                                {{ $order->carrier->name }}
                            </span>
                </div>
                <div style="float:right;font-weight:bold;color:#333333;">
                    {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                </div>
            </div>
        @endif

        <div style="background:#f9f9f9;overflow:hidden;height:42px;">
            <div style="float:right;background:#fe8c2c;float:right;">
                <div style="font-size:15px;color:#fff;padding-left:40px;padding-right:25px;height:42px;line-height:42px;float:left;">Всего к оплате:</div>

                <div style="font-size:20px;color:#fff;padding-left:40px;padding-right:25px;height:42px;line-height:42px;float:left;border-left:1px dashed #f4872a;">
                    {{ \App\Tools\Helpers::priceFormat($order->total()) }}
                </div>
            </div>
        </div>
    </div>

    <div style="padding-top:28px;margin-bottom:70px;">
        <div style="color:#333333;font-weight:bold;">
            <span style="border-bottom:1px dashed #e6e6e6;display:inline-block;padding-bottom:5px;margin-bottom:20px;">Информация о заказе:</span>
        </div>



        <div style="color:#a3a3a3;">Статус заказа:
            <span style="color:#272727;">
                        {{ $order->status->name ?? 'Нет' }}
                    </span>
        </div>

        <div style="color:#a3a3a3;">Способ оплаты:
            <span style="color:#272727;">
                       {{ $order->payment->name ?? 'Нет'}}
                    </span>
        </div>

        <div style="color:#a3a3a3;">Оплачен:
            <span style="color:#272727;">
                       {{ $order->paid == 1 ? 'Да' : 'Нет'}}
                    </span>
        </div>

        @if($order->payment_date)
            <div style="color:#a3a3a3;">Дата оплаты:
                <span style="color:#272727;">
                           {{ date('d.m.Y H:i', strtotime($order->payment_date))  }}
                        </span>
            </div>
        @endif


        &nbsp;

        <div style="color:#a3a3a3;">ФИО:
            <span style="color:#272727;">
                        {{ $order->user->name }} {{ $order->user->surname }}
                    </span>
        </div>

        <div style="color:#a3a3a3;">Мобильный телефон:
            <span style="color:#272727;">
                        <span class="wmi-callto">
                            <a href="tel:{{ $order->user->phone }}">
                                {{ $order->user->phone }}
                            </a>
                        </span>
                    </span>
        </div>

        <div style="color:#a3a3a3;">Электронная почта:
            <span style="color:#272727;">
                        <a href="mailto:{{ $order->user->email }}" class="ns-action">
                            {{ $order->user->email }}
                        </a>
                    </span>
        </div>

        @if($order->shippingAddress)
            &nbsp;
            <div style="color:#a3a3a3;">Адрес доставки:
                <span style="color:#272727;">
                            <span class="wmi-callto">
                                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->address}}
                            </span>
                        </span>
            </div>
        @endif

        <div style="color:#a3a3a3;">Комментарий к заказу:
            <span style="color:#272727;">
                        {{ $order->comment }}
                    </span>
        </div>


    </div>
@endsection
