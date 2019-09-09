@extends('layouts.site')

@section('title',       'Новости')
@section('description', 'Новости о компании '. env('APP_NO_URL'))
@section('keywords',    'Новинки, Обзоры, Сравнения')

@section('content')


        @include('site.includes.breadcrumb', ['breadcrumbs' => [
           [
               'title' => 'Главная',
               'link'  => '/',
           ],

           [
               'title' => 'Новости',
               'link'  => ''
           ]
       ]])

        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <h1>Новости</h1>
                <br/>
                @include('site.news.widget', ['news' => $news])
                <br/>
                {!! $news->links("pagination::default") !!}
            </div>
        </div>

@endsection
