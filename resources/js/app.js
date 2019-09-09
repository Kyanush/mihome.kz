/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Роутеры
import router from './router'

//Функции
import Helper from './packages/Helper';
Vue.use(Helper);

//Vuex
import store from './store';

axios.interceptors.response.use(function (response) {
    //console.log(response);

    var res = response;

    if(res.data === '')
        Vue.helper.swalError('Пустой результат');
    else if(!res.data)
        console.log(['Ошибка!', res.data]);

    return response;
}, function (error) {

    //console.log(error.response);


    var status =  error.response.status
    var res    = error.response;

    console.log(status);
    console.log(res);



    if(status == 401){
        Vue.swal.fire({
            text: "Время авторизации истекло. Пожалуйста, авторизуйтесь заново.",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#72BF44',
            confirmButtonText: 'Авторизоваться'
        }).then((result) => {
            if (result.value)
                location.href = '/login';
        });
    }
    else if(status == 404 || status == 403){
        Vue.helper.swalError(res.data, status);

    }else if(status == 422){
        var errors = null;
        if(res.data.errors)
            errors = res.data.errors;
        else if(res.data)
            errors = res.data;

        if(errors){
            store.dispatch('SetErrors', errors);
            Vue.helper.swalError(store.getters.ListErrors);
        }else
            console.log(['Ошибка!', res.data]);

    }else if(status == 500){
        if(res.data.message.indexOf('foreign key') !== -1){
            Vue.helper.swalError("Вы не можете удалить, есть привязанные элементы!", 500);
        }else
            Vue.helper.swalError("Ошибка сервера! Сообщите об этой проблеме администратором сайта", 500);

    }else if(status == 200){
        if(res.data === '')
            Vue.helper.swalError('Пустой результат');
        else if(!res.data)
            console.log(['Ошибка!', res.data]);
    }

    return error;
});

//Попап
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

//mask input
const VueInputMask = require('vue-inputmask').default
Vue.use(VueInputMask);

router.beforeEach((to, from, next) => {
    if (to.name)
        document.title = to.name;
    store.dispatch('SetErrors', null);
    return next();
});

const app = new Vue({
    el: '#app',
    router,
    store
});