@php
    $address = config('shop.address');
    $number_phones = config('shop.number_phones');
@endphp

<h3>Доставка по Алматы</h3>
<p>Доставка по городу Алматы <b>бесплатно</b> осуществляется в течение одного дня, в зависимости от занятости курьера.</p>
<p>Мы всегда рады подстроиться под пожелания покупателя, и учитываем не только желаемую вами дату и время.</p>
<p>Чтобы сделать заказ, вам нужно оставить заявку на нашем сайте, с указанием адреса доставки.</p>
<p>Либо позвонить в наш call center ежедневно {{ $address[0]['working_hours'] }} номерам:
@foreach($number_phones as $phone)
    <a style="font-size: 14px;text-decoration: none;"  href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
@endforeach
.</p>

<p>*при согласовании даты и времени отправки и получения вами товара, учитывается время работы основного склада.</p>
<p>
    Возможен самовывоз по адресу:
    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
    Тел.
    @foreach($number_phones as $phone)
        <a style="font-size: 14px;text-decoration: none;"  href="tel: {{ $phone['number'] }}"> {{ $phone['format'] }}</a>
    @endforeach
</p>
<p>Режим работы офиса: {{ $address[0]['working_hours'] }}.</p>

<p>*Перерыв в пятницу с 13:00 до 15:00</p>



<h3>Доставка по казахстану</h3>
<p>Наш товар может отправиться в любой город <b>Казахстана</b> 2000 тг с помощью компании "Qazaq Sapa Delivery".</p>
<p>Доставка осуществляется от 3 до 4 дней. Оплата за счет покупателя.</p>
<p>С расценками можно ознакомиться на сайте qsd.kz. Там же вы можно увидеть передвижение вашего груза</p>