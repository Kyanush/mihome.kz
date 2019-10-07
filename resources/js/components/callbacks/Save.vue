<template>
    <div class="col-md-12">

        <history_back></history_back>

        <form v-on:submit="callbackSave">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ callback.id ? 'Редактировать' : 'Создать'}}</h3>
                </div>
                <div class="box-body">

                    <div class="nav-tabs-custom" id="form_tabs">
                        <ul class="nav nav-tabs">
                            <li v-bind:class="{'active' : tab_active == 'main'}" @click="setTab('main')">
                                <a>
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    Инфо
                                </a>
                            </li>
                            <li v-bind:class="{'active' : tab_active == 'orders'}" @click="setTab('orders')">
                                <a>
                                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                    Что заказал клиент
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div v-bind:class="{'active' : tab_active == 'main'}" role="tabpanel" class="tab-pane" id="main">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.type')}">
                                    <label>Тип <span class="red">*</span></label>
                                    <input disabled type="text" v-model="callback.type" class="form-control"/>
                                    <span v-if="IsError('callback.type')" class="help-block" v-for="e in IsError('callback.type')">
                                      {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.status_id')}">
                                    <label>Статус <span class="red">*</span></label>
                                    <select v-model="callback.status_id" class="selectpicker form-control">
                                        <option v-for="status in statuses"
                                                :data-icon="status.class"
                                                :value="status.id">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                    <span v-if="IsError('callback.status_id')" class="help-block" v-for="e in IsError('callback.status_id')">
                                          {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.phone')}">
                                    <label>Телефон <span class="red">*</span></label>
                                    <input disabled v-model="callback.phone" type="text" class="form-control">
                                    <span v-if="IsError('callback.phone')" class="help-block" v-for="e in IsError('callback.phone')">
                                         {{ e }}
                                     </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.email')}">
                                    <label>E-mail</label>
                                    <input disabled v-model="callback.email" type="text" class="form-control">
                                    <span v-if="IsError('callback.email')" class="help-block" v-for="e in IsError('callback.email')">
                                         {{ e }}
                                     </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.message')}">
                                    <label>Сообщение</label>
                                    <textarea disabled rows="5" v-model="callback.message" class="form-control"></textarea>
                                    <span v-if="IsError('callback.message')" class="help-block" v-for="e in IsError('callback.message')">
                                       {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('callback.comment')}">
                                    <label>Комментарий администратора</label>
                                    <textarea rows="5" v-model="callback.comment" class="form-control"></textarea>
                                    <span v-if="IsError('callback.comment')" class="help-block" v-for="e in IsError('callback.comment')">
                                             {{ e }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-bind:class="{'active' : tab_active == 'orders'}" role="tabpanel" class="tab-pane" id="orders">
                             <span v-if="orders_detail_show">
                                 <orders_detail :prop_order="{
                                                    id:         callback.order_id,
                                                    type_id:    6,
                                                    phone:      callback.phone,
                                                    email:      callback.email,
                                                    created_at: callback.created_at
                                                }"
                                                :prop_callback_id="callback.id"/>
                             </span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div  class="form-group">
                        <div class="btn-group">

                            <button type="submit" class="btn btn-success" @click="setMethodRedirect('save_and_back')">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и назад</span>
                            </button>

                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">▼</span>
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a @click="setMethodRedirect('save_and_continue')">
                                        <button type="submit" class="btn-transparent">Сохранить и продолжить</button>
                                    </a>
                                </li>
                            </ul>

                        </div>

                        <router-link :to="{ name: 'callbacks' }" class="btn btn-default">
                            <span class="fa fa-ban"></span> &nbsp;
                            Отменить
                        </router-link>

                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </form>


    </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import orders_detail from '../orders/Detail';

    export default {
        components:{
            orders_detail
        },
        data () {
            return {
                tab_active: 'main',
                method_redirect: 'save_and_back',
                callback:{
                    id: this.$route.params.callback_id ? this.$route.params.callback_id : 0,
                    type:    'Обратный звонок',
                    status:  0,
                    phone:   '',
                    message: '',
                    email:   '',
                    comment: '',
                    order_id: 0,
                    callback: ''
                },
                statuses: [],
                orders_detail_show: false
            }
        },
        created(){
            var callback_id = this.callback.id;
            if(callback_id){
                axios.get('/admin/callback-view/' + callback_id).then((res)=>{
                    var res = res.data;
                    this.callback.id         = res.id;
                    this.callback.type       = res.type;
                    this.callback.status_id  = res.status_id;
                    this.callback.phone      = res.phone;
                    this.callback.message    = res.message;
                    this.callback.email      = res.email;
                    this.callback.comment    = res.comment;
                    this.callback.order_id   = res.order_id;
                    this.callback.created_at = res.created_at;

                    this.orders_detail_show  = true;
                });
            }
            else
                this.orders_detail_show = true;

            axios.get('/admin/status/callbacks-status-id').then((res)=>{
                this.statuses = res.data;
            });
        },
        methods:{
            setTab(tab){
                this.tab_active = tab;

                if(tab == 'main')
                {
                    axios.get('/admin/callback-view/' + this.callback.id).then((res)=>{
                        var res = res.data;
                        this.callback.order_id = res.order_id;
                    });
                }
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            callbackSave(event){
                event.preventDefault();

                if(this.callback.status_id == 2 && !this.callback.order_id)
                {
                    this.tab_active = 'orders';
                    this.$swal({
                        type: 'error',
                        title: 'Добавьте что купил клиент'
                    });
                }else{
                    this.SetErrors(null);
                    axios.post('/admin/callback-save', {callback: this.callback}).then((res)=>{
                        if(res.data)
                        {
                            this.$helper.swalSuccess(this.callback.id ? 'Успешно изменено' : 'Успешно создано');

                            if(this.method_redirect == 'save_and_back'){
                                history.back();

                            }else if(this.method_redirect == 'save_and_continue'){
                                if(!this.callback.id)
                                {
                                    this.callback.id = res.data;
                                    this.$router.push({
                                        name: 'callback',
                                        params:{
                                            callback_id: this.callback.id
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            },
            ...mapActions(['SetErrors'])
        },
        updated(){
            $(".phone-mask").mask("+7(999) 999-9999");
            $('.selectpicker').selectpicker('refresh');
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        }
    }
</script>
