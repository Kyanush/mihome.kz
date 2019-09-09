function gerArrayFilters() {
    var filter = [];
    var data = $('#filterpro').serializeArray();
    data.forEach(function (item, index) {
        if(!filter[item['name']])
            filter[item['name']] = [];
        filter[item['name']].push(item['value']);
    });
    return filter;
}

function urlParamsGenerate(){

    var filter = gerArrayFilters();

    var params = '';
    if(filter.page > 1)
        params += 'page-' + filter.page + '/';

    Object.keys(filter).forEach(function (column) {
        if(filter[column] && column != 'page' && column != 'category')
        {
            var value = filter[column];

            if($.isArray(filter[column])){
                value = '';
                $.each(filter[column], function(idx2, val2) {
                    if(val2)
                        value += val2 + '-or-';
                });
                if(value)
                    value = value.slice(0,-4);
            }

            if(value)
                params += column + '-' + value + '/';
        }
    });

    if($('.sort_select').val())
        params += $('.sort_select').val() + '/';

    if(params)
        params = params.slice(0,-1);

    var base_url = baseUrl();
    location.href = base_url + (params ? '/filters/' + params : '');
}

function filtersClear() {
    location.href = baseUrl();
}

function baseUrl() {
    var url = window.location.origin + window.location.pathname;;
    url =  url.split('/');
    var catalog = '/';

    var f = true;

    url.forEach(function (value, index) {
        if(index > 2 && f)
        {
            if(value == 'filters'){
                f = false;
            }else
                catalog += value + '/';
        }
    });

    catalog = catalog.substring(0, catalog.length - 1);

    return url[0] + '//' + url[2] + catalog;
}

$(document).ready(function() {
    $('.sort_select, #min_price, #max_price').on('change', function () {
        urlParamsGenerate();
    });
});

function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

function productFeaturesWishlist(self, product_id){
    getProduct(product_id, function(result){

        $.ajax({
            url: '/product-features-wishlist/' + product_id,
            type: 'post',
            data: { _token: getCsrfToken() },
            dataType: 'json',
            success: function(data) {
                if(data)
                {
                    if($(self).hasClass('active'))
                        $(self).removeClass('active');
                    else{
                        $(self).addClass('active');
                        Swal({
                            title: 'Закладки',
                            html: '<p class="text-swal2">Товар <a href="' + result.detailUrlProduct + '">'
                            + result.product.name +
                            '</a> добавлен в <a href="/wishlist">закладки</a>!</p>'
                        });
                    }

                    if(typeof header == 'object')
                        header.getProductFeaturesWishlistCount();

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.status == 401)
                {
                    Swal({
                        title: 'Закладки',
                        html: '<p class="text-swal2">Необходимо войти в <a href="/login">Личный Кабинет</a> или <a href="/register">создать учетную запись</a>, '
                        +
                        'чтобы сохранить товар <a href="' + result.detailUrlProduct + '">' + result.product.name + '</a> в свои <a href="/wishlist">закладки</a>!</p>'
                    });
                }
            }
        });

    });
}

function getProduct(product_id, callback){
    axios.post('/get-product/' + product_id).then(function (response) {
        var data = response.data;

        console.log(data);

        callback(data);
    }).catch(function (error) {
        console.log(error);
        alert('error');
    });
}

function productFeaturesCompare(self, product_id){
    getProduct(product_id, function(result) {

        $.ajax({
            url: '/product-features-compare/' + product_id,
            type: 'post',
            data: {_token: getCsrfToken()},
            dataType: 'json',
            success: function (data) {
                if (data) {
                    if($(self).hasClass('active'))
                        $(self).removeClass('active');
                    else{
                        $(self).addClass('active');
                        Swal({
                            title: 'Сравнение товаров',
                            html: '<p class="text-swal2">Вы добавили <a href="' + result.detailUrlProduct + '">' + result.product.name + '</a> в ваш <a href="/compare-products">список сравнения</a>!</p>'
                        });
                    }

                    if(typeof header == 'object')
                        header.getProductFeaturesCompareCount();

                }
            }
        });

    });
}



function productReviewSetLike(review_id, like, callback){
    $.ajax({
        url: '/product-review-set-like',
        type: 'post',
        dataType: 'json',
        data: {
            review_id: review_id,
            like:      like,
            _token:    getCsrfToken()
        },
        success: function (data) {
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 422) {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
            callback(false);
        }
    });
}


function addToCart(product_id, quantity) {

    if(!quantity)
        quantity = 0;

    if(product_id > 0)
    {

        var result = false;
        $.ajax({
            async: false,
            url: '/cart-save',
            type: 'post',
            data: {
                product_id: product_id,
                quantity: quantity,
                _token: getCsrfToken()
            },
            dataType: 'json',
            success: function(data) {
                result = true;
            }
        });

        return result;
    }else{
        alert('Error');
    }
}

function swalErrors(errors_array, title, type) {

    if(!title)
        title = 'Ошибка';

    if(!type)
        type = 'error';

    var errors_html = '';
    $.each(errors_array, function(index, value) {
        errors_html += value + '<br/>';
    });

    Swal({
        type:  type,
        title: title,
        html: errors_html
    });
}

function setCity(city_code){
    axios.post('/set-city/' + city_code, {
        _token: getCsrfToken()
    }).then(function (response) {
        console.log(response);
        location.href = '/';
    });
}

$(document).ready(function() {
    if($(".phone-mask").length > 0)
        $(".phone-mask").mask("+7(999) 999-9999");
});