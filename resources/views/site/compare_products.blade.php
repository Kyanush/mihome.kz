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
               'title' => $seo['title'],
               'link'  => ''
           ]
       ];?>
      @include('site.includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

       <!-- SECTION -->
       <div class="section">
           <!-- container -->
           <div class="container">

               @if(count($productFeaturesCompareList) == 0)
                   <div class="content">Вы не выбрали ни одного товара для сравнения.</div>
               @else
                   <div class="table-responsive">
                       <table class="table table-striped compare-info">
                           <tbody>
                           <tr>
                               <td>Наименование</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td class="name">
                                       <a href="{{ $item->product->detailUrlProduct() }}">
                                        <span>
                                           {{ $item->product->name }}
                                        </span>
                                       </a>
                                   </td>
                               @endforeach
                           </tr>
                           <tr>
                               <td>Изображение</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td>
                                       <img height="90"
                                            class="product-image"
                                            src="{{ $item->product->pathPhoto(true) }}"
                                            alt="{{ $item->product->name }}">
                                   </td>
                               @endforeach
                           </tr>
                           <tr>
                               <td>Цена</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td>
                                       @if($item->product->specificPrice)
                                           <span class="price-old">
                                              {{ \App\Tools\Helpers::priceFormat($item->product->price) }}
                                           </span>
                                           <br/>
                                       @endif
                                       <span class="price-new">
                                              {{ \App\Tools\Helpers::priceFormat($item->product->getReducedPrice()) }}
                                       </span>
                                   </td>
                               @endforeach
                           </tr>
                           <tr>
                               <td>Артикул</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td>{{ $item->product->sku }}</td>
                               @endforeach
                           </tr>

                           <tr>
                               <td>Наличие</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td>{{ $item->product->stock > 0 ? 'В наличии' : 'Есть на складе' }}</td>
                               @endforeach
                           </tr>
                           <tr>
                               <td>Рейтинг</td>
                               @foreach($productFeaturesCompareList as $item)
                                   <?php $reviews_count = $item->product->reviews_count;
                                   ?>
                                   <td>
                                       @for($i = 1; $i <= 5; $i++)
                                           <i class="fa <?=(($item->product->avgRating->avg_rating ?? 0) >= $i) ? 'fa-star' : 'fa-star-o';?>"></i>
                                       @endfor
                                       <p>На основе {{ $reviews_count }} {{ $reviews_count>1 ? 'отзывов' : 'отзыв' }}.</p>
                                   </td>
                               @endforeach
                           </tr>

                           @if(false)
                               <tr>
                                   <td>Краткое описание</td>
                                   @foreach($productFeaturesCompareList as $item)
                                       <td class="description">
                                           {!! preg_replace("/<img[^>]+>/", "",  \App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($item->product->description, 22))) !!}
                                       </td>
                                   @endforeach
                               </tr>
                           @endif

                           </tbody>

                           @foreach($attributeGroups as $group)
                               <thead>
                                   <tr>
                                       <td  colspan="{{ count($productFeaturesCompareList)+1 }}">
                                           <b>{{ $group->name }}</b>
                                       </td>
                                   </tr>
                               </thead>
                               <tbody>
                               @foreach($group->attributes as $attribute)
                                   <tr>
                                       <td>{{ $attribute->name }}</td>

                                       @foreach($productFeaturesCompareList as $item)
                                           <td>
                                               @foreach($item->product->attributes as $product_attribute)
                                                   @if($product_attribute->id == $attribute->id)
                                                       {{ $product_attribute->pivot->value }}<br/>
                                                   @endif
                                               @endforeach
                                           </td>
                                       @endforeach

                                   </tr>
                               @endforeach
                               </tbody>
                           @endforeach
                           <tbody><tr>
                               <td></td>
                               @foreach($productFeaturesCompareList as $item)
                                   <td>
                                       <a href="{{ route('compare_product_delete', ['product_id' => $item->product_id]) }}" class="button">
                                           <i class="fa fa-remove firm-red"></i> Удалить
                                       </a>
                                   </td>
                               @endforeach
                           </tr>
                           </tbody>

                       </table>
                   </div>
               @endif

           </div>
       </div>




@endsection