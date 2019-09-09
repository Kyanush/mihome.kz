   <li class="header">
      <b>Итого:</b> {{ $total['sum'] }}
   </li>
   <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu">
         @foreach($cartProductsList as $cart_product)
            <li><!-- start message -->
               <a href="{{ $cart_product->product->detailUrlProduct() }}">
                  <div class="pull-left">
                        <img  class="img-circle"
                              src="{{ $cart_product->product->pathPhoto(true) }}"
                              alt="{{ $cart_product->name }}" title="{{ $cart_product->name }}">
                  </div>
                  <h4>
                     {{ \App\Tools\Helpers::priceFormat($cart_product->product->price) }}
                     <small>
                        Кол-во: {{ $cart_product->quantity }}
                     </small>
                  </h4>
                  <p>
                     {{ $cart_product->product->name }}
                  </p>
               </a>
            </li>
         <!-- end message -->
         @endforeach

      </ul>
   </li>
   <li class="footer">
      <a href="{{ route('checkout') }}">Оформить заказ</a>
   </li>