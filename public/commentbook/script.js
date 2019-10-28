LIS_SETTINGS = {
    key: '9673b14efa6340b87c4c31e7cb007abf',
    startAt: new Date().getTime()
};
var LISLoader = LISLoader || [];
var LIS_API = {};
var lisApiOnReady = [];
LIS_API.addToBasket = LIS_API.order = LIS_API.setEmail = LIS_API.viewCard = function() {};
LISLoader.push({url:'//www.commentbook.ru/widget/index.js', scriptId:'lisCommCore'});
setTimeout(function () {
    (function (d, id) {
        if(id && d.getElementById(id))return;
        var js = d.createElement("script");
        js.type = "text/javascript";
        js.id = id;
        js.src = '//cdn.labsol.ru/libloader/lis_loader.js';
        js.async = true;
        js.charset = 'UTF-8';
        js.setAttribute("async", '');
        js.setAttribute("charset", 'UTF-8');
        d.getElementsByTagName("head")[0].appendChild(js);
    }(document, 'cb_lis_ll'));
}, 0);