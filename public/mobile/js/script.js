var user_info = $('#user_info').val();
if(user_info)
    user_info = JSON.parse(user_info);


$(document).ready(function() {

    $('#show-full').on('click', function (e){
        $('.company-text').addClass('full');
        $(this).remove();
    });

    $('.icon_menu').click(function(e){
            $('.wrapper').addClass('g-ttl-move')
            $('.kaspi-menu').addClass('_opened')
    });

    $('.wrapper').click(function(e){
        if($(e.target).hasClass('g-ttl-move')){
            $('.wrapper').removeClass('g-ttl-move')
            $('.kaspi-menu').removeClass('_opened')
        }
    });

/*
    $('.catalog-sub-item.catalog-main1').click(function(e) {

        if($(this).parent('.catalog-sub-items__el').find('.catalog-sub-items__list').length > 0)
        {
            e.preventDefault();
            if ($(this).parent('.catalog-sub-items__el').hasClass('_active')) {
                $(this).parent('.catalog-sub-items__el').removeClass('_active');
                $(this).parent('.catalog-sub-items__el').find('._active').removeClass('_active');
            } else {
                $(this).parent('.catalog-sub-items__el').addClass('_active');
            }
        }

    });
    $('.catalog-sub-item.catalog-main2').click(function(e) {
        if($(this).parent('.catalog-sub-items__el').find('.catalog-sub-items__list').length > 0)
        {
            e.preventDefault();
            if ($(this).parent('.catalog-sub-items__el').hasClass('_active')) {
                $(this).parent('.catalog-sub-items__el').removeClass('_active');
            } else {
                $(this).parent('.catalog-sub-items__el').addClass('_active');
            }
        }
    });*/

    $('#go-back').click(function(e){
        parent.history.back();
    });

    $('.filters__view-button').click(function(e) {
        if(!$(this).hasClass('_active')){
            $('.filters__view-button').removeClass('_active');
            $(this).addClass('_active');

            if($(this).hasClass('_grid')){
                $('.catalog-grid').addClass('_grid');
                $('.catalog-grid').removeClass('_list');

                localStorage.setItem('catalog-grid', '_grid');
            }else if($(this).hasClass('_list')){
                $('.catalog-grid').addClass('_list');
                $('.catalog-grid').removeClass('_grid');

                localStorage.setItem('catalog-grid', '_list');
            }
        }
    });

    if(localStorage.getItem('catalog-grid'))
        $('.filters__view-button.' + localStorage.getItem('catalog-grid')).trigger('click');




    var main_slider = new Swiper ('#main-slider', {
        lazy: true,
        direction: "horizontal",
        loop: !0,
        autoplay: 6e3,
        iOSEdgeSwipeDetection: !0,
        spaceBetween: 10,
        centeredSlides: !0,
        slidesPerView: "auto",
        autoplay: {
            delay: 10000,
        },
    });

    var product_slider = new Swiper ('#product-slider', {
        lazy: true,
        direction: "horizontal",
        loop: !1,
        pagination: { el: '.swiper-pagination' },
        paginationClickable: true,
        iOSEdgeSwipeDetection: !0
    });


    $('.mount-search-bar').click(function(e) {
        app.componentDialog = 'search-dialog';
    });

    $('#write-review').click(function(e) {
        app.product_id = $(this).data('product_id');
        app.componentDialog = 'write-review';
    });

    $('#back-call').click(function(e) {
        app.componentDialog = 'back-call';
    });


    $('._scroll, .catalog-items').scroll(function(event) {

        var allimages = $(this).find('img.lazy');

        for (var i = 0; i < allimages.length; i++)
            $( allimages[i] ).attr("src",  $(allimages[i]).data('original'));

    });

});


function reviewLikeRating(review_id, like){
    productReviewSetLike(review_id, like, function (data) {
        if(data)
            location.reload();
    });
}

function buyIn1Click(product_id){
    app.product_id = product_id;
    app.componentDialog = 'buy-in-1-click';
}

function productSliderZoom(product_id){
    app.componentDialog = 'product_slider_zoom';
    app.product_id = product_id;
}

function _addToCart(product_id){
    if(addToCart(product_id))
    {
        Swal.fire({
            title: 'Товар в корзине',
            //text: "Товар в корзине",
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

Vue.config.productionTip = false;


Vue.component('product_slider_zoom', {
    data: function() {
        return{
            images: [],
            photo: '',
            youtube: '',
            swiper: null
        }
    },
    template: `
           <div class="dialog">
               <div class="topbar container g-bn">
                    <a class="topbar__icon icon icon_close" @click="close"></a>
               </div>
               <div class="dialog__content">
                  <div class="lightbox">
                     <div class="lightbox__images container">
                        <div class="swiper-container" id="ffffffff">
                           <div class="swiper-wrapper">
                              
                              <div class="swiper-slide">
                                <div class="lightbox__image-wrapper">
                                    <img :src="photo" class="lightbox__image">
                                </div>
                              </div>
                              
                              
                              <div class="swiper-slide" v-for="image in images">
                                <div class="lightbox__image-wrapper">
                                    <img :src="image" class="lightbox__image">
                                </div>
                              </div>
                              
                              <div class="swiper-slide" v-if="youtube">
                                 <div class="lightbox__image-wrapper">
                                    <iframe 
                                        :id="youtube" 
                                        frameborder="0" 
                                        allowfullscreen="1" 
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                        title="YouTube video player" 
                                        width="640" 
                                        height="360" 
                                        :src="'https://www.youtube.com/embed/' + youtube + '?rel=0&amp;enablejsapi=1&amp;origin=https%3A%2F%2Fkaspi.kz&amp;widgetid=1'">
                                    </iframe>
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     
                     <div class="lightbox__thumbs">
                        <div class="lightbox__thumb-focus" style="left: 18px;" v-if="false"></div>

                        <div class="lightbox__thumb-wrapper" @click="swiperCall(0)">
                            <img :src="photo" class="lightbox__thumb">
                        </div>

                        <div class="lightbox__thumb-wrapper" v-for="(image, index) in images" @click="swiperCall(index + 1)">
                            <img :src="image" class="lightbox__thumb">
                        </div>
                        
                        <div class="lightbox__thumb-wrapper _video play-icon" v-if="youtube" @click="swiperCall(images.length + 1)">
                            <img :src="'https://i.ytimg.com/vi/' + youtube + '/default.jpg'" class="lightbox__thumb">
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>   
    `,
    methods:{
        close(){
            app.componentDialog = '';
        },
        swiperCall(index){
            console.log(index);
            this.swiper.slideTo(index, 1000, false);
        }
    },
    created(){

        let data = new FormData();
        data.append('_token', getCsrfToken());

        var product_id = app.product_id;
        var self = this;

        axios.post('/product-images/' + product_id, data).then(function (response) {

            self.photo   = response.data.photo;
            self.images  = response.data.images;
            self.youtube = response.data.youtube;

            setTimeout(function() {
                self.swiper = new Swiper ('#ffffffff', {
                    direction: "horizontal",
                    loop: !1,
                    //pagination: { el: '.swiper-pagination' },
                    //paginationClickable: true,
                    iOSEdgeSwipeDetection: !0
                });
            }, 100);

        }).catch(function (error) {
            swalErrors(error.response.data.errors, 'Ошибка 422');
        });


    }
});



Vue.component('back-call', {
    data: function() {
        return{
            phone: user_info.phone,
            focus:{
                phone: 0,
            },
            wait: false
        }
    },
    template: `
        <div class="dialog">
            <form v-on:submit="backCall" method="post" enctype="multipart/form-data">
                <div class="dialog__content _topbar-off">
                        <div class="topbar container _filter-dialog">
                           <h1 class="topbar__heading">Заказать звонок</h1>
                           <div class="button _only-red-text" @click="close">Отмена</div>
                        </div>
                        
                        <h2 class="container-title">
                            Если у вас есть вопрос, укажите, что вас интересует и оставьте номер телефона. Мы перезвоним в удобное для вас время и ответим на ваш вопрос.
                        </h2>
                        
                        <div>
                            <div class="input" :class="{ '_has-value': phone, '_focused': focus.phone == 1, '_invalid': focus.phone == 2 && !phone }">
                                <label class="input__label">Введите номер телефона</label>
                                <input 
                                       type="tel"
                                       class="input__input phone-mask" 
                                       v-model="phone" 
                                       @focus="focus.phone = 1" 
                                       @blur="focus.phone = 2;phone = $event.target.value;"/>
                            </div>
                            <div class="input__has-error" v-if="focus.phone == 2">Пожалуйста, заполните это поле</div>
                        </div>                      
                </div>
                               
                <button type="submit" class="button _big _space">
                     <span class="ajax-loader">
                        <img v-show="wait" src="/site/images/ajax-loader.gif"/>
                        Заказать звонок
                     </span>
                </button>
                                
            </form>          
        </div>        
    `,
    methods:{
        close(){
            app.componentDialog = '';
        },
        backCall(event){
            event.preventDefault();
            var self = this;

            if(!this.wait) {
                this.wait = true;


                let data = new FormData();
                data.append('_token', getCsrfToken());
                data.append('phone', this.phone);

                axios.post('/callback', data).then(function (response) {
                    if (response.data)
                    {
                        self.close();
                        Swal({
                            title: 'Заказать звонок',
                            html: 'Заявка отправлена! В ближайшее время с Вами свяжется наш менеджер.'
                        });
                    }else{
                        alert('Ошибка БД');
                    }
                    self.wait = false;
                }).catch(function (error) {
                    swalErrors(error.response.data.errors, 'Ошибка 422');
                    self.wait = false;
                });

            }
        }
    },
    created(){
        setTimeout(function() {
            $(".phone-mask").mask("+7(999) 999-9999");
        }, 2000);
    },
});



Vue.component('buy-in-1-click', {
    data: function() {
        return{
            name:  user_info.name,
            email: user_info.email,
            phone: user_info.phone,
            focus:{
                name: 0,
                email: 0,
                phone: 0,
            },
            wait: false
        }
    },
    template: `
        <div class="dialog">
            <form v-on:submit="buyIn1Click" method="post" enctype="multipart/form-data">
                <div class="dialog__content _topbar-off" style="height: 400px;">
                        <div class="topbar container _filter-dialog">
                           <h1 class="topbar__heading">Быстрый заказ</h1>
                           <div class="button _only-red-text" @click="close">Отмена</div>
                        </div>
                        <div>
                            <div class="input" :class="{ '_has-value': name, '_focused': focus.name == 1, '_invalid': focus.name == 2 && !name }">
                                <label class="input__label">Имя</label>
                                <input 
                                    type="text" 
                                    class="input__input" 
                                    v-model="name" 
                                    @focus="focus.name = 1"
                                    @blur="focus.name = 2"/>
                            </div>
                            <div class="input__has-error" v-if="focus.name == 2">Пожалуйста, заполните это поле</div>
                        </div>
                        <div>
                            <div class="input" :class="{ '_has-value': email, '_focused': focus.email == 1, '_invalid': focus.email == 2 && !email }">
                                <label class="input__label">Ваш e-mail</label>
                                <input 
                                    type="email" 
                                    class="input__input" 
                                    v-model="email" 
                                    @focus="focus.email = 1"
                                    @blur="focus.email = 2"/>
                            </div>
                            <div class="input__has-error" v-if="focus.email == 2">Пожалуйста, заполните это поле</div>
                        </div>
                        <div>
                            <div class="input" :class="{ '_has-value': phone, '_focused': focus.phone == 1, '_invalid': focus.phone == 2 && !phone }">
                                <label class="input__label">Введите номер телефона</label>
                                <input 
                                       type="tel"
                                       class="input__input phone-mask" 
                                       v-model="phone" 
                                       @focus="focus.phone = 1" 
                                       @blur="focus.phone = 2;phone = $event.target.value;"/>
                            </div>
                            <div class="input__has-error" v-if="focus.phone == 2">Пожалуйста, заполните это поле</div>
                        </div>                      
                </div>
                
                <button type="submit" class="button _big _space">
                     <span class="ajax-loader">
                        <img v-show="wait" src="/site/images/ajax-loader.gif"/>
                        Заказать
                     </span>
                </button>
                
                
                
            </form>          
        </div>        
    `,
    methods:{
        close(){
            app.componentDialog = '';
        },
        buyIn1Click(event){
            event.preventDefault();
            var self = this;

            if(!this.wait) {
                this.wait = true;

                let data = new FormData();
                data.append('_token',     getCsrfToken());
                data.append('name',       this.name);
                data.append('email',      this.email);
                data.append('phone',      this.phone);
                data.append('product_id', app.product_id);

                axios.post('/one-click-order', data).then(function (response) {
                    if (response.data) {
                        this.order_id = response.data.order_id;
                        if (this.order_id) {
                            self.close();
                            Swal({
                                type: 'success',
                                html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + this.order_id + '">№:' + this.order_id + '</a>',
                                title: 'Ваш заказ успешно оформлен'
                            });
                        }
                    } else {
                        alert('Ошибка БД');
                    }
                    self.wait = false;
                }).catch(function (error) {
                    console.log(error);
                    swalErrors(error.response.data.errors, 'Ошибка 422');
                    self.wait = false;
                });
            }
        }
    },
    created(){
        setTimeout(function() {
            $(".phone-mask").mask("+7(999) 999-9999");
        }, 2000);
    },
});

Vue.component('write-review', {
    data: function() {
        return{
            rating: 5,
            plus: '',
            minus: '',
            name: '',
            email: '',
            comment: '',
            focus:{
                rating: 0,
                plus:    0,
                minus:   0,
                name:    0,
                email:   0,
                comment: 0,
            }
        }
    },
    template: `
        <div class="dialog">
            <div class="dialog__content _topbar-off">
                <form v-on:submit="writeReview" method="post" enctype="multipart/form-data">
                
                    <div class="topbar container _filter-dialog">
                       <h1 class="topbar__heading">Написать отзыв</h1>
                       <div class="button _only-red-text" @click="close">Отмена</div>
                    </div>
                                    
                    <div>
                        <div class="input" :class="{ '_has-value': rating, '_focused': focus.rating == 1, '_invalid': focus.rating == 2 && !rating }">
                            <label class="input__label">Оценка *</label>
                            <select class="input__input" v-model="rating" name="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="input__has-error">Пожалуйста, заполните это поле</div>
                    </div>
                    
                    
                    <div>
                        <div class="input" :class="{ '_has-value': plus, '_focused': focus.plus == 1, '_invalid': focus.plus == 2 && !plus }">
                            <label class="input__label">Достоинства</label>
                            <textarea name="plus" class="input__input" v-model="plus" @focus="focus.plus = 1" @blur="focus.plus = 2"></textarea>
                        </div>
                        <div class="input__has-error" v-if="focus.plus == 2">Пожалуйста, заполните это поле</div>
                    </div>
                    
                    
                    <div>
                        <div class="input" :class="{ '_has-value': minus, '_focused': focus.minus == 1, '_invalid': focus.minus == 2 && !minus }">
                            <label class="input__label">Недостатки</label>
                            <textarea name="minus" class="input__input" v-model="minus" @focus="focus.minus = 1" @blur="focus.minus = 2"></textarea>
                        </div>
                        <div class="input__has-error" v-if="focus.minus == 2">Пожалуйста, заполните это поле</div>
                    </div>
                    
                    
                    <div>
                        <div class="input" :class="{ '_has-value': name, '_focused': focus.name == 1, '_invalid': focus.name == 2 && !name }">
                            <label class="input__label">Ваше имя *</label>
                            <textarea name="name" class="input__input" v-model="name" @focus="focus.name = 1" @blur="focus.name = 2"></textarea>
                        </div>
                        <div class="input__has-error" v-if="focus.name == 2">Пожалуйста, заполните это поле</div>
                    </div>
                    
                    
                    <div>
                        <div class="input" :class="{ '_has-value': email, '_focused': focus.email == 1, '_invalid': focus.email == 2 && !email }">
                            <label class="input__label">Ваш e-mail</label>
                            <input name="email" type="email" class="input__input" v-model="email" @focus="focus.email = 1" @blur="focus.email = 2"/>
                        </div>
                        <div class="input__has-error" v-if="focus.email == 2">Пожалуйста, заполните это поле</div>
                    </div>
                    
                    
                    <div>
                        <div class="input" :class="{ '_has-value': comment, '_focused': focus.comment == 1, '_invalid': focus.comment == 2 && !comment }">
                            <label class="input__label">Комментарий *</label>
                            <textarea name="comment" class="input__input" v-model="comment" @focus="focus.comment = 1" @blur="focus.comment = 2"></textarea>
                        </div>
                        <div class="input__has-error" v-if="focus.comment == 2">Пожалуйста, заполните это поле</div>
                    </div>
                  
                   <button type="submit" class="button _big-fixed button-sellers">
                        Написать отзыв
                   </button>
              </form>
              
            </div>
        </div>        
    `,
    methods:{
        close(){
            app.componentDialog = '';
        },
        writeReview(event){
            event.preventDefault();

            var self = this;
            let data = new FormData(event.target);
            data.append('_token',     getCsrfToken());
            data.append('product_id', app.product_id);

            axios.post('/write-review', data).then(function (response){
                if(response){
                    Swal({
                        title: 'Написать отзыв',
                        html: 'Ваш отзыв успешно оставлен'
                    });
                    self.close();

                    setInterval(function () {
                        location.reload();
                    }.bind(this), 1000);

                }
            }).catch(function (error){
                swalErrors(error.response.data.errors, 'Ошибка 422');
            });

        }
    }
});

Vue.component('search-dialog', {
    data: function() {
        return  {
            search: '',
            result: []
        }
    },
    template: `<div class="dialog">
                <div class="dialog__content _topbar-off ">

                    <div class="search">
                        <div class="search__wrapper">
                            <form action="" class="search__input-wrapper">
                                <input v-model="search" type="search" class="search__input active" autofocus="" placeholder="Поиск товара">
                            </form>
                            <a @click="close" class="search__button button _only-red-text">Отмена</a>
                        </div>
                        <div class="search__suggestion-list">
                        
                            <a v-for="item in result" :href="item.url" class="catalog-item container _product-img">
                                <img :src="item.photo" width="35">&nbsp;
                                <span class="catalog-item__title">
                                    {{ item.name }}
                                    <br/>
                                    <b>{{ item.price }}</b>
                                </span>
                                <i class="catalog-item__icon icon icon_chevron"></i>
                            </a>
                        
                        </div>
                    </div>

                </div>
            </div>`,
    methods:{
        close(){
            app.componentDialog = '';
        },
        querySearch(){
            var self = this;

            console.log(self.search);

            axios.get('/product-search',{
                params: {
                    searchText: self.search,
                    maxResults: 10,
                }
            })
            .then(function (response) {
                console.log(response.data);
                self.result = response.data;
            });
        }
    },
    watch: {
        search: {
            handler: function (val, oldVal) {
                if(val)
                    this.querySearch();
                else
                    this.result = [];
            },
            deep: true
        }
    }
});

Vue.component('filters', {
    data: function() {
        return  {
            filters: JSON.parse($('#filters').val()),
            productsAttributesFilters: JSON.parse($('#productsAttributesFilters').val()),
            subMenu: 0,
            start_page: true
        }
    },
    template: `<div class="dialog a-fadeInRight">
                    <form id="filterpro">
                       <div class="dialog__content _topbar-off ">
                          <div class="filter-dialog">
                             <div class="filter-dialog__wrapper g-mb-gtn">
                                <div class="topbar container _filter-dialog">
                                   <div class="button _only-red-text" @click="close">{{ subMenu ? 'Назад' : 'Отмена'}}</div>
                                   <h1 class="topbar__heading">Фильтр</h1>
                                   <div class="button _only-red-text" @click="filtersClear">Сбросить</div>
                                </div>
                                <ul class="filter-dialog__ul">

                                    <li class="filter-dialog__el" v-for="attribute in productsAttributesFilters">
                                          <div class="filter-dialog__item container g-bb-thin" @click="subMenu = attribute.id" :class="{'g-hide': subMenu}">
                                             <a class="filter-dialog__description">
                                                <div class="filter-dialog__title">
                                                    {{ attribute.name }}
                                                </div>
                                                <div class="filter-dialog__check" v-html="selectedText(attribute)"></div>
                                             </a>
                                             <div class="filter-dialog__checkbox">
                                                <label>
                                                   <input type="checkbox" :checked="selectedText(attribute) ? true : false">
                                                   <div class="filter-dialog__checkbox-mask"><i class="icon icon_check"></i></div>
                                                </label>
                                             </div>
                                          </div>
                                          <ul class="filter-dialog__submenu" :class="{'_show': subMenu == attribute.id, 'g-hide': subMenu != attribute.id}">

                                                 <li class="filter-dialog__item container" v-for="(value, index) in attribute.values">
                                                    <label :for="'filter' + value.id" class="label-block">
                                                        <a class="filter-dialog__description">
                                                           <div class="filter-dialog__title">
                                                                 {{ value.value }}
                                                                <span class="filter-dialog__couter" v-if="false"> (94) </span>
                                                           </div>
                                                        </a>
                                                        <div class="filter-dialog__checkbox">
                                                           <label :for="'filter' + value.id">
                                                           
                                                              <input type="checkbox"
                                                                     :id="'filter' + value.id"
                                                                     :value="value.code"
                                                                     :name="attribute.code" 
                                                                     :checked="checked(attribute.code, value)"/>
                                                              
                                                              <div class="filter-dialog__checkbox-mask"> <i class="icon icon_check"></i> </div>
                                                           </label>
                                                        </div>
                                                    </label>    
                                                 </li>

                                          </ul>
                                    </li>

                                </ul>
                             </div>
                             
                             <div class="filter-dialog__button-space">
                                <a class="button _big" @click="urlParamsGenerate">Применить</a>
                             </div>
                             
                          </div>
                       </div>
                    </form>
              </div>`,
    methods:{
        close(){
            if(this.subMenu)
                this.subMenu = 0;
            else
                app.showFilters = false;
        },
        filtersClear(){
            filtersClear();
        },
        selectedText(attribute){
            var text = '';

            var arrayFilters = gerArrayFilters();
            if(!arrayFilters.length && this.start_page)
                arrayFilters = this.filters;

            this.start_page = false;

            if(arrayFilters[ attribute.code ])
            {
                arrayFilters = arrayFilters[ attribute.code ];
                Object.keys(arrayFilters).forEach(function (key1){

                    Object.keys(attribute.values).forEach(function (key2){
                        if(attribute.values[key2].code == arrayFilters[key1]){
                            text += attribute.values[key2].value + ', ';
                        }
                    });

                });
            }
            if(text)
                return text.slice(0, -2);
        },
        checked(code, value){

            var filters = this.filters[code] ? this.filters[code] : false;
            var result  = false;

            if(filters)
            {
                if($.isArray(filters) || typeof filters === 'object'){

                    Object.keys(filters).forEach(function (key){
                        if(filters[key] == value.code){
                            result = true;
                            return;
                        }
                    });

                }else {
                    if(filters == value.code)
                        result = true;
                }
            }

            return result;
        },
        urlParamsGenerate(){
            urlParamsGenerate();
        }
    },
    created(){
    },
    computed:{
        filtersfilters(){
            console.log(this.filters);
        }
    }
});

Vue.component('checkout', {
    template: `<div class="pickup__wrapper">

                    <span v-if="list_cart.length == 0">
                        <p class="container-title" v-if="order_id > 0">
                            Ваш заказ успешно оформлен, номер заказа <a style="font-size: 14px;" v-bind:href="'/order-history/' + order_id">№:{{ order_id }}</a>
                        </p>
                        <p v-else class="container-title">Ваша корзина пуста!</p> 
                    </span>
            
                    <div v-else>

                        <div class="container pickup-step g-bb-fat">
                            <div class="pickup-step__header">
                                <div class="pickup-step__number _active">1</div>
                                <h3 class="pickup-step__title">Способ доставки</h3>
                            </div>
                            <ul class="nav-pills g-bg-c0 g-bb0">
                                <li @click="selectedCarrier(item)"
                                    class="nav-pills__button g-ttu"
                                    v-bind:class="{'_active': item.id == carrier.id}"
                                    v-for="(item, index) in list_carriers">
                                        {{ item.name }}
                                </li>
                            </ul>
                        </div>

                        <div class="">

                            <div class="pickup__delivery-text-wrapper container g-bb-fat">
                                <span>
                                    <span class="pickup-point__info-delivery-link">{{ carrier.name }}</span>  
                                    {{ carrier.price > 0 ? ' - ' + carrier.format_price : ''}}
                                    <br/>
                                    <span class="pickup-point__date-delivery-label" v-html="carrier.delivery_text"></span>
                                    <br/>
                                    <a class="pickup__padding-top pickup-point__change-link g-mt0" href="/delivery-payment">Условия доставки</a>
                                </span>
                            </div>

                        
                            
                            <p class="container-title">Контакты</p>
                           
                            <div class="pickup-delivery g-bb-fat">
                                <div>
                                        <div class="input" :class="{ '_has-value': user.phone, '_focused': focus.phone == 1, '_invalid': focus.phone == 2 && !user.phone }">
                                            <label class="input__label">Телефон *</label>
                                           
                                            <input 
                                                type="tel"
                                                class="input__input phone-mask" 
                                                v-model="user.phone" 
                                                @focus="focus.phone = 1" 
                                                @blur="focus.phone = 2;user.phone = $event.target.value;"/>
                                        </div>
                                        <div class="input__has-error" v-if="focus.phone == 2">Пожалуйста, заполните это поле</div>
                                </div>
                                <div>
                                    <div class="input" :class="{ '_has-value': user.email, '_focused': focus.email == 1, '_invalid': focus.email == 2 && !user.email }">
                                        <label class="input__label">Email *</label>
                                        <input 
                                            class="input__input" 
                                            v-model="user.email" 
                                            @focus="focus.email = 1" 
                                            @blur="focus.email = 2"/>
                                    </div>
                                    <div class="input__has-error" v-if="focus.email == 2">Пожалуйста, заполните это поле</div>
                                </div>
                                <div>
                                    <div class="input" :class="{ '_has-value': user.name, '_focused': focus.name == 1, '_invalid': focus.name == 2 && !user.name }">
                                        <label class="input__label">Имя *</label>
                                        <input 
                                            class="input__input" 
                                            v-model="user.name" 
                                            @focus="focus.name = 1" 
                                            @blur="focus.name = 2"/>
                                    </div>
                                    <div class="input__has-error" v-if="focus.name == 2">Пожалуйста, заполните это поле</div>
                                </div>
                            </div>
                            
                            
                            <span v-if="carrier.id == 1">
                                <p class="container-title">Укажите адрес доставки</p>
                                
                                <div class="pickup-delivery g-bb-fat">
                                    <div>
                                        <div class="input" :class="{ '_has-value': address, '_focused': focus.address == 1, '_invalid': focus.address == 2 && !address }">
                                            <label class="input__label">Адрес *</label>
                                            <input 
                                                class="input__input" 
                                                v-model="address" 
                                                @focus="focus.address = 1" 
                                                @blur="focus.address = 2"/>
                                        </div>
                                        <div class="input__has-error" v-if="focus.address == 2">Пожалуйста, заполните это поле</div>
                                    </div>
                                    <div>
                                        <div class="input" :class="{ '_has-value': city, '_focused': focus.city == 1, '_invalid': focus.city == 2 && !city }">
                                            <label class="input__label">Город *</label>
                                            <input 
                                                class="input__input" 
                                                v-model="city" 
                                                @focus="focus.city = 1" 
                                                @blur="focus.city = 2"/>
                                        </div>
                                        <div class="input__has-error" v-if="focus.city == 2">Пожалуйста, заполните это поле</div>
                                    </div>
                                </div>    
                            </span>
                            
                            <p class="container-title">Оплата</p>
                            <div class="container pickup-step g-bb-fat">
                                <ul class="nav-pills g-bg-c0 g-bb0">
                                    <li 
                                        @click="selectedPayment(item)" 
                                        v-for="item in list_payments" 
                                        class="nav-pills__button g-ttu"
                                        v-bind:class="{'_active': item.id == payment.id}">
                                             {{ item.name }}
                                             <!--<img width="20" v-bind:src="item.logo">-->
                                    </li>
                                </ul>
                            </div>
                            
                           
                            <p class="container-title">Комментарий к заказу</p> 
                            <div class="pickup-delivery g-bb-fat">
                                <div>
                                        <div class="input" :class="{ '_has-value': comment, '_focused': focus.comment == 1 }">
                                            <label class="input__label">Комментарий к заказу</label>
                                             <textarea
                                                   v-model="comment" 
                                                   name="comment"
                                                   @focus="focus.comment = 1" 
                                                   @blur="focus.comment = 2"
                                                   class="input__input"></textarea>
                                        </div>
                                        <div class="input__has-error" v-if="focus.comment == 2">Пожалуйста, заполните это поле</div>
                                </div>
                            </div>    
                           
                           
                           <p class="container-title">Состав заказа</p> 
                           
                           
                          <div v-for="(item, index) in list_cart">
                              <div class="header-cart__content">
                                    <a v-bind:href="item.product_url"class="header-cart__image-wrapper">
                                        <img 
                                            height="105" 
                                            width="140" 
                                            v-bind:src="item.product_photo"
                                            v-bind:alt="item.product_name"
                                            v-bind:title="item.product_name"
                                            class="header-cart__image">
                                    </a>
                                    <div class="header-cart__info">
                                        <h3 class="header-cart__name">
                                            <a  v-bind:href="item.product_url" class="header-cart__name-link">
                                                 {{ item.product_name }}
                                            </a>
                                        </h3>
                                        <div class="header-cart__more-info" v-if="false">Гипермаркет шин ecar-kz</div>
                                        <div class="header-cart__prices">
                                            <div class="header-cart__debet">
                                                <span class="header-cart__price">{{ item.product_specific_price }}</span>
                                                <br/>
                                                <span class="header-cart__price">{{ item.quantity }} шт. x {{ item.sum }}</span>
                                            </div>
                                        </div>
                                    </div>
                              </div>
                              <div class="container product-quantity g-bt-thin">
                                    <div class="product-quantity__counter">
                                            <button @click="decreaseProductQuantity(item, index)" class="product-quantity__counter-button _minus" :class="{'_disabled' : item.quantity == 1}"></button>
                                            <div class="product-quantity__counter-number">
                                                {{ item.quantity }}
                                            </div>
                                            <button  @click="increaseProductQuantity(item, index)" class="product-quantity__counter-button _plus"></button>
                                            <div class="product-quantity__text">шт</div>
                                    </div>
                              </div>
                              <div class="container text-center">
                                 <a class="button" @click="deleteProductQuantity(item.product_id)">Удалить</a>
                              </div>   
                          </div> 
                          
                          <div class="header-cart__content">
                                <div class="header-cart__info">
                                    <p class="header-cart__total-info"><b>Доставка:</b> {{ carrier.format_price }}</p>
                                    <p class="header-cart__total-info"><b>Количество:</b> {{ cart_total.quantity }}</p>
                                    <p class="header-cart__total-info"><b>Итого:</b> {{ cart_total.sum }}</p>
                                </div>
                          </div>

                          <div class="header-cart__content">
                              <button class="button _big _space" @click="checkout">
                                    <span class="ajax-loader">
                                        <img v-show="checkout_wait" src="/site/images/ajax-loader.gif"/>
                                        Оформить заказ
                                    </span>
                              </button>
                          </div>    
                    
                        </div>
                    </div>
                </div>`,
    data () {
        return {
            list_cart: [],
            list_carriers: [],
            list_payments: [],
            cart_total: {
                sum: 0,
                quantity: 0
            },
            order_id: 0,

            carrier: {},
            payment: {},
            city: '',
            address: '',
            user:{
                name:  user_info.name,
                email: user_info.email,
                phone: user_info.phone,
            },
            comment: '',

            checkout_wait: false,

            focus:{
                phone: 0,
                email: 0,
                name: 0,
                address: 0,
                city: 0,
                comment: 0
            }
        }
    },
    updated () {

    },
    methods:{
        selectedCarrier(item){
            this.carrier = item;
        },
        selectedPayment(item){
            this.payment = item;
        },
        listCart(){
            axios.post('/list-cart').then((res)=>{
                this.list_cart = res.data;
            });
        },
        decreaseProductQuantity(item, index){
            if(this.list_cart[index].quantity > 1)
                this.cartSave(item.product_id, this.list_cart[index].quantity -1 );
        },
        increaseProductQuantity(item, index){
            this.cartSave(item.product_id, this.list_cart[index].quantity + 1);
        },
        deleteProductQuantity(product_id){
            axios.post('/cart-delete/' + product_id).then((res)=>{
                if(res.data)
                {
                    this.listCart();
                    this.cartTotal();
                }
            });
        },
        cartTotal(){
            axios.get('/cart-total/' + (this.carrier.id ? this.carrier.id : 0)).then((res)=>{
                this.cart_total.sum = res.data.sum;
                this.cart_total.quantity = res.data.quantity;
            });
        },
        cartSave(product_id, quantity){
            axios.post('/cart-save', {product_id: product_id, quantity: quantity}).then((res)=>{
                if(res.data)
                {
                    this.listCart();
                    this.cartTotal();
                }
            });
        },
        async checkout(){
            if(!this.checkout_wait)
            {
                this.checkout_wait = true;

                var data = {
                    carrier_id: this.carrier.id,
                    payment_id: this.payment.id,
                    city:       this.city,
                    address:    this.address,
                    user: {
                        phone: this.user.phone,
                        email: this.user.email,
                        name:  this.user.name
                    },
                    comment: this.comment
                };


                var self = this;

                await axios.post('/checkout', data).then((res) => {
                    var data = res.data;
                    if (data) {
                        self.order_id = data['order_id'];
                        if (self.order_id) {
                            self.list_cart = [];
                            Swal({
                                type: 'success',
                                html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + self.order_id + '">№:' + self.order_id + '</a>',
                                title: 'Ваш заказ успешно оформлен'
                            });
                        }
                    }
                }).catch(function (error){
                    swalErrors(error.response.data.errors, 'Ошибка 422');
                });

                this.checkout_wait = false;
            }
        }
    },
    watch: {
        carrier: {
            handler: function (val, oldVal) {
                this.cartTotal();
            },
            deep: true
        }
    },
    created(){

        this.listCart();
        this.cartTotal();

        axios.post('/list-carriers').then((res)=>{
            if(res.data){
                this.list_carriers = res.data;
                this.carrier = this.list_carriers[0];
            }
        });

        axios.post('/list-payments').then((res)=>{
            if(res.data)
                this.list_payments = res.data;
            this.payment = this.list_payments[0];
        });

        setTimeout(function() {
            $(".phone-mask").mask("+7(999) 999-9999");
        }, 2000);

    },
    updated(){

    }

});

const app = new Vue({
    el: '#app',
    data: {
        componentDialog:   '',
        open_sort_catalog: false,
        showFilters:       false,
        product_id:        0,
    },
    methods:{
        catalogSort(sort){
            console.log(sort);
            $('.sort_select option[value=' + sort + ']').prop('selected', true).attr('selected', 'true');
            $('.sort_select').change();
        }
    }
});
