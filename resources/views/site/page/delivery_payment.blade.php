@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

       <?php $breadcrumbs = [
           [
               'title' => 'Главная',
               'link'  => env('APP_URL')
           ],
           [
               'title' => $seo['title'],
               'link'  => ''
           ]
       ];?>
      @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

       <!-- SECTION -->
       <div class="section">
           <!-- container -->
           <div class="container">
               @include('includes.delivery_payment_text')
           </div>
       </div>

@endsection
