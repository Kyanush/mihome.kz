
@extends('layouts.site')

@php
    $title = 'Страница не найдена';
@endphp

@section('title',    	$title)
@section('description', $title)
@section('keywords',    $title)

@section('content')


    <div class="error-404" style="text-align: center;padding: 40px 0;">
        <h1>Страница не найдена</h1>
        <h2 style="padding: 32px;font-size: 50px;">404</h2>
        <a href="/">Перейти на главную страницу</a>
    </div>

@endsection
