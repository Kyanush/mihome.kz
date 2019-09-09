<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="orderStatusSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ order_status.id ? 'Редактировать' : 'Создать категорию'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('order_status.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="order_status.name" type="text" class="form-control">
                             <span v-if="IsError('order_status.name')" class="help-block" v-for="e in IsError('order_status.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('order_status.class')}">
                             <label>Класс <span class="red">*</span></label>
                             <input v-model="order_status.class" type="text" class="form-control">
                             <span v-if="IsError('order_status.class')" class="help-block" v-for="e in IsError('order_status.class')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('order_status.description')}">
                             <label>Описание <span class="red">*</span></label>
                             <textarea v-model="order_status.description" class="form-control"></textarea>
                             <span v-if="IsError('order_status.description')" class="help-block" v-for="e in IsError('order_status.description')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('order_status.notification')}">
                             <label>Отправить уведомление <span class="red">*</span></label>
                             <select v-model="order_status.notification" class="form-control">
                                 <option value="1">Да</option>
                                 <option value="0">Нет</option>
                             </select>
                             <span v-if="IsError('order_status.notification')" class="help-block" v-for="e in IsError('order_status.notification')">
                                 {{ e }}
                             </span>
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
                                     <li>
                                         <a @click="setMethodRedirect('save_and_new')">
                                             <button type="submit" class="btn-transparent">Сохранить и новый</button>
                                         </a>
                                     </li>
                                 </ul>

                             </div>

                             <router-link :to="{path: '/order-statuses'}" class="btn btn-default">
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

    export default {
        data () {
            return {
                method_redirect: 'save_and_back',
                order_status:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    class: '',
                    description: '',
                    notification: 1,
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.order_status.id > 0)
            {
                axios.get('/admin/order-status-view/' + this.order_status.id).then((res)=>{
                    var res = res.data;

                    this.order_status.id      = res.id;
                    this.order_status.name    = res.name;
                    this.order_status.class    = res.class;
                    this.order_status.description    = res.description;
                    this.order_status.notification   = res.notification;
                });
            }
        },
        methods:{
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            orderStatusSave(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/order-status-save', {order_status: this.order_status}).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.order_status.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.order_status.id)
                            {
                                this.order_status.id = res.data;
                                this.$router.push('/order-statuses/edit/' + this.order_status.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/order-statuses/create';

                            this.order_status.id      = 0;
                            this.order_status.name    = '';
                            this.order_status.class    = '';
                            this.order_status.description    = '';
                            this.order_status.notification   = 1;
                        }

                    }
                });

            },
            ...mapActions(['SetErrors'])
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        }
    }
</script>
