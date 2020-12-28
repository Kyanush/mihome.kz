<!-- https://nikolaus.by/blog/poleznye-fishki-dlya-sayta/taymer-obratnogo-otschyeta-na-javascript/ -->


<div class="timer" data-finish="1609517716000">
   <div class="timer_section">
      <div class="days_1">0</div>
      <div class="days_2">0</div>
      <div class="timer_section_desc">дней</div>
   </div>
   <div class="timer_delimetr">:</div>
   <div class="timer_section">
      <div class="hours_1">0</div>
      <div class="hours_2">0</div>
      <div class="timer_section_desc">часов</div>
   </div>
   <div class="timer_delimetr">:</div>
   <div class="timer_section">
      <div class="minutes_1">0</div>
      <div class="minutes_2">0</div>
      <div class="timer_section_desc">минут</div>
   </div>
   <div class="timer_delimetr">:</div>
   <div class="timer_section">
      <div class="seconds_1">0</div>
      <div class="seconds_2">0</div>
      <div class="timer_section_desc">секунд</div>
   </div>
</div>
<h4 style="text-align: center;color: red;">До конца акции осталось</h4>

<style type="text/css">
   .timer{
      font-size: 0;
      text-align: center;
   }
   .timer_section{
      display: inline-block;
      vertical-align: top;
   }
   .timer_section > div{
      display: inline-block;
      vertical-align: top;
      font-size: 30px;
      background: red;
      color: #ffffff;
      line-height: 45px;
      width: 40px;
      margin: 0 1px;
      border-radius: 2px;
   }
   .timer_section > div.timer_section_desc{
      display: block;
      background: none;
      color: inherit;
      text-transform: uppercase;
      font-size: 16px;
      line-height: 30px;
      width: auto;
      margin: 0;
      color: red;
   }
   .timer_delimetr{
      display: inline-block;
      vertical-align: top;
      font-size: 30px;
      line-height: 45px;
      margin: 0 5px;
      color: red;
   }
   @media (max-width: 767px){
      .timer_section > div{
         font-size: 30px;
         width: 30px;
         line-height: 40px;
      }
      .timer_delimetr{
         line-height: 40px;
         font-size: 30px;
      }
      .timer_section > div.timer_section_desc{
         font-size: 14px;
         line-height: 26px;
      }
   }
</style>
<script type="text/javascript">
    function timer(f_time) {
        function timer_go() {
            var n_time = Date.now();
            var diff = f_time - n_time;
            if(diff <= 0) return false;
            var left = diff % 1000;

            //секунды
            diff = parseInt(diff / 1000);
            var s = diff % 60;
            if(s < 10) {
                $(".seconds_1").html(0);
                $(".seconds_2").html(s);
            }else {
                $(".seconds_1").html(parseInt(s / 10));
                $(".seconds_2").html(s % 10);
            }
            //минуты
            diff = parseInt(diff / 60);
            var m = diff % 60;
            if(m < 10) {
                $(".minutes_1").html(0);
                $(".minutes_2").html(m);
            }else {
                $(".minutes_1").html(parseInt(m / 10));
                $(".minutes_2").html(m % 10);
            }
            //часы
            diff = parseInt(diff / 60);
            var h = diff % 24;
            if(h < 10) {
                $(".hours_1").html(0);
                $(".hours_2").html(h);
            }else {
                $(".hours_1").html(parseInt(h / 10));
                $(".hours_2").html(h % 10);
            }
            //дни
            var d = parseInt(diff / 24);
            if(d < 10) {
                $(".days_1").html(0);
                $(".days_2").html(d);
            }else {
                $(".days_1").html(parseInt(d / 10));
                $(".days_2").html(d % 10);
            }
            setTimeout(timer_go, left);
        }
        setTimeout(timer_go, 0);
    }

    $(document).ready(function() {
        var time = $(".timer").attr("data-finish");
        timer(time);
    });
</script>