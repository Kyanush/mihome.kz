@extends('layouts.mail')
@section('content')

    <p>Вы просили информацию о наличии товара <a href="{{ $product->detailUrlProduct() }}">
        {{ $product->name }}</a>.
    </p>
    <p>Товар <a href="{{ $product->detailUrlProduct() }}">
        {{ $product->name }}</a> поступил на склад и Вы можете его приобрести на сайте
    </p>

@endsection