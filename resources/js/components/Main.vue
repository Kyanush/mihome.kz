<template>
    <div class="row">

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-cart-arrow-down"></i>
                        Заказы за месяц
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th v-for="item in total_orders"><i :class="item.class"></i> {{ item.title }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td v-for="(item, status_id) in total_orders">
                                    <span class="quantity">{{ item.quantity }}</span> шт.
                                    на
                                    <span class="quantity">{{ item.total }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-phone"></i>
                        Обратные звонки за месяц
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th v-for="item in total_callbacks">
                                    <i :class="item.class"></i> {{ item.title }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td v-for="(item, status_id) in total_callbacks">
                                    {{ item.quantity }} шт.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <full-calendar :config="config" :events="events"/>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div id="highcharts-monthly-amount" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div id="highcharts-monthly-amount-callbacks" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>

    </div>
</template>


<script>
    import { FullCalendar } from "vue-full-calendar";
    import "fullcalendar-scheduler";
    import "fullcalendar/dist/fullcalendar.min.css";
    import "fullcalendar-scheduler/dist/scheduler.min.css";
    import 'fullcalendar/dist/locale/ru';


    export default {
        components:{
            FullCalendar
        },
        data() {
            return {

                total_orders: [],
                total_callbacks: [],
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
                    this.total_callbacks = data.total_callbacks;

                    callback(data.calendar);
                });
            }
        },
        created(){
            axios.get('/admin/highcharts-monthly-amount').then((res)=>{
                var data = res.data;

                console.log(data);

                setTimeout(function() {
                    highchartsMonthlyAmount(data.categories, data.series, 'highcharts-monthly-amount', 'Сумма по месяцам', 'Сумма(тг)');
                }, 2000);
            });
            axios.get('/admin/highcharts-monthly-amount-callbacks').then((res)=>{
                var data = res.data;

                console.log(data);

                setTimeout(function() {
                    highchartsMonthlyAmount(data.categories, data.series, 'highcharts-monthly-amount-callbacks', ' Обратные звонки по месяц', 'Количество');
                }, 2000);
            });
        }
    }


</script>

<style>
  .fc-today {
      background:#CDDC39 !important;
      font-weight: bold;
  }
  th{
      text-transform: uppercase;
  }
  .quantity{
      font-weight: 500;
      font-size: 18px;
  }
</style>