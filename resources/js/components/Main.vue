<template>
    <div class="row">

        <order_status/>

        <div class="col-md-12">
            <div class="box">
                <full-calendar id="full-calendar" :config="config" :events="events"/>
            </div>
        </div>

        <RightSidePopup ref="right_side_popup" :title="'Заказ:' + p_order_id">
            <Order @order_id="orderSaved" :p_order_id="p_order_id"/>
        </RightSidePopup>

    </div>
</template>


<script>
    var self = '';

    import { FullCalendar } from "vue-full-calendar";
    import "fullcalendar-scheduler";
    import "fullcalendar/dist/fullcalendar.min.css";
    import "fullcalendar-scheduler/dist/scheduler.min.css";
    import 'fullcalendar/dist/locale/ru';
    import order_status from './order_status';

    import RightSidePopup from './plugins/RightSidePopup';
    import Order          from './orders/OrderForm';

    export default {
        components:{
            FullCalendar, order_status, RightSidePopup, Order
        },
        data() {
            return {
                p_order_id: 0,

                total_orders: [],
                config: {
                    showNonCurrentDates: false,
                    firstDay: 1,
                    firstDaymonthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                    monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                    dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                    dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                    buttonText: {
                        prev: "<",
                        next: ">",
                        prevYear: "<",
                        nextYear: ">",
                        today: "Сегодня",
                        month: "Месяц",
                        week: "Неделя",
                        day: "День"
                    },
                    lang: 'ru',
                    schedulerLicenseKey: "GPL-My-Project-Is-Open-Source",
                    eventRender: function(event, element) {
                             element.find(".fc-title").prepend("<i title='" + event.icon_title + "' class='" + event.icon_class + "'></i>&nbsp;");
                    },
                    defaultView: 'month',
                    eventLimit: true, // If you set a number it will hide the itens
                    eventLimitText: "еще", // Default is `more` (or "more" in the lang you pick in the option)
                    views: {
                        agenda: {
                            eventLimit: 3// adjust to 6 only for agendaWeek/agendaDay
                        }
                    },
                    eventClick: function(event, jsEvent, view) {
                        var p_order_id = event.id;

                        self.p_order_id = p_order_id;
                        self.$refs.right_side_popup.active = true;

                    },
                    eventMouseover: function(event, jsEvent, view) {
                        if(event.products)
                        {
                                var products = event.products;
                                var html = '<ul>';
                                products.forEach(function (product, index) {
                                    html += '<li>' + product.pivot.name + ' - ' + product.pivot.quantity + ' x ' + product.pivot.price + ' тг</li>';
                                });

                                // return $this->belongsToMany('App\Models\Product')->withPivot(['name', 'sku', 'price', 'quantity']);

                                html += '</ul>';

                                var tooltip = '<div class="tooltipevent">' + html + '</div>';

                                var $tool = $(tooltip).appendTo('body');

                                $(this).mouseover(function(e) {
                                    $(this).css('z-index', 10000);
                                    $tool.fadeIn('500');
                                    $tool.fadeTo('10', 1.9);
                                }).mousemove(function(e) {
                                    $tool.css('top', e.pageY + 10);
                                    $tool.css('left', e.pageX + 20);
                                });
                        }
                    },
                    eventMouseout: function(event, jsEvent, view) {
                        $(this).css('z-index', 8);
                        $('.tooltipevent').remove();
                    }
                }
            }
        },
        methods:{
            events(start, end, timezone, callback) {
                var params = {
                    start: start.format("YYYY-MM-DD"),
                    end: end.format("YYYY-MM-DD"),
                };
                axios.get('/admin/full-calendar', {params:  params}).then((res)=>{
                    var data = res.data;

                    this.total_orders = data.total_orders;

                    callback(data.calendar);
                });
            },
            orderSaved(p_order_id){
                $('#full-calendar').fullCalendar( 'refetchEvents' );
            },
        },
        created(){
            self = this;
        }
    }


</script>

<style>
  .fc-today {
      background:#CDDC39 !important;
      font-weight: bold;
  }
  .tooltipevent{
      padding: 5px 10px;
      background:#222d32;
      position:absolute;
      z-index:10001;
      color: #fff;
      border-radius: 5px;
  }
  .tooltipevent ul{
      padding: 0;
      margin: 0;
      padding-left: 15px;
  }
  #full-calendar{
     margin-bottom: 300px;
  }
</style>