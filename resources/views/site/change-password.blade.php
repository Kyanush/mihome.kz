@extends('layouts.site')

<?php $title = "Смена пароля"; ?>
@section('title',       $title)
@section('description', $title)
@section('keywords',    $title)

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
       <div class="section" id="checkout">
           <!-- container -->
           <div class="container">
               <!-- row -->
               <div class="row">
                   <div class="col-md-3">
                       @include('site.includes.menu_left_my_account')
                   </div>
                   <div class="col-md-3">
                       <form action="" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group">
                               <label>Пароль *</label>
                               <input class="input" type="password" name="password" value="">
                           </div>
                           <div class="form-group">
                               <label>Подтвердите пароль *</label>
                               <input class="input" type="password" name="password_confirmation" value="">
                           </div>
                           <div class="form-group">
                               <button class="btn btn-firm">Изменить</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>

@endsection