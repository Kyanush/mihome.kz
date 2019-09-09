<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="newsave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ news.id ? 'Редактировать' : 'Создать'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.title')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="news.title" type="text" class="form-control">
                             <span v-if="IsError('news.title')" class="help-block" v-for="e in IsError('news.title')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.code')}">
                             <label>Ссылка</label>
                             <input v-model="news.code" type="text" class="form-control">
                             <span v-if="IsError('news.code')" class="help-block" v-for="e in IsError('news.code')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.created_at')}">
                             <label>Дата</label>
                             <date-picker :config="datetimepicker" v-model="news.created_at"></date-picker>
                             <span v-if="IsError('news.created_at')" class="help-block" v-for="e in IsError('news.created_at')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.image')}">
                             <label>Картина</label>
                             <p>
                                 <img id="image-view" class="img" width="100" v-bind:src="news.image ? '/uploads/news/' + news.image : ''"/>
                             </p>
                             <label class="btn btn-primary btn-file">
                                 <i class="fa fa-file-image-o" aria-hidden="true"></i>  Картина
                                 <input  type="file" accept="image/*"  @change="setImage($event)"/>
                             </label>
                             <span v-if="IsError('news.image')" class="help-block" v-for="e in IsError('news.image')">
                                   {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.preview_text')}">
                             <label>Описание</label>
                             <Ckeditor v-model="news.preview_text"></Ckeditor>
                             <span v-if="IsError('news.preview_text')" class="help-block" v-for="e in IsError('news.preview_text')">
                                 {{ e }}
                             </span>
                         </div>

                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.detail_text')}">
                             <label>Текст</label>
                             <Ckeditor v-model="news.detail_text"></Ckeditor>
                             <span v-if="IsError('news.detail_text')" class="help-block" v-for="e in IsError('news.detail_text')">
                                 {{ e }}
                             </span>
                         </div>


                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('news.active')}">
                             <label>Статус</label>
                             <select v-model="news.active" class="form-control">
                                 <option value="1">Активный</option>
                                 <option value="0">Неактивный</option>
                             </select>
                             <span v-if="IsError('news.active')" class="help-block" v-for="e in IsError('news.active')">
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

                             <router-link :to="{path: '/news'}" class="btn btn-default">
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

    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {
        components:{
            Ckeditor, datePicker
        },
        data () {
            return {
                method_redirect: 'save_and_back',
                news:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    title: '',
                    code: '',
                    created_at: '',
                    image: '',
                    preview_text: '',
                    detail_text: '',
                    active: 1
                },
                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    locale: 'ru'
                },
            }
        },
        created(){
            if(this.news.id > 0)
            {
                axios.get('/admin/news-view/' + this.news.id).then((res)=>{
                    var data = res.data;

                    this.news.id           = data.id;
                    this.news.title        = data.title;
                    this.news.code         = data.code;
                    this.news.created_at   = data.created_at;
                    this.news.image        = data.image;
                    this.news.preview_text = data.preview_text;
                    this.news.detail_text  = data.detail_text;
                    this.news.active       = data.active;
                });
            }
        },
        methods:{
            setImage(event){
                this.news.image = event.target.files[0];
                this.$helper.setImgSrc(event.target.files[0], '#image-view');
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            newsave(event){
                event.preventDefault();
                this.SetErrors(null);

                var data = this.$helper.formData(this.news, 'news');

                axios.post('/admin/news-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.news.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.news.id)
                            {
                                this.news.id = res.data;
                                this.$router.push('/news/edit/' + this.news.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/news/create';

                            this.news = {
                                id:    0,
                                title: '',
                                code:  '',
                                created_at: '',
                                image: '',
                                preview_text: '',
                                detail_text:  '',
                                active:       1
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