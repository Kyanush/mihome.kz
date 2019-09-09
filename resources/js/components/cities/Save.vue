<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="orderStatusSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ city.id ? 'Редактировать' : 'Создать'}}</h3>
                     </div>
                     <div class="box-body row">

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('city.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="city.name" type="text" class="form-control">
                             <span v-if="IsError('city.name')" class="help-block" v-for="e in IsError('city.name')">
                                 {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('city.code')}">
                             <label>Код</label>
                             <input v-model="city.code" type="text" class="form-control">
                             <span v-if="IsError('city.code')" class="help-block" v-for="e in IsError('city.code')">
                                 {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('city.sort')}">
                             <label>Сортировка</label>
                             <input v-model="city.sort" type="text" class="form-control">
                             <span v-if="IsError('city.sort')" class="help-block" v-for="e in IsError('city.sort')">
                                 {{ e }}
                             </span>
                         </div>
                         
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('city.active')}">
                             <label>Активно <span class="red">*</span></label>
                             <select v-model="city.active" class="form-control">
                                 <option value="1">Да</option>
                                 <option value="0">Нет</option>
                             </select>
                             <span v-if="IsError('city.active')" class="help-block" v-for="e in IsError('city.active')">
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

                             <router-link :to="{path: '/cities'}" class="btn btn-default">
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
                city:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    code: '',
                    sort: 0,
                    active: 1,
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.city.id > 0)
            {
                axios.get('/admin/city-view/' + this.city.id).then((res)=>{
                    var res = res.data;

                    this.city.id      = res.id;
                    this.city.name    = res.name;
                    this.city.code    = res.code;
                    this.city.sort    = res.sort;
                    this.city.active  = res.active;
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

                axios.post('/admin/city-save', {city: this.city}).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.city.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.city.id)
                            {
                                this.city.id = res.data;
                                this.$router.push('/cities/edit/' + this.city.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/cities/create';

                            this.city.id      = 0;
                            this.city.name    = '';
                            this.city.code    = '';
                            this.city.sort    = 0;
                            this.city.active  = 1;
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
