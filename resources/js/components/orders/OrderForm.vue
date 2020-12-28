<template>
    <div class="order">




        <div class="row">
            <div class="col-md-12 well">

                <!-- Bootstrap 3 - Split button -->
                <div v-if="order.id" class="btn-group">
                    <button type="button" class="btn btn-success">
                        <i class="fa fa-print"></i>
                        Печатать
                    </button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a @click="print('order')">Заказ</a></li>
                        <li><a @click="print('phone')">Телефон</a></li>
                    </ul>
                </div>

                <button v-if="showBtn" class="btn btn-success ladda-button pull-right" @click="saveOrder">
                        <span class="ladda-label">
                            <i class="fa fa-cart-arrow-down"></i> {{ order.id ? 'Сохранить заказ' : 'Создать заказ'}}
                        </span>
                </button>

            </div>
        </div>

        <div class="row">
            <div class="tab-container col-md-12">
                <div class="nav-tabs-custom" id="form_tabs">
                    <ul class="nav nav-tabs">
                        <li v-bind:class="{'active' : tab_active == 'main'}" @click="setTab('main')">
                            <a>
                                <i class="fa fa-home" aria-hidden="true"></i>
                                Главная
                            </a>
                        </li>
                        <li v-bind:class="{'active' : tab_active == 'whats_app'}" @click="setTab('whats_app')">
                            <a>
                                <i class="fa fa-folder-open" aria-hidden="true"></i>
                                WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content col-md-12">
                <div v-bind:class="{'active' : tab_active == 'main'}" role="tabpanel" class="tab-pane" id="main">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <span><i class="fa fa-ticket"></i> О заказе</span>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive1">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <b>
                                                Имя:
                                            </b>
                                        </td>
                                        <td>
                                            <input v-model="order.user_name" class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>
                                                Телефон:
                                            </b>
                                        </td>
                                        <td>
                                            <input
                                                    @blur="order.user_phone = $event.target.value;"
                                                    v-model="order.user_phone"
                                                    class="form-control phone-mask"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b><i class="fa fa-email"></i> E-mail</b>
                                        </td>
                                        <td>
                                            <input v-model="order.user_email" class="form-control"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <b>Текущее состояние</b>
                                        </td>
                                        <td>
                                            <p>
                                                <select class="selectpicker form-control" v-model="order.status_id">
                                                    <option value="">Все</option>
                                                    <option v-for="os in order_statuses"
                                                            v-bind:value="os.id"
                                                            :data-icon="os.class">
                                                        {{ os.name }}
                                                    </option>
                                                </select>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Дата заказа</b>
                                        </td>
                                        <td>
                                            <div class="input-group date standard-input">
                                                <date-picker :config="datetimepicker" v-model="order.created_at"></date-picker>
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Комментарии/неисправность</b></td>
                                        <td colspan="3">
                                            <textarea class="form-control" v-model="order.comment" rows="5"></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><b>Курьер</b></td>
                                        <td>
                                            <Select2 v-model="order.carrier_id" :options="convertDataSelect2(carriers)"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Город:</b></td>
                                        <td>
                                            <input v-model="order.city" class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Адрес:</b></td>
                                        <td>
                                            <input v-model="order.address" class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Оплата</b>
                                        </td>
                                        <td>
                                            <Select2  v-model="order.payment_id" :options="convertDataSelect2(payments)"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Тип заказа</b>
                                        </td>
                                        <td>
                                            <select class="form-control" v-model="order.type_id">
                                                <option v-for="item in types" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr v-if="order.user">
                                        <td>
                                            <b>Кто создал</b>
                                        </td>
                                        <td>{{ order.user.name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <span><i class="fa fa-shopping-cart"></i> Товары</span>
                                    </h3>
                                </div>
                                <div class="box-header with-border">
                                    <label class="radio-inline">
                                        <input v-model="search_product" type="radio" value="products">Поиск товара
                                    </label>
                                    <label class="radio-inline">
                                        <input v-model="search_product" type="radio" value="barcode">Штрих код
                                    </label>

                                    <br/><br/>

                                    <span v-if="search_product == 'products'">
                                        <searchProducts  @productSelected="productAdd"/>
                                    </span>
                                    <span v-else >
                                        <input v-model="barcode" type="text" class="form-control" placeholder="Штрих код"/>
                                        <br/>
                                        <button type="submit" class="btn btn-success" @click="getOrder(p_order_id)">
                                            Обновить
                                        </button>
                                    </span>

                                </div>
                                <div class="box-body">

                                    <div class="table-responsive">


                                        <table class="table table-striped" id="products">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Фото</th>
                                                <th width="450px">Товар</th>
                                                <th>Цена</th>
                                                <th>Количество</th>
                                                <th>Склад</th>
                                                <th class="text-right">Всего</th>
                                                <th class="text-right"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in order.order_products">
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    <router-link :to="{ path: '/product/' + item.product_id}">
                                                        <img v-if="item.product && item.product.photo" v-bind:src="'/uploads/products/' + item.product_id + '/' + item.product.photo" class="photo"/>
                                                        <span v-else>Нет фото</span>
                                                    </router-link>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.name"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control price" v-model="item.price"/>
                                                </td>
                                                <td>
                                                    <input min="1" type="number" class="form-control quantity" v-model="item.quantity"/>
                                                </td>
                                                <td>
                                                    <i v-if="item.product_stock_id" class="fa fa-check-circle status-completed"></i>
                                                    <i v-if="!item.product_stock_id" class="glyphicon fa fa-frown-o status-canceled"></i>

                                                    {{ item.stock ? item.stock.imei : ''}}

                                                    &nbsp;
                                                    <button @click="showStock(item.product_id, index)">...</button>

                                                </td>
                                                <td>{{ item.quantity * item.price }} тг</td>
                                                <td>
                                                    <a v-if="$can('orders_delete_products')" class="btn btn-xs btn-default" @click="productDelete(item.id)">
                                                        <i class="fa fa-remove red"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td colspan="4"><b>Доставка:</b></td>
                                                <td>{{ order.carrier ? order.carrier.price : 0 }} тг</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>ИТОГО:</b></td>
                                                <td>{{ order.total }} тг</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div v-bind:class="{'active' : tab_active == 'whats_app'}" role="tabpanel" class="tab-pane" id="whats_app">
                    <whats_app_order v-if="order.user_phone && tab_active == 'whats_app'"
                                     :p_search_dialog="order.user_phone.replace(/[^0-9]/g,'')"/>
                </div>
            </div>
        </div>





        <div class="row">
            <div class="col-md-12 well">
                <a v-if="showBtn" class="btn btn-success ladda-button pull-right" @click="saveOrder">
                    <span class="ladda-label">
                        <i class="fa fa-cart-arrow-down"></i> {{ order.id ? 'Сохранить заказ' : 'Создать заказ'}}
                    </span>
                </a>
            </div>
        </div>

        <iframe style="display: none" id="printf" name="printf"></iframe>

        <RightSidePopup  ref="right_side_popup" :title="'Склад'">
            <Stock v-if="product_id > 0"  @select_stock_id="selectStock" :product_id="product_id"/>
            <br/>
            <br/>
        </RightSidePopup>

    </div>
</template>


<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    import Select2         from 'v-select2-component';
    import searchProducts  from '../plugins/SearchProducts';
    import whats_app_order from '../whats_app/order_whats_app';
    import StockSelect     from '../plugins/StockSelect';
    import Stock           from '../products/Stock';
    import RightSidePopup  from '../plugins/RightSidePopup';

    export default {
        props: ['p_order_id'],
        components:{
            datePicker, Select2, searchProducts, whats_app_order, StockSelect, Stock, RightSidePopup
        },
        data () {
            return {
                stock_show: -1,
                tab_active: 'main',
                search_product: 'products',
                barcode: '',
                barcode_wait: true,

                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    locale: 'ru'
                },

                order: {
                    id: 0,
                    user_id: '',
                    type_id: 7,
                    status_id: 1,
                    carrier_id: 2,
                    comment: '',
                    delivery_date: '',
                    payment_id: 1,
                    paid: 0,
                    payment_date: '',
                    created_at: '',
                    city: '',
                    address: '',
                    user_name: '',
                    user_phone: '',
                    user_email: '',
                    user: {},
                    order_products: [],
                },


                order_statuses: [],
                carriers: [],
                payments: [],

                types: [],

                product_id: 0,
                order_product_index: 0
            }
        },
        updated () {
            $('.selectpicker').selectpicker('refresh');
        },
        methods:{
            showStock(product_id, index){
                this.$refs.right_side_popup.active = true;
                this.order_product_index = index;
                this.product_id          = product_id;
            },
            selectStock(stock_id){
                this.$set(this.order.order_products[this.order_product_index], 'product_stock_id', stock_id);
                this.$refs.right_side_popup.active = false;
                this.order_product_index = 0;
                this.product_id          = 0;
            },
            print(type) {
                axios.get('/admin/order-print/' + this.order.id + '?type=' + type).then((res)=>{
                    $('#printf').contents().find('html').html(res.data);
                    document.getElementById("printf").contentWindow.print();
                });
            },
            setTab(tab){
                this.tab_active = tab;
            },
            productAdd(product){

                var product_id = product.id;
                var name       = product.name;
                var price      = product.price;

                this.order.order_products.push({
                    id: 0,
                    name:       name,
                    order_id:   this.order.id,
                    price:      price,
                    product_id: product_id,
                    product_stock_id: null,
                    quantity:   1,
                });

            },
            saveOrder(){

                axios.post('/admin/order-save', {
                    order:       this.order
                }).then((res)=>{

                    var order_id = res.data;
                    if(order_id)
                    {

                        this.$notify({
                            group: 'foo',
                            title: this.order.id > 0 ? 'Заказ изменен' : 'Заказ создан'
                        });

                        this.getOrder(order_id);

                        this.$emit('order_id', order_id);
                    }
                });
            },
            productDelete(id){
                axios.get('/admin/order-product/' + id).then((res)=>{
                    this.getOrder(this.p_order_id);
                });
            },
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option, default_value){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option, default_value);
            },
            getOrder(order_id){
                if(order_id > 0)
                {
                    axios.get('/admin/order/' + order_id).then((res)=>{
                        this.order   = res.data.order;
                    });
                }
            },
            //формат даты
            dateFormat(date, format){
                return this.$helper.dateFormat(date, format) ;
            }
        },
        created(){

            setTimeout(()=>{
                $(".phone-mask").mask("+7(999)999-99-99");

                if(this.p_order_id)
                    document.title = 'Заказ ' + this.p_order_id;

            },2000);

            this.getOrder(this.p_order_id);


            axios.get('/admin/order-statuses-list', {params:  {perPage: 1000}}).then((res)=>{
                this.order_statuses = res.data.data;
            });

            axios.get('/admin/carriers-list', {params:  {perPage: 1000}}).then((res)=>{
                this.carriers = res.data.data;
            });

            axios.get('/admin/payments-list', {params:  {perPage: 1000}}).then((res)=>{
                this.payments = res.data.data;
            });

            axios.get('/admin/status/orders-type').then((res)=>{
                this.types = res.data;
            });

            axios.get('/admin/product-stock').then((res)=>{
                this.product_stock = res.data;
            });


        },
        computed:{
            showBtn(){

                if(this.$can('orders_edit_current') && this.order.created_at)
                {
                    if(this.dateFormat(this.order.created_at, 'date') == new Date().toLocaleDateString())
                        return true;
                    else
                        return false;
                }

                return true;

            }

        },
        watch: {
            barcode: {
                handler: function (val, oldVal) {

                    if(val && val.length == 13)
                    {

                        axios.post('/admin/order-barcode', {

                            order_id: this.order.id,
                            barcode:  this.barcode

                        }).then((res)=>{
                            var order_id = res.data;

                            if(order_id)
                            {

                                this.barcode = '';

                                if(!this.order.id)
                                {
                                    this.getOrder(order_id);
                                }

                                this.$notify({
                                    group: 'foo',
                                    title: 'Товар добавлен'
                                });

                            }
                        });
                    }
                },
                deep: true
            },
            p_order_id: {
                handler: function (val, oldVal) {
                    if(val)
                        this.getOrder(val);
                    else{
                        this.order = {
                            id: 0,
                            user_id: '',
                            type_id: 7,
                            status_id: 1,
                            carrier_id: 2,
                            comment: '',
                            delivery_date: '',
                            payment_id: 1,
                            paid: 0,
                            payment_date: '',
                            created_at: '',
                            city: '',
                            address: '',
                            user_name: '',
                            user_phone: '',
                            user_email: '',
                            user: {},
                            order_products: [],
                        };
                    }
                },
                deep: true
            }
        }
    }
</script>

<style scoped>
    .order{
        width: 100%;
    }
    .photo{
        width: 70px;
        margin-bottom: 5px;
        border: 1px solid #d9cece;
        padding: 2px;
    }
    #status-table tbody, #status-table thead{
        display: table;
        width: 100%;
    }
    #products tbody tr{
        border-bottom: 1.7px solid #f0b0b0;
    }
    #products input, #products select{
        font-size: 12px!important;
        height: 20px!important;
    }
    #products select option{
        font-size: 12px!important;
    }
    #products .quantity{
        width: 70px;
    }
    #products .price{
        width: 70px;
    }
</style>

<style>
    #products select{
        font-size: 12px!important;
        height: 20px!important;
    }
</style>