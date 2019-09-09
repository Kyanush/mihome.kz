<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="carrierSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ carrier.id ? 'Редактировать' : 'Создать'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('carrier.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="carrier.name" type="text" class="form-control">
                             <span v-if="IsError('carrier.name')" class="help-block" v-for="e in IsError('carrier.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('carrier.price')}">
                             <label>Цена</label>
                             <input v-model="carrier.price" type="text" class="form-control">
                             <span v-if="IsError('carrier.price')" class="help-block" v-for="e in IsError('carrier.price')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('carrier.delivery_text')}">
                             <label>Описание</label>
                             <textarea v-model="carrier.delivery_text" class="form-control"></textarea>
                             <span v-if="IsError('carrier.delivery_text')" class="help-block" v-for="e in IsError('carrier.delivery_text')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('carrier.logo')}">
                             <label>Логотип</label>
                             <p>
                                 <img id="logo-view" class="img" width="100" v-bind:src="carrier.logo ? '/uploads/carriers/' + carrier.logo : ''"/>
                             </p>
                             <label class="btn btn-primary btn-file">
                                 <i class="fa fa-file-image-o" aria-hidden="true"></i>  Логотип
                                 <input type="file" accept="image/*"  @change="setLogo($event)"/>
                             </label>
                             <span v-if="IsError('carrier.logo')" class="help-block" v-for="e in IsError('carrier.logo')">
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

                             <router-link :to="{path: '/carriers'}" class="btn btn-default">
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
                carrier:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    price: 0,
                    delivery_text: '',
                    logo: ''
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.carrier.id > 0)
            {
                axios.get('/admin/carrier-view/' + this.carrier.id).then((res)=>{
                    var res = res.data;

                    this.carrier.id            = res.id;
                    this.carrier.name          = res.name;
                    this.carrier.price         = res.price;
                    this.carrier.delivery_text = res.delivery_text;
                    this.carrier.logo          = res.logo;
                });
            }
        },
        methods:{
            setLogo(event){
                this.carrier.logo = event.target.files[0];
                this.$helper.setImgSrc(event.target.files[0], '#logo-view');
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            carrierSave(event){
                event.preventDefault();
                this.SetErrors(null);

                console.log(this.carrier);
                var data = this.$helper.formData(this.carrier, 'carrier');

                axios.post('/admin/carrier-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.carrier.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.carrier.id)
                            {
                                this.carrier.id = res.data;
                                this.$router.push('/carriers/edit/' + this.carrier.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/carriers/create';

                            this.carrier = {
                                id: 0,
                                name: '',
                                price: 0,
                                delivery_text: '',
                                logo: ''
                            };
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