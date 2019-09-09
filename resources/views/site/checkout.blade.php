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
        <div class="section" id="checkout">
            <!-- container -->
            <div class="container">
                <!-- row -->

                <span v-if="list_cart.length == 0">
                    <p v-if="order_id > 0">
                        Ваш заказ успешно оформлен, номер заказа <a v-bind:href="'/order-history/' + order_id">№:@{{ order_id }}</a>
                    </p>
                    <p v-else>
                        Ваша корзина пуста!
                    </p>
                </span>

                <div class="row" v-else>

                    <div class="col-md-5">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Покупатель</h3>
                            </div>
                            <div class="form-group">
                                <input type="text"
                                       v-model="user.phone"
                                       class="input phone-mask"
                                       @blur="user.phone = $event.target.value;"
                                       placeholder="Мобильный телефон *"/>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email"  v-model="user.email"  id="customer_email" placeholder="Электронная почта *">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text"  v-model="user.name" id="customer_firstname" placeholder="Имя"/>
                            </div>

                            <div class="shiping-details">
                                <div class="section-title">
                                    <h3 class="title">Оплата</h3>
                                </div>
                                <div class="payment-method">
                                    <div @click="selectedPayment(item)" class="input-radio" v-for="(item, index) in list_payments">
                                        <input type="radio" name="payment" :id="'payment' + index" :checked="payment.id == item.id"/>
                                        <label :for="'payment' + index">
                                            <span></span>
                                            @{{ item.name }}
                                            <img width="20" v-bind:src="item.logo">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="shiping-details">
                                <div class="section-title">
                                    <h3 class="title">Доставка</h3>
                                </div>
                                <div class="payment-method">
                                    <div @click="selectedCarrier(item)" class="input-radio" v-for="(item, index) in list_carriers">
                                        <input type="radio" name="carrier" :id="'carrier' + index" :checked="item.id == carrier.id"/>
                                        <label :for="'carrier' + index">
                                            <span></span>
                                            @{{ item.name }} @{{ item.format_price }}
                                        </label>
                                        <div class="caption">
                                            <p v-html="item.delivery_text"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="shiping-details" v-if="carrier.id == 1">
                                <div class="section-title">
                                    <h3 class="title">Укажите адрес доставки</h3>
                                </div>
                                <div class="payment-method">
                                    <div class="form-group" v-if="addresses.length > 0">
                                        <select v-model="address.id" class="form-control">
                                            <option value="0">Новый адрес</option>
                                            <option v-bind:value="item.id" v-for="item in addresses">
                                                @{{ item.city }} - @{{ item.address }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group" v-if="address.id == 0">
                                        <input v-model="address.address" type="text" class="input" placeholder="Адрес *"/>
                                    </div>
                                    <div class="form-group" v-if="address.id == 0">
                                        <input v-model="address.city" type="text" class="input" placeholder="Город *"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /Billing Details -->

                        <!-- Order notes -->
                        <div class="order-notes">
                            <textarea class="input" v-model="comment" name="comment" id="comment" placeholder="Комментарий к заказу" data-reload-payment-form="true"></textarea>
                        </div>
                        <!-- /Order notes -->

                    </div>

                    <!-- Order Details -->
                    <div class="col-md-7 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Ваш заказ</h3>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th></th>
                                    <th>Кол-во</th>
                                    <th width="150">Цена</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in list_cart">
                                        <td>
                                            <a v-bind:href="item.product_url">
                                                <img width="40"
                                                     v-bind:src="item.product_photo"
                                                     v-bind:alt="item.product_name"
                                                     v-bind:title="item.product_name">
                                            </a>
                                        </td>
                                        <td>
                                            <a  v-bind:href="item.product_url">
                                                @{{ item.product_name }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="input-number" style="width: 70px;">
                                                <input type="number" v-model="item.quantity" disabled/>
                                                <span class="qty-up"   @click="increaseProductQuantity(item, index)">+</span>
                                                <span class="qty-down" @click="decreaseProductQuantity(item, index)">-</span>
                                            </div>
                                        </td>
                                        <td>
                                            @{{ item.product_specific_price }}
                                            <del v-if="item.product_price != item.product_specific_price">
                                                <p>
                                                    @{{ item.product_price }}
                                                </p>
                                            </del>
                                            <p v-if="item.quantity > 1">
                                                @{{ item.quantity }} шт. x @{{ item.sum }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <i title="Удалить" class="fa fa-remove firm-red cursor-pointer" @click="deleteProductQuantity(item.product_id)"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="order-summary" >
                            <div class="order-col">
                                <div>Доставка:</div>
                                <div><strong>@{{ carrier.format_price }}</strong></div>
                            </div>
                            <div class="order-col">
                                <div>Количество:</div>
                                <div><strong>@{{ cart_total.quantity }}</strong></div>
                            </div>
                            <div class="order-col">
                                <div><strong>ИТОГО</strong></div>
                                <div><strong class="order-total">@{{ cart_total.sum }}</strong></div>
                            </div>
                        </div>

                        <a class="primary-btn order-submit" @click="checkout">
                            <img :class="{ 'active': checkout_wait}" class="ajax-loader" src="/site/images/ajax-loader.gif"/>
                            Оформить заказ
                        </a>

                    </div>
                    <!-- /Order Details -->
                </div>

                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->


        <script>
            var checkout = new Vue({
                el: '#checkout',
                data () {
                    return {
                        list_cart: [],
                        list_carriers: [],
                        list_payments: [],
                        addresses: <?=json_encode($user ? $user->addresses : []);?>,
                        cart_total: {
                            sum: 0,
                            quantity: 0
                        },
                        order_id: 0,

                        carrier: {},
                        payment: {},
                        address:{
                            id: 0,
                            city: '',
                            address: ''
                        },
                        user:{
                            phone: '{{$user->phone ?? '' }}',
                            email: '{{$user->email ?? '' }}',
                            name:  '{{$user->name  ?? '' }}'
                        },
                        comment: '',

                        checkout_wait: false
                    }
                },
                updated () {

                },
                methods:{
                    selectedCarrier(item){
                        this.carrier = item;
                    },
                    selectedPayment(item){
                        this.payment = item;
                    },
                    listCart(){
                        axios.post('/list-cart').then((res)=>{
                            this.list_cart = res.data;
                        });
                    },
                    decreaseProductQuantity(item, index){
                        if(this.list_cart[index].quantity > 1)
                            this.cartSave(item.product_id, this.list_cart[index].quantity -1 );
                    },
                    increaseProductQuantity(item, index){
                        this.cartSave(item.product_id, this.list_cart[index].quantity + 1);
                    },
                    deleteProductQuantity(product_id){
                        axios.post('/cart-delete/' + product_id).then((res)=>{
                            if(res.data)
                            {
                                this.listCart();
                                this.cartTotal();
                                header.listCart();
                                header.cartTotal();
                            }
                        });
                    },
                    cartTotal(){
                        axios.get('/cart-total/' + (this.carrier.id ? this.carrier.id : 0)).then((res)=>{
                            this.cart_total.sum = res.data.sum;
                            this.cart_total.quantity = res.data.quantity;
                        });
                    },
                    cartSave(product_id, quantity){
                        axios.post('/cart-save', {product_id: product_id, quantity: quantity}).then((res)=>{
                            if(res.data)
                            {
                                this.listCart();
                                this.cartTotal();
                                header.listCart();
                                header.cartTotal();
                            }
                        });
                    },
                    async checkout(){
                        if(!this.checkout_wait)
                        {
                            this.checkout_wait = true;

                            var data = {
                                carrier_id: this.carrier.id,
                                payment_id: this.payment.id,
                                address: {
                                    id:      this.address.id,
                                    city:    this.address.city,
                                    address: this.address.address
                                },
                                user: {
                                    phone: this.user.phone,
                                    email: this.user.email,
                                    name:  this.user.name
                                },
                                comment: this.comment
                            };


                            await axios.post('/checkout', data).then((res) => {
                                var data = res.data;
                                if (data) {
                                    this.order_id = data['order_id'];
                                    if (this.order_id) {
                                        this.list_cart = [];
                                        Swal({
                                            type: 'success',
                                            html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + this.order_id + '">№:' + this.order_id + '</a>',
                                            title: 'Ваш заказ успешно оформлен'
                                        });
                                    }
                                }
                            }).catch(function (error) {
                               swalErrors(error.response.data.errors, 'Пожалуйста! Заполните все обязательные поля');
                            });

                            this.checkout_wait = false;
                        }
                    }
                },
                watch: {
                    carrier: {
                        handler: function (val, oldVal) {
                            this.cartTotal();
                        },
                        deep: true
                    }
                },
                created(){

                    setTimeout(function() {
                        $(".phone-mask").mask("+7(999) 999-9999");
                    }, 2000);

                    this.listCart();
                    this.cartTotal();

                    axios.post('/list-carriers').then((res)=>{
                        if(res.data){
                            this.list_carriers = res.data;
                            this.carrier = this.list_carriers[0];
                        }
                    });

                    axios.post('/list-payments').then((res)=>{
                        if(res.data)
                            this.list_payments = res.data;
                        this.payment = this.list_payments[0];
                    });

                }
            });
        </script>

@endsection