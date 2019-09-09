@extends('layouts.mail')
@section('content')

    <p>Ваш вопрос: {{ $data->question }}</p>
    <p>Ответ администратора: {{ $data->answer }}</p>
    <p>Товар: <a href="{{ $data->product->detailUrlProduct() }}">{{ $data->product->name }}</a></p>

@endsection