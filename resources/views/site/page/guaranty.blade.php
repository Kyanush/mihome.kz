@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

       <?php $breadcrumbs = [
           [
               'title' => 'Главная',
               'link'  => '/'
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
               @include('includes.guaranty_text')
           </div>
       </div>


@endsection