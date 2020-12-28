<template>
    <div class="row">






        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-cart-arrow-down"></i>
                        Заказы за месяц
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th v-for="item in order_status">
                                    <i :class="item.class"></i>
                                    {{ item.name }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td v-for="item in order_status" width="200" class="scroll">

                                    <table v-for="(orders, status_id) in orders" v-if="status_id == item.id" width="100%">
                                        <tbody>
                                        <tr v-for="order in orders">
                                            <td style="padding-bottom: 20px;">

                                                <table width="100%">

                                                    <tr>
                                                        <td>
                                                            <a @click="popupOrder(order.id)">
                                                                №{{ order.id }}
                                                            </a>

                                                            {{ order.total ? (' - ' + order.total + ' тг') : '' }}
                                                            <span class="created_at">
                                                                  {{ dateFormatTodayYesterday(order.created_at) }}
                                                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="order.user_name">
                                                        <td><b>Имя:</b> {{ order.user_name }}</td>
                                                    </tr>
                                                    <tr v-if="order.user_phone">
                                                        <td><b>Телефон:</b> {{ order.user_phone }}</td>
                                                    </tr>
                                                    <tr v-if="order.city || order.address">
                                                        <td>
                                                            <div>
                                                                <b>Город:</b> {{ order.city }}
                                                            </div>
                                                            <div>
                                                                <b>Адрес:</b> {{ order.address }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="order.comment">
                                                        <td>
                                                            <b>Комент:</b> {{ order.comment }}
                                                        </td>
                                                    </tr>

                                                </table>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <RightSidePopup ref="right_side_popup" :title="'Заказ:' + order_id">
            <Order @order_id="orderSaved" :p_order_id="order_id"/>
        </RightSidePopup>


    </div>
</template>


<script>
    import { FullCalendar } from "vue-full-calendar";
    import "fullcalendar-scheduler";
    import "fullcalendar/dist/fullcalendar.min.css";
    import "fullcalendar-scheduler/dist/scheduler.min.css";
    import 'fullcalendar/dist/locale/ru';
    import Order from './orders/OrderForm';
    import RightSidePopup from './plugins/RightSidePopup';

    export default {
        components:{
            FullCalendar,  Order, RightSidePopup
        },
        data() {
            return {
                orders: [],
                order_status: [],
                order_id: 0,
            }
        },
        methods:{
            orderSaved(p_order_id){
                this.getData();
            },
            dateFormatTodayYesterday(datetime){
                return this.$helper.dateFormatTodayYesterday(datetime);
            },
            popupOrder(order_id){
                this.order_id = order_id;
                this.$refs.right_side_popup.active = true;
            },
            getData(){
                axios.get('/admin/order-task-list').then((res)=>{
                    var data = res.data;
                    this.orders = data.orders;
                    this.order_status = data.order_status;
                });
            }
        },
        created(){
            this.getData();
        },
        updated(){

        }
    }


</script>

<style>
    .created_at{
        font-size: 11px;
        float: right;
    }
    .ul-none-style{
        padding: 0;
        margin: 0;
    }
    .ul-none-style li{
        list-style: none;
    }



    .scroll table {
        width: 100%;
        display:block;
    }
    .scroll thead {
        display: inline-block;
        width: 100%;
        height: 20px;
    }
    .scroll tbody {
        height: 600px;
        display: inline-block;
        width: 100%;
        overflow: auto;
    }
</style>