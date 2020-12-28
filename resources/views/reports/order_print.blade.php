<!DOCTYPE html>
<html>
<head>
    <title>fffffffffff</title>
</head>
<body>




<table width="100%">
    <tbody>
        <tr>
            <td colspan="3" align="center">

                <img width="50" src="https://1service.kz/site/images/logo.png"/>

                <h3 align="center">
                    1Service.kz - сервисный центр
                </h3>
            </td>
        </tr>
        <tr>
            <td>
                <b>Cайт:</b> 1service.kz
                <br/>
                <b>Телефон:</b> +7 (706) 410-20-20
                <br/>
                <b>Режим работы:</b> 10:00-19:00(без выходных)
            </td>
            <td></td>
            <td align="right">
                <b>Адрес:</b> г. Алматы Жибек Жолы 115 <br/> 1 этаж, офис 106
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <br/>
                <h3 align="center">Квитанция №{{ $order->id }} от {{ date('d.m.Y H:i', strtotime($order->created_at)) }}</h3>
            </td>
        </tr>

        @if($order->user_name)
        <tr>
            <td colspan="3">
                <b>ФИО:</b> {{ $order->user_name }}
            </td>
        </tr>
        @endif
        @if($order->user_phone)
        <tr>
            <td colspan="3">
                <b>Телефон:</b> {{ $order->user_phone }}
            </td>
        </tr>
        @endif
        @if($order->user_email)
        <tr>
            <td colspan="3">
                <b>Электронная почта:</b> {{ $order->user_email }}
            </td>
        </tr>
        @endif
        @if($order->city or $order->address)
        <tr>
            <td colspan="3">
                <b>Адрес доставки:</b> {{ $order->city }}, {{ $order->address}}
            </td>
        </tr>
        @endif

        @if($order->comment)
            <tr>
                <td colspan="3">
                    <b>Комментарии/неисправность:</b> {{ $order->comment }}
                </td>
            </tr>
        @endif

    </tbody>
</table>




    <h3 align="center">
        Товар/Услуга
    </h3>

    <table style="border-collapse:collapse;width:100%;margin-bottom:20px;" border="1">
        <thead>
            <tr>
                <td style="font-size:14px;background-color:#f1f1f1;text-align:left;padding:7px;color:#545454;line-height:29px;width: 400px;">Товар/Услуга</td>
                <td style="font-size:14px;background-color:#f1f1f1;text-align:right;padding:7px;color:#545454;line-height:29px;">Кол-во</td>
                <td style="font-size:14px;background-color:#f1f1f1;text-align:right;padding:7px;color:#545454;line-height:29px;">Цена</td>
                <td style="font-size:14px;background-color:#f1f1f1;text-align:right;padding:7px;color:#545454;line-height:29px;border-radius:0 21px 21px 0;">Сумма</td>
            </tr>
        </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td style="width: 75%;font-size:12px;text-align:left;padding:3px;border-bottom:1px solid #ececec;">
                          {{ $product->pivot->name }}
                          @if($product->pivot->serial_number)
                             <br/>
                             Серийный номер/IMEI: {{ $product->pivot->serial_number }}
                          @endif
                    </td>
                    <td style="font-size:12px;text-align:right;padding:3px;border-bottom:1px solid #ececec;">
                        {{ $product->pivot->quantity }}
                    </td>
                    <td style="font-size:12px;text-align:right;padding:3px;border-bottom:1px solid #ececec;">
                        {{ \App\Tools\Helpers::priceFormat($product->pivot->price) }}
                    </td>
                    <td style="font-size:12px;text-align:right;padding:3px;border-bottom:1px solid #ececec;">
                        {{ \App\Tools\Helpers::priceFormat($product->pivot->quantity * $product->pivot->price) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        <tfoot>

            @if(isset($order->carrier) and request()->type == 'order')
                <tr>
                    <td colspan="5" style="text-align: right">
                        <b>Доставка:</b>
                        {{ $order->carrier->name }}
                        {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                    </td>
                </tr>
            @endif

            @if($order->payment)
                <tr>
                    <td colspan="5" style="text-align: right">
                        <b>Способ оплаты:</b>
                        {{ $order->payment->name ?? 'Нет'}}
                    </td>
                </tr>
            @endif

            <tr>
                <td colspan="5" style="text-align: right">
                    <b>Всего к оплате:</b>
                    {{ \App\Tools\Helpers::priceFormat($order->total()) }}
                </td>
            </tr>

        </tfoot>
    </table>











    @if(request()->type == 'phone')
        <p>
            1. Сервисный центр не несет ответственности за возможную потерю данных в памяти устройства, а также за
            оставленные SIM и FLASH карты. Заблаговременно примите меры по резервированию информации.
            <br/>

            2. Заказчик принимает на себя риск возможной полной или частичной утраты работоспособности устройства в
            процессе ремонта, в случае грубых нарушений пользователем условий эксплуатации, наличия следов
            попадания токопроводящей жидкости (коррозии), либо механических повреждений.<br/>

            2.1 Заказчик согласен с возможными дополнительными неисправностями, которые могут быть выявлены во
            время ремонта или диагностики, и берет на себя все финансовые обязательства.<br/>

            3. Гарантия не распространяется и не продлевается на устройства, восстановленные после попадания
            жидкости.<br/>

            4. Срок хранения аппарата 30 дней с ориентировочной даты готовности. По окончании этого срока аппарат
            утилизируется и претензии по нему не принимаются.<br/>

            5. В случае утери квитанции, устройство выдается по предъявлению паспорта на имя заказчика.<br/>

            6. Заказчик дает согласие на сбор и обработку его персональных данных.<br/>
        </p>

        <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
            <tbody>
                <tr>
                    <td colspan="4" align="right">
                        <br/>
                        подпись _______________________
                        <br>
                        с условиями ремонта ознакомлен и согласен
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <br/>
                        - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <br/>
                        <br/>
                        Печать
                    </td>
                </tr>
            </tbody>
        </table>
    @endif


</body>
</html>