@extends('layouts.mobile')

<?php $title = "Личный кабинет"; ?>
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
   @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

   <div class="container">
         <table width="100%">
               <tbody>
                  <tr>
                     <td><b>Имя:</b></td>
                     <td>
                        {{ $user->name }}
                     </td>
                  </tr>
                  <tr>
                     <td><b>Фамилия:</b></td>
                     <td>
                        {{ $user->surname }}
                     </td>
                  </tr>
                  <tr>
                     <td><b>E-mail:</b></td>
                     <td>
                        {{ $user->email }}
                     </td>
                  </tr>
                  <tr>
                     <td><b>Телефон:</b></td>
                     <td>
                        {{ $user->phone }}
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" class="text-center">
                        <br/>
                        <a class="button" href="/account-edit">
                           Изменить
                        </a>
                     </td>
                  </tr>
               </tbody>
         </table>
   </div>

   @include('mobile.includes.footer')

@endsection