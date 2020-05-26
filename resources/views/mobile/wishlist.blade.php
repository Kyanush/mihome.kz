@extends('layouts.mobile')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $seo['title'] . '</a>',
            'search_show' => false,
            'menu_link'   => '',
            'menu_class'  => 'icon_menu'
            ])
        @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

         @include('mobile.includes.message')

          @if(count($wishlist) == 0)
             <div class="container">
                У Вас нет закладок
             </div>
          @else
             @foreach($wishlist as $item)
                <div>
                   <div class="header-cart__content">
                      <a href="{{ $item->product->detailUrlProduct() }}"class="header-cart__image-wrapper">
                         <img height="105"
                              width="140"
                              class="header-cart__image"
                              src="{{ $item->product->pathPhoto(true) }}"
                              alt="{{ $item->product->name }}"
                              title="{{ $item->product->name }}"/>
                      </a>
                      <div class="header-cart__info">
                            <div class="header-cart__name">
                                  <a href="{{ $item->product->detailUrlProduct() }}" class="header-cart__name-link">
                                     {{ $item->product->name }}
                                  </a>
                                  <div class="header-cart__name-link">
                                     <b>Артикул:</b> {{ $item->product->sku }}
                                  </div>
                                  <div class="header-cart__name-link">
                                     <b>Наличие:</b> {{ $item->status->name }}
                                  </div>
                                  <div class="header-cart__name-link">
                                     <b>Цена:</b>
                                     @if($item->product->specificPrice)
                                        <s>{{ \App\Tools\Helpers::priceFormat($item->product->price) }}</s>
                                     @endif
                                     {{ \App\Tools\Helpers::priceFormat($item->product->getReducedPrice()) }}
                                  </div>
                            </div>
                      </div>
                   </div>

                   <div class="container text-center">
                      <a class="button" href="{{ route('wishlist_delete', ['product_id' => $item->product_id]) }}">
                         Удалить
                      </a>
                   </div>
                </div>
             @endforeach
          @endif

        @include('mobile.includes.footer')

@endsection