<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="bannerSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ banner.id ? 'Редактировать' : 'Создать' }}</h3>
                     </div>
                     <div class="box-body row">

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('banner.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="banner.name" type="text" class="form-control">
                             <span v-if="IsError('banner.name')" class="help-block" v-for="e in IsError('banner.name')">
                                 {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('banner.link')}">
                             <label>Ссылка <span class="red">*</span></label>
                             <input v-model="banner.link" type="text" class="form-control">
                             <span v-if="IsError('banner.link')" class="help-block" v-for="e in IsError('banner.link')">
                                 {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('banner.body')}">
                             <label>Тело <span class="red">*</span></label>
                             <Ckeditor v-model="banner.body" :uploadFilePath="'uploads/banners/'"></Ckeditor>
                             <span v-if="IsError('banner.body')" class="help-block" v-for="e in IsError('banner.body')">
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

                             <router-link :to="{path: '/banners'}" class="btn btn-default">
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
    import Ckeditor from  '../plugins/Ckeditor';

    export default {
        components:{
            Ckeditor
        },
        data () {
            return {
                method_redirect: 'save_and_back',
                banner:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    link: '',
                    body: '',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(this.banner.id > 0)
            {
                axios.get('/admin/banner-view/' + this.banner.id).then((res)=>{
                    var res = res.data;

                    this.banner.id    = res.id;
                    this.banner.name  = res.name;
                    this.banner.link  = res.link;
                    this.banner.body  = res.body;
                });
            }
        },
        methods:{
            setLogo(event){
                this.banner.logo = event.target.files[0];
                this.$helper.setImgSrc(event.target.files[0], '#logo-view');
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            bannerSave(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/banner-save', {banner: this.banner}).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.banner.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.banner.id)
                            {
                                this.banner.id = res.data;
                                this.$router.push('/banners/edit/' + this.banner.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/banners/create';

                            this.banner = {
                                id:   0,
                                name: '',
                                link: '',
                                body: ''
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