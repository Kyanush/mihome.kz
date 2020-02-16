$('.slider_clients').owlCarousel({
    loop:true,
    autoplay:false,
    margin:19,
    nav:true,
    navText:false,
    dots:false,
    items:1,
});

$(document).ready(function() {
    $('#main_select').niceSelect();
});

var map,myIcon;

DG.then(function () {
    map = DG.map('map', {
        center: [43.261526, 76.935703],
        zoom: 16
    });

    myIcon = DG.icon({
        iconUrl: 'http://eco-service.kz/scooter/images/map.png',
        iconSize: [40, 40]
    });
    DG.marker([43.261526, 76.935703], {
        icon: myIcon
    }).addTo(map);


});



var callbackWait = false;
function callback(self){
    if(!callbackWait)
    {
        callbackWait = true;

        $.ajax({
            type: 'POST',
            url: '/callback',
            data: getFormData(self),
            success: function (data) {
                es_close_temp_window();
                alert('Заявка отправлена! В ближайшее время с Вами свяжется наш менеджер.');
                callbackWait = false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Пожалуйста, заполните все поля');
                callbackWait = false;
            }
        });
    }
}

$(document).ready(function(){

    $('.bingc-action-open-passive-form').bind("click", function () {

        es_show_temp_window($('#callback'), {
            vertical_align: 'top'
        });

    });

});