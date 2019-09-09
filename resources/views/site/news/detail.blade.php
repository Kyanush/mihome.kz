@extends('layouts.site')

@section('title',       $news->title )
@section('description', strip_tags($news->preview_text))
@section('keywords',    '')

@section('content')

        @include('site.includes.breadcrumb', ['breadcrumbs' => [
           [
               'title' => 'Главная',
               'link'  => '/',
           ],
           [
               'title' => 'Новости',
               'link'  => route('news_list')
           ],
           [
               'title' => $news->title,
               'link'  => ''
           ]
       ]])

        <!-- SECTION -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <h1>
                    {{ $news->title }}
                </h1>
                <div>
                    <p><i class="fa fa-clock-o firm-red"></i> {{ \App\Tools\Helpers::ruDateFormat($news->created_at) }}</p>
                    {!! $news->detail_text !!}
                </div>
            </div>
        </div>

@endsection
