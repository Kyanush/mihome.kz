@extends('layouts.mail')
@section('content')

    <p>Недостатки:   {{ $data->minus }}</p>
    <p>Достоинства:  {{ $data->plus }}</p>
    <p>Ваш e-mail:   {{ $data->email }}</p>
    <p>Комментарий:  {{ $data->comment }}</p>
    <p>Ваше имя:     {{ $data->name }}</p>
    <p>Оценка:       {{ $data->rating }}</p>

    <p>Товар:
        {{ $data->product->name }}
        &nbsp;
        <a href="{{ $data->product->detailUrlProductAdmin() }}">Изменить</a>
        &nbsp;
        <a href="{{ $data->product->detailUrlProduct() }}">Посмотреть</a>
    </p>

    <p><a href="{{ env('APP_URL') }}/admin/reviews?review_id={{ $data->id }}">Актировать отзыв</a></p>

@endsection
