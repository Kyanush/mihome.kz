<template>
    <div class="box">

        <div class="box-header with-border">
            <router-link :to="{ path: '/orders/create'}" class="btn btn-primary ladda-button">
                <span class="ladda-label">
                    <i class="fa fa-plus"></i> Создать заказ
                </span>
            </router-link>

            <div  class="btn btn-danger pull-right" @click="clearFilters">
                <i class="fa fa-times" aria-hidden="true"></i>
                Очистить
            </div>

            <div class="btn btn-primary pull-right" @click="showReport" style="margin-right: 5px;">
                <i class="fa fa-print" aria-hidden="true"></i>
                Отчеты
            </div>

        </div>

        <div class="box-header with-border">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Фильтр</b>

                    <i @click="setOrderShowFilter"
                       class="fa pull-right cursor"
                       aria-hidden="true"
                       v-bind:title="order_show_filter ? 'Скрыть фильтр' : 'Показать фильтр'"
                       v-bind:class="{'fa-eye green': !order_show_filter,  'fa-eye-slash red': order_show_filter}"></i>

                </div>
                <div class="panel-body" v-show="order_show_filter">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive1">
                                <table class="table table-bordered ">
                                    <tbody class="filter">
                                    <tr class="odd even">
                                        <td><b>Номер заказа №:</b></td>
                                        <td>
                                            <input type="text" class="form-control" v-model="filter.id"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Тип заказа:</b></td>
                                        <td>
                                            <select class="form-control" v-model="filter.type">
                                                <option value="">Все</option>
                                                <option value="1">Оформление заказа</option>
                                                <option value="2">Купить в 1 клик</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Клиент:</b></td>
                                        <td>
                                            <Select2 :settings="{multiple: true, disabled: (filter_user_id ? true : false)  }" v-model="filter.user_id" :options="convertDataSelect2(users)"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Текущее состояние:</b></td>
                                        <td>
                                            <select class="selectpicker form-control" v-model="filter.status_id">
                                                <option value="">Все</option>
                                                <option v-for="os in order_statuses"
                                                        v-bind:value="os.id"
                                                        :data-icon="os.class">
                                                    {{ os.name }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Курьер:</b></td>
                                        <td>
                                            <Select2 :settings="{multiple: true}" v-model="filter.carrier_id" :options="convertDataSelect2(carriers)"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Адрес:</b></td>
                                        <td>
                                            <Select2 :settings="{multiple: true}" v-model="filter.shipping_address_id" :options="convertDataSelect2(addresses, 'id', 'address|city')"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Комментарии:</b></td>
                                        <td>
                                            <textarea class="form-control" v-model="filter.comment"></textarea>
                                        </td>
                                    </tr>




                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive1">
                                <table class="table table-bordered ">
                                    <tbody class="filter">
                                    <tr class="odd even">
                                        <td><b>Дата доставки:</b></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.delivery_date_start"></date-picker>
                                                </div>
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.delivery_date_end"></date-picker>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Итого:</b></td>
                                        <td>
                                            <input type="number" class="form-control" v-model="filter.total"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Тип оплаты:</b></td>
                                        <td>
                                            <Select2 :settings="{multiple: true}" v-model="filter.payment_id" :options="convertDataSelect2(payments)"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Оплачен:</b></td>
                                        <td>
                                            <select class="selectpicker form-control" v-model="filter.paid">
                                                <option value="">Все</option>
                                                <option value="1" data-icon="fa fa-check-circle status-completed">Да</option>
                                                <option value="0" data-icon="fa fa-check-circle status-canceled">Нет</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Дата оплаты:</b></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.payment_date_start"></date-picker>
                                                </div>
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.payment_date_end"></date-picker>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td><b>Дата заказа:</b></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.created_at_start"></date-picker>
                                                </div>
                                                <div class="col-md-6">
                                                    <date-picker :config="datetimepicker" v-model="filter.created_at_end"></date-picker>
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
        </div>



        <div class="table-responsive">
            <table class="table table-bordered table-sort">
            <thead>
            <tr>
                <th>
                    Номер заказа №
                    <SortTable v-model="filter.sort" :column="'id'"></SortTable>
                </th>
                <th>
                    Клиент
                </th>
                <th>
                    Статус
                    <SortTable v-model="filter.sort" :column="'status_id'"></SortTable>
                </th>
                <th>
                    Тип заказа
                    <SortTable v-model="filter.sort" :column="'type'"></SortTable>
                </th>
                <th>
                    Оплачен
                    <SortTable v-model="filter.sort" :column="'paid'"></SortTable>
                </th>
                <th>
                    Сумма
                    <SortTable v-model="filter.sort" :column="'total'"></SortTable>
                </th>
                <th>
                    Дата
                    <SortTable v-model="filter.sort" :column="'created_at'"></SortTable>
                </th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd even" v-for="(item, index) in orders.data" v-if="no_show_order_id != item.id">
                <td>
                    <router-link :to="{ path: '/orders/' + item.id}" title="Посмотреть">
                        {{ item.id }}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{ path: '/users/edit/' + item.user_id}">
                        {{ item.user.name }}
                    </router-link>
                </td>
                <td>
                    <i v-bind:class="item.status.class"></i>
                    {{ item.status.name }}
                </td>
                <td>
                    {{ item.type == 1 ? 'Оформление заказа' : 'Купить в 1 клик' }}
                </td>
                <td>
                    <span v-if="item.paid == 1"><i class="fa fa-check-circle status-completed"></i>&nbsp;Да</span>
                    <span v-else><i class="fa fa-check-circle status-canceled"></i>&nbsp;Нет</span>
                </td>
                <td>{{ item.total }}</td>
                <td>{{ dateFormatTodayYesterday(item.created_at) }}</td>
                <td>
                    <router-link :to="{ path: '/orders/' + item.id}" title="Посмотреть" class="btn btn-xs btn-default">
                        <i class="fa fa-eye"></i> <!--Посмотреть--->
                    </router-link>

                    <a class="btn btn-xs btn-default red" title="Удалить" @click="deleteOrder(item, index)">
                        <i class="fa fa-remove"></i> <!--Удалить-->
                    </a>

                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>Номер заказа №</th>
                <th>Клиент</th>
                <th>Статус</th>
                <th>Сумма</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            </tfoot>
        </table>
        </div>

        <div class="text-center">
            <paginate
                    v-if="orders.last_page > 1"
                    v-model="orders.current_page"
                    :page-count="orders.last_page"
                    :click-handler="SetPage"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>

        <report :report_types="report_types"></report>

    </div>
</template>


<script>
    import Paginate   from 'vuejs-paginate';
    import Select2    from 'v-select2-component';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import report     from '../plugins/Report';
    import SortTable  from '../plugins/SortTable';

    export default {
         props: ['filter_user_id', 'no_show_order_id'],
        components:{
            Paginate, Select2, datePicker, report, SortTable
        },
        data () {
            return {
                report_types:[
                    {
                        id: 'report-goods',
                        text: 'Список товаров'
                    }
                ],

                order_show_filter: false,

                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                },

                orders: [],
                users: [],
                order_statuses: [],
                carriers: [],
                addresses: [],
                payments: [],

                filter:{
                    id:                   (this.$route.query.id   ? this.$route.query.id : ''),
                    user_id:               this.filter_user_id ? this.filter_user_id : (this.$route.query.user_id   ? this.$route.query.user_id : ''),
                    type:                 (this.$route.query.type   ? this.$route.query.type : ''),
                    status_id:            (this.$route.query.status_id   ? this.$route.query.status_id : ''),
                    carrier_id:           (this.$route.query.carrier_id   ? this.$route.query.carrier_id : ''),
                    shipping_address_id:  (this.$route.query.shipping_address_id   ? this.$route.query.shipping_address_id : ''),
                    comment:              (this.$route.query.comment   ? this.$route.query.comment : ''),
                    delivery_date_start:  (this.$route.query.delivery_date_start   ? this.$route.query.delivery_date_start : ''),
                    delivery_date_end:    (this.$route.query.delivery_date_end   ? this.$route.query.delivery_date_end : ''),
                    total:                (this.$route.query.total   ? this.$route.query.total : ''),
                    payment_id:           (this.$route.query.payment_id   ? this.$route.query.payment_id : ''),
                    paid:                 (this.$route.query.paid   ? this.$route.query.paid : ''),
                    payment_date_start:   (this.$route.query.payment_date_start   ? this.$route.query.payment_date_start : ''),
                    payment_date_end:     (this.$route.query.payment_date_end   ? this.$route.query.payment_date_end : ''),
                    created_at_start:     (this.$route.query.created_at_start   ? this.$route.query.created_at_start : ''),
                    created_at_end:       (this.$route.query.created_at_end   ? this.$route.query.created_at_end : ''),
                    page:                 (this.$route.query.page > 1 ? this.$route.query.page : ''),
                    sort:                 this.$route.query.sort
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.ordersList();
                },
                deep: true
            }
        },
        created(){
            this.ordersList();

            axios.get('/admin/order/users').then((res)=>{
                this.users = res.data;
            });

            axios.get('/admin/order-statuses-list', {params:  {perPage: 1000}}).then((res)=>{
                this.order_statuses = res.data.data;
            });

            axios.get('/admin/carriers-list', {params:  {perPage: 1000}}).then((res)=>{
                this.carriers = res.data.data;
            });

            axios.get('/admin/addresses-list').then((res)=>{
                this.addresses = res.data;
            });

            axios.get('/admin/payments-list', {params:  {perPage: 1000}}).then((res)=>{
                this.payments = res.data.data;
            });

            var order_show_filter = localStorage.getItem('order_show_filter');
            if(order_show_filter)
               this.order_show_filter = order_show_filter === 'true' ? true : false;

        },
        updated () {
            $('.selectpicker').selectpicker('refresh');
        },
        methods:{
            showReport(){
                $('#popup-peport').modal('show');
            },
            dateFormatTodayYesterday(dateString){
                return this.$helper.dateFormatTodayYesterday(dateString);
            },
            deleteOrder(item, index){
                this.$swal({
                    title: 'Вы действительно хотите удалить заказ №' + item.id + '?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/order-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.orders.data, index);
                            }
                        });
                    }
                });
            },
            setOrderShowFilter(){
                this.order_show_filter = !this.order_show_filter;
                localStorage.setItem('order_show_filter', this.order_show_filter);
            },
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option);
            },
            SetPage(page){
                this.filter.page = page;
            },
            clearFilters(){
                var self = this;
                Object.keys(this.filter).forEach(function (column) {
                    if(self.filter[column])
                        self.filter[column] = '';
                });
            },
            ordersList(){
                var params = {};
                if(this.filter.page > 1)
                    params['page'] = this.filter.page;

                var self = this;
                Object.keys(this.filter).forEach(function (column) {
                    if(self.filter[column] && column != 'page'){
                        params[column] = self.filter[column];
                    }
                });

                axios.get('/admin/orders-list', {params:  params}).then((res)=>{
                    this.orders = res.data;

                    if(this.filter_user_id)
                        delete params['user_id'];

                    this.$router.push({query: params});
                });
            }
        }

    }
</script>

<style scoped>
    .filter{
        font-size: 12px;
    }
    .filter .form-control {
        height: 25px;
        padding: 3px 12px;
        font-size: 12px;
    }
    .filter td{
        border:0!important;
    }
</style>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 2px;
    }
    .select2-results__option {
        padding: 3px 6px;
        font-size: 12px;
    }
    .filter .select2-selection--multiple {
        height: 25px!important;
        min-height: 25px!important;
    }
</style>