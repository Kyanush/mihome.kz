<template>
        <div class="simple-content" >
            <h1>Оформление заказа</h1>

            <span v-if="list_cart.length == 0">

                <span v-if="order_id > 0" class="success">
                    Ваш заказ успешно оформлен, номер заказа <a style="font-size: 14px;" v-bind:href="'/order-history/' + order_id">№:{{ order_id }}</a>
                </span>
                <span v-else style="padding: 13px;">
                    Ваша корзина пуста!
                </span>

            </span>

            <div id="simplecheckout_form_0" v-else>
                <div class="simplecheckout">
                    <div class="simplecheckout-step" style="display: block;">
                        <div class="cart_block_rumi cart_block_rumi_static">
                            <div class="simplecheckout-block" id="simplecheckout_cart">



                                <div class="cart_rumi_table">

                                    <div class="cart_rumi_table_header_main sostav_zakaza">Состав заказа</div>
                                    <div class="cart_rumi_table_products">


                                        <div class="cart_rumi_table_product" v-for="(item, index) in list_cart">
                                            <div class="cart_rumi_table_product_image">
                                                <a v-bind:href="item.product_url">
                                                    <img width="110"
                                                         v-bind:src="item.product_photo"
                                                         v-bind:alt="item.product_name"
                                                         v-bind:title="item.product_name">
                                                </a>
                                            </div>
                                            <div class="cart_rumi_table_product_right">
                                                <div class="cart_rumi_table_product_name">
                                                    <a  v-bind:href="item.product_url">
                                                        {{ item.product_name }}
                                                    </a>
                                                    <div class="options"></div>
                                                </div>

                                                <div class="cart_rumi_table_product_counterprice">
                                                    <span class="cart_rumi_table_product_counter quantity">
                                                        <div class="cart_rumi_table_product_counter_left" @click="decreaseProductQuantity(item, index)"></div>
                                                        <div class="cart_rumi_table_product_counter_middle">
                                                            <input type="text" v-model="item.quantity">
                                                        </div>
                                                        <div class="cart_rumi_table_product_counter_right" @click="increaseProductQuantity(item, index)"></div>
                                                    </span>
                                                    <span class="cart_rumi_table_product_price">
                                                        {{ item.product_specific_price }}
                                                        <span class="cart_rumi_table_product_price_special" v-if="item.product_price != item.product_specific_price">
                                                            {{ item.product_price }}
                                                        </span>
                                                        <span class="cart_rumi_table_product_price_quantity" v-if="item.quantity > 1">
                                                            {{ item.quantity }} шт. x {{ item.sum }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="cart_rumi_table_product_delete">
                                                <img style="cursor:pointer;" src="/site/images/close.png" @click="deleteProductQuantity(item.product_id)"/>
                                            </div>
                                            <div style="clear:left"></div>
                                        </div>



                                    </div>
                                </div>



                                <div class="cart_rumi_table cart_rumi_table_adaptive">
                                    <div class="cart_rumi_table_header">Выбранный способ доставки и оплаты</div>
                                    <div class="cart_rumi_table_shipping_payment">
                                        <div class="cart_rumi_table_shipping">
                                            <div class="cart_rumi_table_shipping_inner">
                                                <div class="cart_rumi_table_shipping_header">Доставка</div>
                                                <div class="cart_rumi_table_shipping_text">
                                                    {{ carrier.name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart_rumi_table_payment">
                                            <div class="cart_rumi_table_payment_inner">
                                                <div class="cart_rumi_table_payment_header">Оплата</div>
                                                <div class="cart_rumi_table_payment_text">
                                                    {{ payment.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="cart_rumi_table cart_rumi_table_adaptive" style="padding-top: 13px;">
                                    <div class="cart_rumi_table_total" style="padding-bottom: 0px;">
                                        <div class="cart_rumi_table_total_left">Доставка:</div>
                                        <div class="cart_rumi_table_total_right">
                                            {{ carrier.format_price }}
                                        </div>
                                    </div>
                                    <div class="cart_rumi_table_total" style="padding-bottom: 0px;">
                                        <div class="cart_rumi_table_total_left">Количество:</div>
                                        <div class="cart_rumi_table_total_right">
                                            {{ cart_total.quantity }}
                                        </div>
                                    </div>
                                    <div class="cart_rumi_table_total cart_rumi_table_totalmain">
                                        <div class="cart_rumi_table_total_left">Итого:</div>
                                        <div class="cart_rumi_table_total_right">
                                            {{ cart_total.sum }}
                                        </div>
                                    </div>
                                </div>
                                <div class="cart_rumi_last">

                                    <a class="checkout_main_button go_checkout" @click="checkout">
                                        <span>
                                            <img v-show="checkout_wait" src="/site/images/ajax-loader.gif"/>
                                            Оформить заказ
                                        </span>
                                    </a>

                                    <div class="undercheckout_text">
                                        Нажимая «Завершить оформление», я соглашаюсь<br>
                                        <a class="oferta_colorbox" href="/guaranty" target="_blank" alt="c публичным договором оферты">
                                            <b>c публичным договором оферты</b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="simplecheckout-block" id="simplecheckout_customer">
                            <div class="simplecheckout-block-content">
                                <div class="simplecheckout-customer-two-columns">
                                    <div class="simplecheckout-customer-two-column-left">
                                        <h3>Покупатель</h3>
                                        <table class="simplecheckout-table-form">
                                            <tbody>
                                                <tr class="row-customer_telephone">
                                                    <td class="simplecheckout-table-form-left">
                                                        <span class="simplecheckout-required">*</span>
                                                        Телефон
                                                    </td>
                                                    <td class="simplecheckout-table-form-right">
                                                        <input type="tel"
                                                               v-model="user.phone"
                                                               v-mask="'+7 (999) 999-9999'"
                                                               d="customer_telephone"
                                                               placeholder="Мобильный телефон *"/>
                                                    </td>
                                                </tr>
                                                <tr class="row-customer_email">
                                                    <td class="simplecheckout-table-form-left">
                                                        <span class="simplecheckout-required">*</span>
                                                        Email
                                                    </td>
                                                    <td class="simplecheckout-table-form-right">
                                                        <input type="email"  v-model="user.email"  id="customer_email" placeholder="Электронная почта *">
                                                    </td>
                                                </tr>
                                                <tr class="row-customer_firstname">
                                                    <td class="simplecheckout-table-form-left">
                                                        <span class="simplecheckout-required">*</span>
                                                        Имя
                                                    </td>
                                                    <td class="simplecheckout-table-form-right">
                                                        <input type="text"  v-model="user.name" id="customer_firstname" placeholder="Имя"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="simplecheckout-block" id="simplecheckout_shipping">

                        <div class="simplecheckout-block-content">

                            <div class="cart_rumi_table_tabs">
                                <div @click="selectedCarrier(item)" class="cart_rumi_table_tab" v-bind:class="{'cart_rumi_table_tab_active': item.id == carrier.id}" v-for="(item, index) in list_carriers">
                                    <div class="cart_rumi_table_tab_header">
                                        {{ item.name }} {{ item.format_price }}
                                    </div>
                                    <div class="cart_rumi_table_tab_text" v-html="item.delivery_text"></div>
                                </div>
                            </div>
                            <div style="clear: left"></div>

                            <div class="cart_rumi_table_tabs_content" v-if="carrier.id == 1">
                                <div class="cart_rumi_table_innertabs cart_rumi_table_innertab_2 cart_rumi_table_innertabs_active">
                                    <div class="cart_rumi_shipping_address">
                                        <div class="cart_rumi_shipping_address_header">Укажите адрес доставки</div>

                                        <div class="cart_rumi_shipping_address_inputs" v-if="addresses.length > 0">
                                            <div class="cart_rumi_shipping_address_input_string">
                                                <div class="cart_rumi_shipping_address_input_string_show_first">Ваш адрес<br>
                                                    <select v-model="address.id">
                                                        <option value="0">Новый адрес</option>
                                                        <option v-bind:value="item.id" v-for="item in addresses">
                                                            {{ item.city }} - {{ item.address }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cart_rumi_shipping_address_inputs" v-if="address.id == 0">
                                            <div class="cart_rumi_shipping_address_input_string">
                                                <div class="cart_rumi_shipping_address_input_string_show_first">Адрес <span class="simplecheckout-required">*</span><br>
                                                    <input v-model="address.address" name="rumi_address_street" id="rumi_address_street" type="text" value="">
                                                </div>
                                            </div>
                                            <div class="cart_rumi_shipping_address_input_string">
                                                <div class="cart_rumi_shipping_address_input_string_show">Город  <span class="simplecheckout-required">*</span><br>
                                                    <input v-model="address.city"  name="rumi_address_apartment" id="rumi_address_apartment" value="" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="simplecheckout-block" id="simplecheckout_payment">
                        <div class="simplecheckout-block-heading">Оплата</div>
                        <div class="simplecheckout-block-content">
                            <div class="simplecheckout_methods_divs">

                                <label @click="selectedPayment(item)" v-for="item in list_payments">
                                    <div class="simplecheckout_method" v-bind:class="{'simplecheckout_method_active' : payment.id == item.id}">
                                        <div class="simplecheckout_method_right">
                                            <div class="simplecheckout_method_header">
                                                {{ item.name }}
                                                <img v-bind:src="item.logo">
                                            </div>
                                            <div class="simplecheckout_method_text">Курьеру при получении или в наших магазинах. В российских рублях.</div>
                                            <div class="simplecheckout_method_image"></div>
                                        </div>
                                    </div>
                                </label>

                            </div>
                        </div>
                    </div>

                    <div class="simplecheckout-block" id="simplecheckout_comment">
                        <div class="simplecheckout-block-content" style="overflow: visible;">
                            <h3>Комментарий к заказу</h3>
                            <div>
                                <textarea v-model="comment" name="comment" id="comment" placeholder="Комментарий" data-reload-payment-form="true"></textarea>
                            </div>
                        </div>
                    </div>

                    </div>



                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props:['_user'],
        data () {
            return {
                list_cart: [],
                list_carriers: [],
                list_payments: [],
                addresses: this._user ? (this._user.addresses ? this._user.addresses : [])  : [],
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
                    phone:  this._user ? this._user.phone      : '',
                    email:  this._user ? this._user.email      : '',
                    name:   this._user ? this._user.name       : ''
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
                                this.$swal({
                                    type: 'success',
                                    html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + this.order_id + '">№:' + this.order_id + '</a>',
                                    title: 'Ваш заказ успешно оформлен'
                                });
                            }
                        }
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
    }
</script>