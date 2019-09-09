@extends('layouts.site')

<?php $title = 'Мои заказы';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

       <?php $breadcrumbs = [
           [
               'title' => 'Главная',
               'link'  => '/'
           ],
           [
               'title' => 'Личный кабинет',
               'link'  => '/my-account'
           ],
           [
               'title' => $title,
               'link'  => ''
           ]
       ];?>

      @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

       <!-- SECTION -->
       <div class="section">
          <!-- container -->
          <div class="container">
             <!-- row -->
             <div class="row">
                <div class="col-md-3">
                   @include('site.includes.menu_left_my_account')
                </div>
                <div class="col-md-9">
                   <div class="table-responsive">
                      <table class="table table-striped">
                         <thead>
                             <tr>
                                <td><b>№ заказа</b></td>
                                <td><b>Дата</b></td>
                                <td><b>Товаров</b></td>
                                <td><b>Итого</b></td>
                                <td><b>Статус</b></td>
                                <td></td>
                             </tr>
                         </thead>
                         <tbody>
                               @foreach($orders as $order)
                                  <tr>
                                     <td>{{ $order->id }}</td>
                                     <td>{{ date('d.m.Y H:i', strtotime($order->created_at))  }}</td>
                                     <td>
                                        {{ $order->products_count }}
                                     </td>
                                     <td>
                                        {{ \App\Tools\Helpers::priceFormat($order->total) }}
                                     </td>
                                     <td>
                                        {{ $order->status->name }}
                                     </td>
                                     <td>
                                        <a href="/order-history/{{ $order->id }}">
                                            <i class="fa fa-search firm-red" alt="Просмотр" title="Просмотр"></i>
                                        </a>
                                     </td>
                                  </tr>
                               @endforeach
                         </tbody>
                      </table>
                   </div>
                </div>
             </div>
             <!-- /row -->
          </div>
          <!-- /container -->
       </div>
       <!-- /SECTION -->

@endsection