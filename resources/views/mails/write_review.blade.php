@extends('layouts.mail')
@section('content')

    <p>Товар ID:     {{ $data->product_id }}</p>
    <p>Недостатки:   {{ $data->minus }}</p>
    <p>Достоинства:  {{ $data->plus }}</p>
    <p>Ваш e-mail:   {{ $data->email }}</p>
    <p>Комментарий:  {{ $data->comment }}</p>
    <p>Ваше имя:     {{ $data->name }}</p>
    <p>Оценка:       {{ $data->rating }}</p>

@endsection