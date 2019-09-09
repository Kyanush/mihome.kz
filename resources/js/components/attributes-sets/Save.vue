<template>
         <div class="col-md-8 col-md-offset-2">

             <history_back></history_back>

             <form v-on:submit="attributeSetSave">
                 <div class="box">
                     <div class="box-header with-border">
                         <h3 class="box-title">{{ attribute_set.id ? 'Редактировать' : 'Создать категорию'}}</h3>
                     </div>
                     <div class="box-body row">
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('attribute_set.name')}">
                             <label>Название <span class="red">*</span></label>
                             <input v-model="attribute_set.name" type="text" class="form-control">
                             <span v-if="IsError('attribute_set.name')" class="help-block" v-for="e in IsError('attribute_set.name')">
                                 {{ e }}
                             </span>
                         </div>
                         <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('attribute_set.attributes')}">
                             <label>Атрибуты <span class="red">*</span></label>

                             <Select2 v-model="attribute_set.attributes"
                                      :settings="{ multiple: true }"
                                      :options="list_attributes"/>

                             <span v-if="IsError('attribute_set.attributes')" class="help-block" v-for="e in IsError('attribute_set.attributes')">
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

                             <router-link :to="{path: '/attributes-sets'}" class="btn btn-default">
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

    //https://select2.org/configuration/options-api
    import Select2 from 'v-select2-component';

    export default {
        components:{
            Select2
        },
        data () {
            return {
                method_redirect: 'save_and_back',
                attribute_set:{
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    attributes: ''
                },
                list_attributes: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){


            axios.get('/admin/attributes-list').then((res)=>{
                var self = this;
                res.data.data.forEach(function (item, index) {
                    self.list_attributes.push({
                        id: item.id,
                        text: item.name
                    });
                });
            });


            if(this.attribute_set.id > 0)
            {
                axios.get('/admin/attribute-set-view/' + this.attribute_set.id).then((res)=>{
                    console.log(res.data);
                    this.attribute_set = res.data;
                });
            }
        },
        methods:{
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            attributeSetSave(event){
                event.preventDefault();
                this.SetErrors(null);


                var data = this.$helper.formData(this.attribute_set, 'attribute_set');

                axios.post('/admin/attribute-set-save', data).then((res)=>{

                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.attribute_set.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.attribute_set.id)
                            {
                                this.attribute_set.id = res.data;
                                this.$router.push('/attributes-sets/edit/' + this.attribute_set.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/attributes-sets/create';

                            this.attribute_set.id = 0;
                            this.attribute_set.name = '';
                            this.attribute_set.attributes = []

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
