function addToCartSite(self, product_id, quantity){
    if(validSelectModelProduct())
    {
        if(addToCart(product_id, quantity))
        {

            header.listCart();
            header.cartTotal();

            Swal.fire({
                title: 'Товар в корзине',
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#4aa90b',
                cancelButtonColor: '#0089d0',
                confirmButtonText: 'Оформление заказа',
                cancelButtonText: 'Продолжить покупки',
            }).then((result) => {
                if (result.value) {
                    location.href = '/checkout';
                }
            });
        }
    }
}

if($('#quickView').length > 0)
{
    var quickView = new Vue({
        el: '#quickView',
        data: {
            product: [],
            detailUrlProduct: '',
            pathPhoto: '',
            price: 0,
            attributes: []
        },
        methods:{
            getProduct(product_id){
                var self = this;
                getProduct(product_id, function(result){
                    self.product          = result.product;
                    self.detailUrlProduct = result.detailUrlProduct;
                    self.pathPhoto        = result.pathPhoto;
                    self.price            = result.price;
                    self.attributes       = result.attributes;

                    modalShow('#quickView');
                });
            }
        }
    });
}

if($('#header').length > 0)
{
    var header = new Vue({
        el: '#header',
        data() {
            return {
                cart_total: {
                    sum: 0,
                    quantity: 0
                },
                list_cart: null,
                pfcc: 0,
                pfwc: 0,
                show_block: {
                    display: 'block'
                }
            }
        },
        methods: {
            listCart() {
                axios.post('/list-cart').then((res) => {
                    this.list_cart = res.data;
                });
            },
            deleteProductQuantity(product_id) {
                axios.post('/cart-delete/' + product_id).then((res) => {
                    if (res.data) {
                        this.listCart();
                        this.cartTotal();
                        checkout.listCart();
                        checkout.cartTotal();
                    }
                });
            },
            getProductFeaturesCompareCount() {
                axios.get('/product-features-compare-count').then((res) => {
                    this.pfcc = res.data;
                });
            },
            getProductFeaturesWishlistCount() {
                axios.get('/product-features-wishlist-count').then((res) => {
                    this.pfwc = res.data;
                });
            },
            cartTotal() {
                axios.get('/cart-total/0').then((res) => {
                    this.cart_total.sum = res.data.sum;
                    this.cart_total.quantity = res.data.quantity;
                });
            }
        },
        created() {
            this.listCart();
            this.cartTotal();
            this.getProductFeaturesCompareCount();
            this.getProductFeaturesWishlistCount();
        }
    });
}

function modalShow(element) {
    $(element).modal('show');
}

function modalHide(element) {
    $(element).modal('hide');
}



var callbackWait = false;
function callback(self){
    if(!callbackWait)
    {
        callbackWait = true;
        ajaxLoader(self, true);

        $.ajax({
            type: 'POST',
            url: '/callback',
            data: getFormData(self),
            success: function (data) {
                if (data) {
                    modalHide('.callback');
                    Swal({
                        title: 'Обратный звонок',
                        html: 'Заявка отправлена! В ближайшее время с Вами свяжется наш менеджер.'
                    });
                    clearFormData(self);
                }

                callbackWait = false;
                ajaxLoader(self, false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
                }

                callbackWait = false;
                ajaxLoader(self, false);
            }
        });
    }
}

$(document).ready(function() {

    $('#buy-in-one-click').on('click', function (e) {

        if(validSelectModelProduct())
            modalShow('#popup-buy-in-one-click');

    });

    $('.product-search').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/product-search",
                data: {
                    searchText: request.term,
                    maxResults: 10,
                   // _token: getCsrfToken()
                },
                dataType: "json",
                success: function (data) {

                    response($.map(data, function (item) {
                        return {
                            name:  item.name,
                            photo: item.photo,
                            url:   item.url,
                            price: item.price
                        };
                    }));
                }
            })
        }}).data("ui-autocomplete")._renderItem = function (ul, item) {
        var inner_html =
            '<a class="list_item_container" href="' + item.url + '">' +
                '<div class="image"><img src="' + item.photo + '"/></div>' +
                '<div class="name">' + item.name + ' - <b>' + item.price + '</b></div>'
            '</div>';

        return $("<li></li>")
            .data("ui-autocomplete-item", item)
            .append(inner_html)
            .appendTo(ul);

    };

    /******************** Лайк отзыва ******************/
    $('.review_plus').on('click', function () {
        var review_id = $(this).attr('review_id');
        var this_var = $(this);

        productReviewSetLike(review_id, 1, function (data) {
            if(data)
            {
                $('#review_' + review_id).find('.review_plus').find('.review_number').html(data['likes_count']);
                $('#review_' + review_id).find('.review_minus').find('.review_number').html(data['dis_likes_count']);
                this_var.addClass('active');
                this_var.parent().find('.review_minus').removeClass('active');
            }
        });
    });
    $('.review_minus').on('click', function () {
        var review_id = $(this).attr('review_id');
        var this_var = $(this);

        productReviewSetLike(review_id, 0, function (data) {
            if(data)
            {
                $('#review_' + review_id).find('.review_plus').find('.review_number').html(data['likes_count']);
                $('#review_' + review_id).find('.review_minus').find('.review_number').html(data['dis_likes_count']);
                this_var.addClass('active');
                this_var.parent().find('.review_plus').removeClass('active');
            }
        });
    });
    /******************** Лайк отзыва ******************/

});








function writeReviewShow() {
    $("#product-tab li:nth-child(3) a").trigger('click');
    $('html, body').animate({
        scrollTop: $("#reviews").offset().top - 150
    }, 1000);
}

//Написать отзыв
function writeReview(self) {
    ajaxLoader(self, true);
    $.ajax({
        type: 'POST',
        url: '/write-review',
        data: getFormData(self),
        success: function(data) {
            if(data){
                Swal({
                    title: 'Написать отзыв',
                    html: 'Ваш отзыв успешно оставлен'
                });
                clearFormData(self);

                setInterval(function () {
                    location.reload();
                }.bind(this), 1000);

            }else{
                alert('Ошибка БД');
            }
            ajaxLoader(self, false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422)
            {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
            ajaxLoader(self, false);
        }
    });
}

//Написать отзыв
function writeQuestion(self)
{
    ajaxLoader(self, true);
    $.ajax({
        type: 'POST',
        url: '/write-question',
        data: getFormData(self),
        success: function(data) {
            if(data){
                Swal({
                    title: 'Задать вопрос',
                    html: 'Ваш вопрос успешно задан'
                });
                clearFormData(self);
            }else{
                alert('Ошибка БД');
            }
            ajaxLoader(self, false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422)
            {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
            ajaxLoader(self, false);
        }
    });
}




var ocoWait = false;
function oneClickOrder(self) {

    if(!ocoWait)
    {
        ocoWait = true;
        ajaxLoader(self, true);

        $.ajax({
            type: 'POST',
            url: '/one-click-order',
            data: getFormData(self),
            success: function (data) {
                if (data) {
                    this.order_id = data['order_id'];
                    if (this.order_id) {
                        Swal({
                            type: 'success',
                            html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + this.order_id + '">№:' + this.order_id + '</a>',
                            title: 'Ваш заказ успешно оформлен'
                        });
                    }
                } else {
                    alert('Ошибка БД');
                }
                modalHide('.one-click-order');
                ocoWait = false;
                ajaxLoader(self, false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
                }
                ocoWait = false;
                ajaxLoader(self, false);
            }
        });

    }

}
