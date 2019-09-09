@extends('layouts.site')

<?php $title = 'Заказ №:' . $order->id;?>
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
               'title' => 'История заказов',
               'link'  => '/order-history'
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

                       <h5 class="firm-red">Детали заказа</h5>
                       <div class="table-responsive">
                           <table class="table table-striped">
                               <tbody>
                                   <tr>
                                       <td>
                                           <b>Статус заказа:</b> {{ $order->status->name ?? 'Нет' }}<br>
                                       </td>
                                       <td>
                                           <b>Способ оплаты:</b> {{ $order->payment->name ?? 'Нет'}}
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <b>Дата заказа:</b> {{ date('d.m.Y H:i', strtotime($order->created_at))  }}<br>
                                       </td>
                                       <td>
                                           <b>Комментарий к заказу:</b>   {{ $order->comment ? $order->comment : 'Нет' }}
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>
                                           <b>Оплачен:</b>  {{ $order->paid == 1 ? 'Да' : 'Нет'}}<br>
                                       </td>
                                       <td>
                                           <b>Дата оплаты:</b>  {{ $order->payment_date ? date('d.m.Y H:i', strtotime($order->payment_date)) : 'Нет' }}
                                       </td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>

                       @if(isset($order->carrier) or isset($order->shippingAddress))
                           <h5 class="firm-red">Доставка</h5>
                           <div class="table-responsive">
                               <table class="table table-striped">
                                   <tbody>
                                       <tr>
                                           <td>
                                               @if(isset($order->carrier))
                                                   {{ $order->carrier->name }}, {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                                               @endif
                                               <br/>
                                               @if(isset($order->shippingAddress))
                                                   <b>Адрес доставки:</b> {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->address}}
                                               @endif
                                           </td>
                                       </tr>
                                   </tbody>
                               </table>
                           </div>
                       @endif

                       <h5 class="firm-red">Товары</h5>
                       <div class="table-responsive">
                           <table class="table table-striped">
                               <thead>
                                   <tr>
                                       <td>Наименование товара</td>
                                       <td>Количество</td>
                                       <td>Цена</td>
                                       <td>Итого</td>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach($order->products as $product)
                                       <tr>
                                           <td>
                                               <a href="{{ $product->detailUrlProduct() }}">
                                                   {{ $product->pivot->name }}
                                               </a>
                                           </td>
                                           <td>
                                               {{ $product->pivot->quantity }}
                                           </td>
                                           <td>
                                               {{ \App\Tools\Helpers::priceFormat($product->pivot->price) }}
                                           </td>
                                           <td>
                                               {{ \App\Tools\Helpers::priceFormat($product->pivot->quantity * $product->pivot->price) }}
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                               <tfoot>
                                   <tr>
                                       <td colspan="2"></td>
                                       <td ><b>Доставка @if(isset($order->carrier))({{ $order->carrier->name }})@endif:</b></td>
                                       <td >
                                           @if(isset($order->carrier))
                                               {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                                           @endif
                                       </td>
                                   </tr>
                                   <tr>
                                       <td colspan="2"></td>
                                       <td ><b>Итого:</b></td>
                                       <td >{{ \App\Tools\Helpers::priceFormat($order->total) }}</td>
                                   </tr>
                               </tfoot>
                           </table>
                       </div>

                       <?php $statusHistories = $order->statusHistory()->OrderBy('id', 'DESC')->get(); ?>
                       @if(count($statusHistories) > 0)
                           <h5 class="firm-red">История заказов</h5>
                           <div class="table-responsive">
                               <table class="table table-striped">
                                   <thead>
                                   <tr>
                                       <td>Дата</td>
                                       <td>Статус</td>
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

                   </div>
               </div>
               <!-- /row -->
           </div>
           <!-- /container -->
       </div>
       <!-- /SECTION -->





@endsection