@extends('layouts.mobile')

<?php $title = 'Учетная запись';?>
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

   <div class="container g-pa0 g-bb-fat g-bg-c0">
      @include('mobile.includes.message')
      <form action="" method="post" enctype="multipart/form-data" id="simplepage_form">
         @csrf

            <div class="input _focused">
               <label class="input__label">Имя</label>
               <input type="text" name="account[name]" id="edit_name" value="{{ $user->name }}" class="input__input">
            </div>
            <div class="input _focused">
               <label class="input__label">Фамилия</label>
               <input type="text" name="account[surname]" id="edit_surname" value="{{ $user->surname }}" class="input__input">
            </div>
            <div class="input _focused">
               <label class="input__label">Email</label>
               <input type="email" name="account[email]" id="edit_email" value="{{ $user->email }}" class="input__input">
            </div>
            <div class="input _focused">
               <label class="input__label">Телефон</label>
               <input type="tel" name="account[phone]" id="edit_phone" value="{{ $user->phone }}" class="phone-mask input__input">
            </div>

            <button type="submit" class="button _big _space">Изменить</button>

      </form>
   </div>

   @include('mobile.includes.footer')

@endsection