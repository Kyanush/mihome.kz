@extends('layouts.site')

<?php $title = 'Учетная запись';?>
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
                <div class="col-md-4">
                      <form action="" method="post" enctype="multipart/form-data" id="simplepage_form">
                         @csrf
                         <div class="form-group">
                            <label>Имя *</label>
                            <input class="input" type="text" name="account[name]" value="{{ $user->name }}" placeholder="Имя *">
                         </div>
                         <div class="form-group">
                            <label>Фамилия</label>
                            <input class="input" type="text" name="account[surname]" value="{{ $user->surname }}" placeholder="Фамилия">
                         </div>
                         <div class="form-group">
                            <label>Email *</label>
                            <input class="input" type="email" name="account[email]" value="{{ $user->email }}" placeholder="Электронная почта *">
                         </div>
                         <div class="form-group">
                            <label>Телефон *</label>
                            <input class="input phone-mask" type="tel" name="account[phone]" value="{{ $user->phone }}" placeholder="Мобильный телефон *">
                         </div>
                         <div class="form-group">
                              <button class="btn btn-firm">Изменить</button>
                         </div>
                      </form>
                </div>
             </div>
             <!-- /row -->
          </div>
          <!-- /container -->
       </div>
       <!-- /SECTION -->




@endsection