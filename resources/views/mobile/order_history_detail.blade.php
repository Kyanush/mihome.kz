@extends('layouts.mobile')

<?php $title = 'Заказ №:' . $order->id;?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $title . '</a>',
        'search_show' => false,
        'menu_link'   => '',
        'menu_class'  => 'icon_menu'
    ])
    @include('mobile.includes.space', ['style' => ''])



    <h2 class="container-title">Детали заказа</h2>
    <div class="container">
        <table width="100%">
            <tbody>
                <tr>
                    <td><b>Статус заказа:</b></td>
                    <td>{{ $order->status->name ?? 'Нет' }}</td>
                </tr>
                <tr>
                    <td><b>Способ оплаты:</b></td>
                    <td>{{ $order->payment->name ?? 'Нет'}}</td>
                </tr>
                <tr>
                    <td><b>Дата заказа:</b></td>
                    <td>{{ date('d.m.Y H:i', strtotime($order->created_at))  }}</td>
                </tr>
                <tr>
                    <td><b>Комментарий к заказу:</b></td>
                    <td>{{ $order->comment ? $order->comment : 'Нет' }}</td>
                </tr>
                <tr>
                    <td><b>Оплачен:</b></td>
                    <td>{{ $order->paid == 1 ? 'Да' : 'Нет'}}</td>
                </tr>
                <tr>
                    <td><b>Дата оплаты:</b></td>
                    <td>{{ $order->payment_date ? date('d.m.Y H:i', strtotime($order->payment_date)) : 'Нет' }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    @if(isset($order->carrier) or $order->shippingAddress)
        <h2 class="container-title">Доставка</h2>
        <div class="container">
                <table width="100%">
                    <tbody>
                        @if(isset($order->carrier))
                            <tr>
                                <td><b>{{ $order->carrier->name }}</b></td>
                                <td>{{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}</td>
                            </tr>
                        @endif
                        @if($order->shippingAddress)
                            <tr>
                                <td><b>Адрес доставки:</b></td>
                                <td>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->address}}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </div>
    @endif



    <h2 class="container-title">Товары</h2>
    @foreach($order->products as $product)
        <div class="container">
            <table width="100%">
                <tbody>
                        <tr>
                            <td width="100px">
                                <a href="{{ $product->detailUrlProduct() }}">
                                    <img src="{{ $product->getPhoto() }}" height="50">
                                </a>
                            </td>
                            <td>
                                <table>
                                    <tbody>
                                        <td colspan="2">
                                            <a href="{{ $product->detailUrlProduct() }}">
                                                {{ $product->pivot->name }}
                                            </a>
                                        </td>
                                        <tr>
                                            <td><b>Количество:</b></td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Цена:</b></td>
                                            <td>{{ \App\Tools\Helpers::priceFormat($product->pivot->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Итого:</b></td>
                                            <td>{{ \App\Tools\Helpers::priceFormat($product->pivot->quantity * $product->pivot->price) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                </tbody>
            </table>
        </div>
    @endforeach

    <h2 class="container-title">Итого</h2>
    <div class="container">
        <table width="100%">
            <tr>
                <td><b>Доставка @if(isset($order->carrier))({{ $order->carrier->name }})@endif:</b></td>
                <td>
                    @if(isset($order->carrier))
                        {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>Итого:</b></td>
                <td>{{ \App\Tools\Helpers::priceFormat($order->total) }}</td>
            </tr>
        </table>
    </div>


    <?php $statusHistories = $order->statusHistory()->OrderBy('id', 'DESC')->get(); ?>
    @if(count($statusHistories) > 0)
        <h2 class="container-title">История заказов</h2>
        <div class="container">
            <table width="100%">
                <thead>
                    <tr>
                        <td><b>Дата</b></td>
                        <td><b>Статус</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statusHistories as $statusHistory)
                        <tr>
                            <td>
                                {{ date('d.m.Y H:i', strtotime($statusHistory->created_at))  }}
                            </td>
                            <td>
                                {{ $statusHistory->status->name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif


    @include('mobile.includes.footer')

@endsection