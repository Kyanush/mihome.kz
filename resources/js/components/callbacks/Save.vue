<template>
    <div class="col-md-8 col-md-offset-2">

        <history_back></history_back>

        <form v-on:submit="callbackSave">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ callback.id ? 'Редактировать' : 'Создать'}}</h3>
                </div>
                <div class="box-body row">

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.type')}">
                        <label>Тип <span class="red">*</span></label>
                        <input disabled type="text" v-model="callback.type" class="form-control"/>
                        <span v-if="IsError('callback.type')" class="help-block" v-for="e in IsError('callback.type')">
                              {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.status_id')}">
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

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.phone')}">
                        <label>Телефон <span class="red">*</span></label>
                        <input disabled v-model="callback.phone" type="text" class="form-control">
                        <span v-if="IsError('callback.phone')" class="help-block" v-for="e in IsError('callback.phone')">
                             {{ e }}
                         </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.message')}">
                        <label>Сообщение</label>
                        <textarea disabled rows="5" v-model="callback.message" class="form-control"></textarea>
                        <span v-if="IsError('callback.message')" class="help-block" v-for="e in IsError('callback.message')">
                                 {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.email')}">
                        <label>E-mail</label>
                        <input disabled v-model="callback.email" type="text" class="form-control">
                        <span v-if="IsError('callback.email')" class="help-block" v-for="e in IsError('callback.email')">
                             {{ e }}
                         </span>
                    </div>

                    <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('callback.comment')}">
                        <label>Комментарий администратора</label>
                        <textarea rows="5" v-model="callback.comment" class="form-control"></textarea>
                        <span v-if="IsError('callback.comment')" class="help-block" v-for="e in IsError('callback.comment')">
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
                            </ul>

                        </div>

                        <router-link :to="{path: '/callbacks'}" class="btn btn-default">
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
                callback:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    type:    'Обратный звонок',
                    status:  0,
                    phone:   '',
                    message: '',
                    email:   '',
                    comment: ''
                },
                statuses: []
            }
        },
        created(){
            if(this.callback.id > 0)
            {
                axios.get('/admin/callback-view/' + this.callback.id).then((res)=>{
                    var res = res.data;
                    this.callback.id      = res.id;
                    this.callback.type    = res.type;
                    this.callback.status_id  = res.status_id;
                    this.callback.phone   = res.phone;
                    this.callback.message = res.message;
                    this.callback.email   = res.email;
                    this.callback.comment = res.comment;
                });
            }

            axios.post('/admin/statuses/1').then((res)=>{
                this.statuses = res.data;
            });
        },
        methods:{
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            callbackSave(event){
                event.preventDefault();
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
                                this.$router.push('/callbacks/edit/' + this.callback.id);
                            }
                        }
                    }
                });

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
