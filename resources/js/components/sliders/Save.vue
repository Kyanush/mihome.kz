<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="sliderSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ slider.id ? 'Редактировать' : 'Создать'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="slider.name" type="text" class="form-control">
                             <span v-if="IsError('slider.name')" class="help-block" v-for="e in IsError('slider.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.link')}">
                             <label>Ссылка</label>
                             <input v-model="slider.link" type="text" class="form-control">
                             <span v-if="IsError('slider.link')" class="help-block" v-for="e in IsError('slider.link')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.image')}">
                             <label>Картина</label>
                             <p>
                                 <img id="image-view" class="img" width="100" v-bind:src="slider.image ? '/uploads/sliders/' + slider.image : ''"/>
                             </p>
                             <label class="btn btn-primary btn-file">
                                 <i class="fa fa-file-image-o" aria-hidden="true"></i>  Картина
                                 <input  type="file" accept="image/*"  @change="setImage($event)"/>
                             </label>
                             <span v-if="IsError('slider.image')" class="help-block" v-for="e in IsError('slider.image')">
                                   {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.sort')}">
                             <label>Сортировка <span class="red">*</span></label>
                             <input v-model="slider.sort" type="number" class="form-control">
                             <span v-if="IsError('slider.sort')" class="help-block" v-for="e in IsError('slider.sort')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.show_where')}">
                             <label>Где отображать</label>
                             <select v-model="slider.show_where" class="form-control">
                                 <option value="home_page">На главную страницу</option>
                             </select>
                             <span v-if="IsError('slider.show_where')" class="help-block" v-for="e in IsError('slider.show_where')">
                                  {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('slider.active')}">
                             <label>Статус</label>
                             <select v-model="slider.active" class="form-control">
                                 <option value="1">Активный</option>
                                 <option value="0">Неактивный</option>
                             </select>
                             <span v-if="IsError('slider.active')" class="help-block" v-for="e in IsError('slider.active')">
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

                             <router-link :to="{path: '/sliders'}" class="btn btn-default">
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
                slider:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    link: '',
                    image: '',
                    sort: 0,
                    show_where: 'home_page',
                    active: 0
                }
            }
        },
        created(){
            if(this.slider.id > 0)
            {
                axios.get('/admin/slider-view/' + this.slider.id).then((res)=>{
                    var data = res.data;

                    this.slider.id         = data.id;
                    this.slider.name       = data.name;
                    this.slider.link       = data.link;
                    this.slider.image      = data.image;
                    this.slider.sort       = data.sort;
                    this.slider.show_where = data.show_where;
                    this.slider.active     = data.active;
                });
            }
        },
        methods:{
            setImage(event){
                this.slider.image = event.target.files[0];
                this.$helper.setImgSrc(event.target.files[0], '#image-view');
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            sliderSave(event){
                event.preventDefault();
                this.SetErrors(null);

                var data = this.$helper.formData(this.slider, 'slider');

                axios.post('/admin/slider-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.slider.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.slider.id)
                            {
                                this.slider.id = res.data;
                                this.$router.push('/sliders/edit/' + this.slider.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/sliders/create';

                            this.slider = {
                                id:  0,
                                name: '',
                                link: '',
                                image: '',
                                sort: 0,
                                show_where: 'home_page',
                                active: 1
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