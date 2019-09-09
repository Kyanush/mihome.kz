@extends('layouts.reports')
@section('content')

    <table border="1">
        <thead>
            <tr>
                <td>Категория</td>
                <td>Название</td>
                <td>Описание</td>
                <td>Цена</td>
                <td>Фото</td>
                <td>Популярный товар</td>
                <td>В наличии</td>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                @php
                    $description = '';
                    foreach($product->attributes as $attribute)
                        if(!in_array($attribute->id, [49, 61, 62]) and $attribute->pivot->value)
                        {
                            if(strlen($description . $attribute->name . ': ' . $attribute->pivot->value . ', ') > 500)
                                break;

                            $description.= $attribute->name . ': ' . $attribute->pivot->value . ', ';
                        }
                @endphp
                <tr>
                    <td>{{ $product->categories[0]->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{!! $description !!}</td>
                    <td>{{ $product->getReducedPrice() }}</td>
                    <td>{{ env('APP_URL') . $product->pathPhoto(true) }}</td>
                    <td>Нет</td>
                    <td>{{ $product->stock > 0 ? 'Да' : 'Нет'}}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endsection