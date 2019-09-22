@extends('layouts.mobile')

<?php $title = 'Мои заказы';?>
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


   @foreach($orders as $order)
      <h2 class="container-title">
            <b>Заказ №:{{ $order->id }}</b>
      </h2>
      <div class="container">
         <table width="100%">
            <tr>
                  <td><b>Дата:</b></td>
                  <td>{{ date('d.m.Y H:i', strtotime($order->created_at))  }}</td>
            </tr>
            <tr>
                 <td><b>Количество товара:</b></td>
                 <td>{{ $order->products_count }}</td>
            </tr>
            <tr>
               <td><b>Итого:</b></td>
               <td>{{ \App\Tools\Helpers::priceFormat($order->total) }}</td>
            </tr>
            <tr>
               <td><b>Статус:</b></td>
               <td>{{ $order->status->name }}</td>
            </tr>
            <tr>
               <td colspan="2" class="text-center" width="100%">
                  <br/>
                  <a class="button" href="/order-history/{{ $order->id }}">
                     Просмотр
                  </a>
               </td>
            </tr>
         </table>
      </div>
   @endforeach



   @include('mobile.includes.footer')

@endsection