<template>
    <div class="order">



        <div class="row">
            <div class="col-md-12 well">
                <h2>
                    <history_back></history_back>

                    Заказ #{{ order.id }}

                    <router-link :to="{ name: 'user_edit', params: {user_id: order.user_id} }" v-if="order.user">
                        - | {{ order.user.name }} {{ order.user.surname }}
                    </router-link>

                    {{ order.created_at ? '|'  + dateFormat(order.created_at) : ''}}

                    <a class="btn btn-success ladda-button pull-right" @click="saveOrder">
                            <span class="ladda-label">
                                <i class="fa fa-cart-arrow-down"></i> {{ order.id ? 'Сохранить заказ' : 'Создать заказ'}}
                            </span>
                    </a>

                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-ticket"></i> О заказе</span>
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive1">
                            <table class="table table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>
                                        <b><p>Текущее состояние</p></b>
                                        <p>
                                            <select class="selectpicker form-control" v-model="order.status_id">
                                                <option v-for="os in order_statuses"
                                                        v-bind:value="os.id"
                                                        :data-icon="os.class">
                                                    {{ os.name }}
                                                </option>
                                            </select>
                                        </p>
                                    </td>
                                    <td>
                                        <b><p>Оплачен</p></b>
                                        <div>
                                            <span v-if="order.paid == 1"><i class="fa fa-check-circle status-completed"></i>&nbsp;Да</span>
                                            <span v-else><i class="fa fa-check-circle status-canceled"></i>&nbsp;Нет</span>
                                        </div>
                                    </td>
                                    <td>
                                        <b><p>Дата заказа</p></b>
                                        <div class="input-group date standard-input">
                                            <date-picker :config="datetimepicker" v-model="order.created_at"></date-picker>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td v-if="order.updated_at">
                                        <b><p>Дата изменение</p></b>
                                        <p>{{ dateFormat(order.updated_at) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b><p>Тип заказа</p></b>
                                        <p>
                                            <select class="form-control" v-model="order.type_id">
                                                <option v-for="item in types" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </p>
                                    </td>
                                    <td>
                                        <b><p>Где заказал</p></b>
                                        <p v-if="whereOrdered">
                                            <i :class="whereOrdered.class"></i>
                                            {{ whereOrdered.title }}
                                        </p>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>

                        <div class="box-body">
                            <div class="table-responsive1">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Комментарии</td>
                                        <td colspan="3">
                                            <textarea class="form-control" v-model="order.comment"></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-user"></i> Клиент</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="well">
                            <div class="table-responsive1">
                                <table class="table table-condensed table-hover">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <i class="fa fa-user-circle-o"></i>
                                            Клиент ID:
                                        </td>
                                        <td>
                                            <select class="form-control" v-model="order.user_id">
                                                <option value=""></option>
                                                <option v-for="user in users" :value="user.id">
                                                    {{ user.name }} {{ user.surname }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-envelope"></i>
                                            Имя:
                                        </td>
                                        <td>
                                            <input v-model="order.user_name" class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-phone"></i>
                                            Телефон:
                                        </td>
                                        <td>
                                            <input
                                                    @blur="order.user_phone = $event.target.value;"
                                                    v-model="order.user_phone"
                                                    class="form-control phone-mask1"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-email"></i>
                                            E-mail
                                        </td>
                                        <td>
                                            <input v-model="order.user_email" class="form-control"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-user"></i> Адреса доставки</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="well">
                            <div class="table-responsive1">
                                <table class="table table-condensed table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Город:</td>
                                        <td>
                                            <input v-model="order.city" class="form-control"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Адрес:</td>
                                        <td>
                                            <input v-model="order.address" class="form-control"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div  class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-truck"></i> Курьер</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive1">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th style="width: 150px;">Логотип</th>
                                    <th>Курьер</th>
                                    <th>Цена</th>
                                    <th>Описание</th>
                                    <td><b>Дата доставки</b></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="vertical-align-middle">
                                        <router-link :to="{ path: '/carriers/edit/' + order.carrier_id}" v-if="order.carrier">
                                            <img v-bind:src="'/uploads/carriers/' + order.carrier.logo" class="photo"/>
                                        </router-link>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <Select2 v-model="order.carrier_id" :options="convertDataSelect2(carriers)"/>
                                    </td>
                                    <td class="vertical-align-middle">{{ order.carrier ? order.carrier.price : '' }}</td>
                                    <td class="vertical-align-middle" v-html="(order.carrier ? order.carrier.delivery_text : '')">

                                    </td>
                                    <td class="vertical-align-middle">
                                        <div class="input-group date">
                                            <date-picker :config="datetimepicker" v-model="order.delivery_date"></date-picker>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-paypal"></i> Тип оплаты</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive1">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th style="width: 150px;">Логотип</th>
                                    <th>Оплачен</th>
                                    <th>Тип оплаты</th>
                                    <th>Дата оплаты</th>
                                    <th>Результат оплаты</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="vertical-align-middle">
                                        <router-link :to="{ path: '/payments/edit/' + order.payment_id}" v-if="order.payment">
                                            <img v-bind:src="'/uploads/payments/' + order.payment.logo" class="photo"/>
                                        </router-link>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <select class="selectpicker form-control paid" v-model="order.paid">
                                            <option value="1" data-icon="fa fa-check-circle status-completed">Да</option>
                                            <option value="0" data-icon="fa fa-check-circle status-canceled">Нет</option>
                                        </select>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <Select2 class="standard-input" v-model="order.payment_id" :options="convertDataSelect2(payments)"/>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <div class="input-group date standard-input">
                                            <date-picker :config="datetimepicker" v-model="order.payment_date"></date-picker>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="vertical-align-middle">
                                        {{ order.payment_result }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                        <a class="btn btn-primary ladda-button pull-right" @click="showProductAddForm">
                                <span class="ladda-label">
                                    <i class="fa fa-plus"></i> Добавить товар
                                </span>
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive1">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th class="text-right">Всего</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(product, index) in order.products" v-if="!product.pivot.is_delete">
                                    <td class="vertical-align-middle">
                                        <router-link :to="{ path: '/product/' + product.pivot.product_id}">
                                            <img v-bind:src="'/uploads/products/' + product.pivot.product_id + '/' + product.photo" class="photo"/>
                                            {{ product.pivot.name }}
                                        </router-link>
                                        <p class="font-12"><b>SKU:</b> {{ product.pivot.sku }}</p>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <input type="text" class="form-control pull-left product-price" v-model="product.pivot.price"/>
                                        &nbsp;&nbsp;
                                        <div class="pull-left product-price-tg">тг</div>
                                    </td>
                                    <td class="vertical-align-middle">
                                        <input min="1" type="number" class="form-control product-quantity" v-model="product.pivot.quantity"/>
                                    </td>
                                    <td class="vertical-align-middle text-right">{{ product.pivot.quantity * product.pivot.price }} тг</td>
                                    <td class="vertical-align-middle text-right">
                                        <a class="btn btn-xs btn-default" @click="productDelete(index)">
                                            <i class="fa fa-remove red"></i> Удалить
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vertical-align-middle text-right" colspan="4"><b>Доставка:</b></td>
                                    <td class="vertical-align-middle text-right">{{ order.carrier ? order.carrier.price : 0 }} тг</td>
                                </tr>
                                <tr>
                                    <td class="vertical-align-middle text-right" colspan="4"><b>ИТОГО:</b></td>
                                    <td class="vertical-align-middle text-right">{{ order.total }} тг</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row" v-if="order.status_history">
            <div class="col-md-12" v-if="order.status_history.length > 0">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span><i class="fa fa-shopping-cart"></i> История статуса</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive1">
                            <table class="table table-striped table-hover" id="status-table">
                                <thead>
                                <tr>
                                    <th>Статус</th>
                                    <th>Дата изменение</th>
                                    <th>Пользователь</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="h in order.status_history">
                                    <td>
                                        <i v-bind:class="h.status.class"></i>
                                        {{ h.status.name }}
                                    </td>
                                    <td>{{ h.created_at }}</td>
                                    <td>
                                        <router-link :to="{ path: '/users/edit/' + h.user_id}">
                                            {{ h.user.name }}
                                        </router-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--
                    <div class="row" v-if="order.user_id > 0">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <span><i class="fa fa-shopping-cart"></i> Другие заказы клиента</span>
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <orders :filter_user_id="order.user_id" :no_show_order_id="order.id"></orders>
                                </div>
                            </div>
                        </div>
                    </div>--->


        <div class="row">
            <div class="col-md-12 well">
                <a class="btn btn-success ladda-button pull-right" @click="saveOrder">
                        <span class="ladda-label">
                            <i class="fa fa-cart-arrow-down"></i> {{ order.id ? 'Сохранить заказ' : 'Создать заказ'}}
                        </span>
                </a>
            </div>
        </div>

        <div class="modal" role="dialog" id="search-products">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Поиск товара</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <searchProducts @productSelected="productAdd"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>


<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    //https://select2.org/configuration/options-api
    import Select2 from 'v-select2-component';
    import orders from '../orders/List';
    import searchProducts from '../plugins/SearchProducts';

    export default {
        components:{
            datePicker, Select2, orders, searchProducts
        },
        data () {
            return {
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
                    products: [],
                },
                whereOrdered: '',

                order_statuses: [],
                carriers: [],
                payments: [],
                users: [],
                types: [],
            }
        },
        updated () {
            $('.selectpicker').selectpicker('refresh');
        },
        methods:{
            productAdd(product){

                var product_id = product.id;
                var name       = product.name;
                var sku        = product.sku;
                var price      = product.price;
                var photo      = product.photo;

                var self = this;
                var add  = true;

                this.order.products.forEach(function (item, index)
                {
                    if(item.pivot.product_id == product_id)
                    {
                        self.$set(self.order.products[index].pivot, 'quantity', self.order.products[index].pivot.quantity + 1);
                        self.$delete(self.order.products[index].pivot, 'is_delete');
                        add = false;
                        return;
                    }
                });

                if(add)
                {
                    setTimeout(function () {
                        this.order.products.push({
                            photo: photo,
                            pivot:{
                                name:       name,
                                order_id:   this.order.id,
                                price:      price,
                                product_id: product_id,
                                quantity:   1,
                                sku:        sku
                            }
                        });
                    }.bind(this), 500);
                    //$('#search-products').modal('hide');
                }else
                    alert('Товар уже добавлен');


            },
            saveOrder(){
                axios.post('/admin/order-save', {
                    order:       this.order
                }).then((res)=>{
                    if(res.data)
                    {
                        var order_id = parseInt(this.$route.params.order_id);

                        this.$helper.swalSuccess(order_id > 0 ? 'Заказ изменен' : 'Заказ создан');

                        this.$router.push({
                            name: 'order_edit',
                            params:{
                                order_id: res.data
                            }
                        });
                        this.getOrder(res.data);
                    }
                });
            },
            productDelete(index){
                if(!this.order.id)
                    this.$delete(this.order.products, index);
                else
                    this.$set(this.order.products[index].pivot, 'is_delete', true);
            },

            showProductAddForm(){
                $('#search-products').modal('show');
            },
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option, default_value){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option, default_value);
            },
            getOrder(order_id){

                if(!order_id)
                {
                    if(this.$route.params.order_id)
                        order_id = this.$route.params.order_id
                }

                if(order_id > 0)
                {
                    axios.get('/admin/order/' + order_id).then((res)=>{
                        this.order        = res.data.order;
                        this.whereOrdered = res.data.whereOrdered;
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
                $(".phone-mask").mask("+7(999) 999-9999");
            },2000);

            this.getOrder();

            axios.get('/admin/order-statuses-list', {params:  {perPage: 1000}}).then((res)=>{
                this.order_statuses = res.data.data;
            });

            axios.get('/admin/carriers-list', {params:  {perPage: 1000}}).then((res)=>{
                this.carriers = res.data.data;
            });

            axios.get('/admin/payments-list', {params:  {perPage: 1000}}).then((res)=>{
                this.payments = res.data.data;
            });

            axios.get('/admin/order/users').then((res)=>{
                this.users = res.data;
            });

            axios.get('/admin/status/orders-type').then((res)=>{
                this.types = res.data;
            });

        },
        watch: {
            '$route'() {
                this.getOrder();
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
    #status-table{
        overflow: scroll;
        max-height: 265px;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    #status-table tbody, #status-table thead{
        display: table;
        width: 100%;
    }
    .product-quantity{
        width: 70px;
    }
    .product-price{
        width: 100px;
    }
    .standard-input{
        width: 200px;
    }
    .paid{
        width: 85px!important;
    }
    .product-price-tg{
        margin-top: 7px;
        margin-left: 7px;
    }
</style>
<style>
    #search-products .select2{
        width: 100%!important;
    }
</style>
