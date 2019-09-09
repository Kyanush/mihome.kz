@extends('layouts.mail')
@section('content')

    <div>Здравствуйте, <b>{{ $order->user->name }}</b></div>
    <br/>
    <div>Ваш заказ № <a href="{{ route('order_history_detail', ['order_id' => $order->id]) }}"> <b>{{ $order->id }}</b></a></div>
    <br/>
    <div>Статус вашего заказа: <b>{{ $order->status->name }}</b></div>

@endsection