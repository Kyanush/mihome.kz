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

    <div class="section">
        <div class="container">
            @include('includes.cashback_text')
        </div>
    </div>

@endsection
