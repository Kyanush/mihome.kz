<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="paymentSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ payment.id ? 'Редактировать тип оплаты' : 'Создать тип оплаты'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('payment.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="payment.name" type="text" class="form-control">
                             <span v-if="IsError('payment.name')" class="help-block" v-for="e in IsError('payment.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('payment.logo')}">
                             <label>Логотип</label>
                             <p>
                                 <img width="100" class="img" v-bind:src="payment.logo ? '/uploads/payments/' + payment.logo : ''"/>
                             </p>
                             <label class="btn btn-primary btn-file">
                                 <i class="fa fa-file-image-o" aria-hidden="true"></i>  Логотип
                                 <input type="file" accept="image/*"  @change="setLogo($event)"/>
                             </label>
                             <span v-if="IsError('payment.logo')" class="help-block" v-for="e in IsError('payment.logo')">
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

                             <router-link :to="{path: '/payments'}" class="btn btn-default">
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
                payment:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    logo: ''
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.payment.id > 0)
            {
                axios.get('/admin/payment-view/' + this.payment.id).then((res)=>{
                    var res = res.data;

                    this.payment.id            = res.id;
                    this.payment.name          = res.name;
                    this.payment.logo          = res.logo;
                });
            }
        },
        methods:{
            setLogo(event){
                this.payment.logo = event.target.files[0];
                this.$helper.setImgSrc(event.target.files[0], '#logo-view');
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            paymentSave(event){
                event.preventDefault();
                this.SetErrors(null);

                console.log(this.payment);
                var data = this.$helper.formData(this.payment, 'payment');

                axios.post('/admin/payment-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.payment.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.payment.id)
                            {
                                this.payment.id = res.data;
                                this.$router.push('/payments/edit/' + this.payment.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/payments/create';

                            this.payment = {
                                id: 0,
                                name: '',
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