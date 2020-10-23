<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="categorySave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ category.id ? 'Редактировать' : 'Создать категорию'}}</h3>
                     </div>
                     <div class="box-body row">

                         <div class="tab-container col-md-12">
                             <div class="nav-tabs-custom" id="form_tabs">
                                 <ul class="nav nav-tabs">
                                     <li v-bind:class="{'active' : tab_active == 'tab_main'}" @click="setTab('tab_main')">
                                         <a>Главная</a>
                                     </li>
                                     <li v-bind:class="{'active' : tab_active == 'tab_parent'}" @click="setTab('tab_parent')">
                                         <a>Родительская категория</a>
                                     </li>
                                     <li v-bind:class="{'active' : tab_active == 'tab_desc'}" @click="setTab('tab_desc')">
                                         <a>Описание</a>
                                     </li>
                                     <li v-bind:class="{'active' : tab_active == 'tab_seo'}" @click="setTab('tab_seo')">
                                         <a>SEO</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>

                         <div class="tab-content col-md-12">


                             <div v-bind:class="{'active' : tab_active == 'tab_main'}" role="tabpanel" class="tab-pane" id="tab_main">
                                 <table class="table table-bordered ">
                                     <tbody>
                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Название <span class="red">*</span></label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.name')}">
                                                     <input v-model="category.name" type="text" class="form-control">
                                                     <span v-if="IsError('category.name')" class="help-block" v-for="e in IsError('category.name')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Короткое название <span class="red">*</span></label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.name_short')}">
                                                     <input v-model="category.name_short" type="text" class="form-control">
                                                     <span v-if="IsError('category.name_short')" class="help-block" v-for="e in IsError('category.name_short')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Url</label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.url')}">
                                                     <input v-model="category.url" type="text" class="form-control">
                                                     <span v-if="IsError('category.url')" class="help-block" v-for="e in IsError('category.url')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>url_full</label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.url_full')}">
                                                     <input v-model="category.url_full" type="text" class="form-control">
                                                     <span v-if="IsError('category.url_full')" class="help-block" v-for="e in IsError('category.url_full')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Сортировка <span class="red">*</span></label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.sort')}">
                                                     <input v-model="category.sort" type="number" class="form-control">
                                                     <span v-if="IsError('category.sort')" class="help-block" v-for="e in IsError('category.sort')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Фото <span class="red" v-if="!category.id">*</span></label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.image')}">
                                                     <p v-if="category.path_image">
                                                         <img v-bind:src="category.path_image" class="img" id="image-img" width="100"/>
                                                     </p>
                                                     <label class="btn btn-primary btn-file">
                                                         <i class="fa fa-file-image-o" aria-hidden="true"></i>  Фото товара
                                                         <input type="file" accept="image/*"  @change="setImage($event)"/>
                                                     </label>
                                                     <span v-if="IsError('category.image')" class="help-block" v-for="e in IsError('category.image')">
                                                           {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>
                                                     Статус:
                                                 </label>
                                             </td>
                                             <td width="75%">
                                                 <div class="col-md-4" v-bind:class="{'has-error' : IsError('category.active')}">
                                                     <select v-model="category.active" class="form-control">
                                                         <option value="1">Активный</option>
                                                         <option value="0">Неактивный</option>
                                                     </select>
                                                     <span v-if="IsError('category.active')" class="help-block" v-for="e in IsError('category.active')">
                                                         {{ e }}
                                                    </span>
                                                 </div>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>


                             <div v-bind:class="{'active' : tab_active == 'tab_parent'}" role="tabpanel" class="tab-pane" id="tab_parent">
                                 <table class="table table-bordered ">
                                     <tbody>
                                         <tr>
                                             <td width="100%" colspan="2">
                                                 <Categories v-model="category.parent_id" :returnKey="'id'" :multiple="false"></Categories>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>


                             <div v-bind:class="{'active' : tab_active == 'tab_desc'}" role="tabpanel" class="tab-pane" id="tab_desc">
                                 <table class="table table-bordered ">
                                     <tbody>
                                         <tr>
                                             <td width="100%" colspan="2">
                                                 <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('category.description')}">
                                                     <Ckeditor v-model="category.description" :uploadFilePath="uploadFilePath"></Ckeditor>

                                                     <span v-if="IsError('category.description')" class="help-block" v-for="e in IsError('category.description')">
                                                        {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>





                             <div v-bind:class="{'active' : tab_active == 'tab_seo'}" role="tabpanel" class="tab-pane" id="tab_seo">
                                 <table class="table table-bordered ">
                                     <tbody>
                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Заголовок</label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.seo_title')}">
                                                     <textarea rows="5" v-model="category.seo_title" class="form-control"></textarea>
                                                     <span v-if="IsError('category.seo_title')" class="help-block" v-for="e in IsError('category.seo_title')">
                                                             {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Keywords</label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.seo_keywords')}">
                                                     <textarea rows="5" v-model="category.seo_keywords" class="form-control"></textarea>
                                                     <span v-if="IsError('category.seo_keywords')" class="help-block" v-for="e in IsError('category.seo_keywords')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td width="25%" class="text-right">
                                                 <label>Description</label>
                                             </td>
                                             <td width="75%">
                                                 <div class="form-group col-md-8" v-bind:class="{'has-error' : IsError('category.seo_description')}">
                                                     <textarea rows="5" v-model="category.seo_description" class="form-control"></textarea>
                                                     <span v-if="IsError('category.seo_description')" class="help-block" v-for="e in IsError('category.seo_description')">
                                                         {{ e }}
                                                     </span>
                                                 </div>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
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
                                     <li>
                                         <a @click="setMethodRedirect('save_and_new')">
                                             <button type="submit" class="btn-transparent">Сохранить и новый</button>
                                         </a>
                                     </li>
                                 </ul>

                             </div>

                             <router-link :to="{ name: 'categories' }" class="btn btn-default">
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
    import Categories from '../plugins/Categories';

    export default {
        components:{
            Ckeditor,
            Categories
        },
        data () {
            return {
                method_redirect: 'save_and_back',
                category:{
                    id: this.$route.params.category_id ? this.$route.params.category_id : 0,
                    parent_id: 0,
                    name: '',
                    name_short: '',
                    url: '',
                    url_full: '',
                    sort: 0,
                    image: '',
                    path_image: '',
                    type: '',
                    description: '',
                    seo_title: '',
                    seo_keywords: '',
                    seo_description: '',
                    active: 1,
                },
                tab_active: 'tab_main',
            }
        },
        created(){
            if(this.category.id > 0)
            {
                axios.get('/admin/category-view/' + this.category.id).then((res)=>{
                    var res = res.data;
                    console.log(res);

                    this.category.parent_id = res.parent_id;
                    this.category.name = res.name;
                    this.category.name_short = res.name_short;
                    this.category.url = res.url;
                    this.category.url_full = res.url_full;
                    this.category.sort = res.sort;
                    this.category.image = res.image;
                    this.category.type = res.type;
                    this.category.description = res.description;
                    this.category.seo_title = res.seo_title;
                    this.category.seo_keywords = res.seo_keywords;
                    this.category.seo_description = res.seo_description;
                    this.category.active = res.active;
                    this.category.path_image = res.path_image;
                });
            }
        },
        methods:{


            setTab(tab){
                this.tab_active = tab;
            },
            setImage(event){
                this.$helper.setImgSrc(event.target.files[0], '#image-img');
                this.category.image = event.target.files[0];
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            categorySave(event){
                event.preventDefault();
                this.SetErrors(null);

                var data = new FormData();
                var self = this;
                $.each(this.category, function(column, value) {
                   data.append('category[' + column + ']', self.$helper.isNullClear(value));
                });

                axios.post('/admin/category-save', data).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.category.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.category.id)
                            {
                                this.category.id = res.data;
                                this.$router.push({
                                        name: 'category_edit',
                                        params: {
                                            category_id: this.category.id
                                        }
                                    });
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            this.$router.go({
                                name: 'category_create'
                            });
                        }

                    }
                });

            },
            ...mapActions(['SetErrors'])
        },
        computed:{
            ...mapGetters([
                'IsError'
            ]),
            uploadFilePath(){
                if(this.category.id)
                    return 'uploads/categories/' + this.category.id + '/';
                else
                    return '';
            }
        }
    }
</script>

<style scoped>
    table thead, table tfoot {
        background-color: #f6f6f6;
    }
</style>
