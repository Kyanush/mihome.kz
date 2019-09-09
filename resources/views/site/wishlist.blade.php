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
            'title' => 'Личный кабинет',
            'link'  => '/my-account'
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
            <!-- row -->
            <div class="row">
                <div class="col-md-3">
                    @include('site.includes.menu_left_my_account')
                </div>
                <div class="col-md-9">
                        @auth
                            @if(count($wishlist) == 0)
                                <p>У Вас нет закладок</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Изображение</th>
                                                <th scope="col">Наименование товара</th>
                                                <th scope="col">Артикул</th>
                                                <th scope="col" width="100">Наличие</th>
                                                <th scope="col" width="100">Цена</th>
                                                <th scope="col">Действие</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($wishlist as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ $item->product->detailUrlProduct() }}">
                                                            <img src="{{ $item->product->pathPhoto(true) }}"
                                                                 alt="{{ $item->product->name }}"
                                                                 width="50"
                                                                 title="{{ $item->product->name }}">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $item->product->detailUrlProduct() }}">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $item->product->sku }}
                                                    </td>
                                                    <td>
                                                        {{ $item->product->stock > 0 ? 'В наличии' : 'Нет в наличии' }}
                                                    </td>
                                                    <td>
                                                        {{ \App\Tools\Helpers::priceFormat($item->product->getReducedPrice()) }}
                                                        @if($item->product->specificPrice)
                                                            <br/>
                                                            <del>
                                                                {{ \App\Tools\Helpers::priceFormat($item->product->price) }}
                                                            </del>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('wishlist_delete', ['product_id' => $item->product_id]) }}" class="firm-red">
                                                            <i class="fa fa-remove" alt="Удалить" title="Удалить"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            <p>Пожалуйста, авторизуйтесь.</p>
                        @endguest
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

@endsection