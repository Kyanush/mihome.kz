<template>
    <div class="col-md-8 col-md-offset-2">
        <!-- Default box -->

        <history_back></history_back>

        <form v-on:submit="attributeSave">
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Добавить новый атрибут</h3>
                </div>
                <div class="box-body row">

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.name')}">
                        <label>Название <span class="red">*</span></label>
                        <input type="text" name="text" value="" class="form-control" v-model="attribute.name"/>
                        <span v-if="IsError('attribute.name')" class="help-block" v-for="e in IsError('attribute.name')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.code')}">
                        <label>Код</label>
                        <input type="text" name="text" value="" class="form-control" v-model="attribute.code"/>
                        <span v-if="IsError('attribute.code')" class="help-block" v-for="e in IsError('attribute.code')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.required')}">
                        <label>Обязательные поля <span class="red">*</span></label>
                        <select class="form-control" v-model="attribute.required">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                        <span v-if="IsError('attribute.required')" class="help-block" v-for="e in IsError('attribute.required')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.use_in_filter')}">
                        <label>Показывать в фильтре <span class="red">*</span></label>
                        <select class="form-control" v-model="attribute.use_in_filter" v-bind:disabled="attribute.type != 'dropdown' && attribute.type != 'multiple_select'  && attribute.type != 'color'">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                        <span v-if="IsError('attribute.use_in_filter')" class="help-block" v-for="e in IsError('attribute.use_in_filter')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.type')}">
                        <label>Тип <span class="red">*</span></label>
                        <select name="type" id="attribute_type" class="form-control" v-model="attribute.type" v-on:change="selectedAttributeType" v-bind:disabled="attribute.id > 0">
                            <option v-for="type in types" v-bind:value="type.value">
                                {{ type.name }}
                            </option>
                        </select>
                        <span v-if="IsError('attribute.type')" class="help-block" v-for="e in IsError('attribute.type')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.description')}">
                        <label>Описание</label>
                        <textarea class="form-control" v-model="attribute.description"></textarea>
                        <span v-if="IsError('attribute.description')" class="help-block" v-for="e in IsError('attribute.description')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attribute.attribute_group_id')}">
                        <label>Группа</label>
                        <Select2 class="standard-input" v-model="attribute.attribute_group_id" :options="convertDataSelect2(attribute_groups, false, false, false, true)"/>
                        <span v-if="IsError('attribute.attribute_group_id')" class="help-block" v-for="e in IsError('attribute.attribute_group_id')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group col-md-12 attr-field attr-type-media image" v-if="attribute.type == 'media'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <div>
                            <label>Картина по умолчанию</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6" style="margin-bottom: 20px;">
                                <img width="100"  class="img" id="mainImage" src="" v-bind:src="attribute.values[0].value ? '/uploads/attributes/' + attribute.values[0].value : ''">
                            </div>
                        </div>
                        <div class="btn-group">
                            <label class="btn btn-primary btn-file">
                                Загрузить
                                <input type="file" accept="image/*" id="uploadImage" class="hide" @change="setFile($event)"/>
                            </label>
                            <button class="btn btn-danger" id="remove" type="button" @click="clearImage">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="btn-group">
                            <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                                    {{ e }}
                            </span>
                        </div>
                    </div>


                    <div class="form-group attr-field attr-type-text col-md-12" v-if="attribute.type == 'text'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Текст по умолчанию</label>
                        <input type="text" name="text" class="form-control" v-model="attribute.values[0].value">
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-textarea col-md-12" v-if="attribute.type == 'textarea'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Текстовая область по умолчанию</label>
                        <textarea name="textarea" class="form-control" v-model="attribute.values[0].value"></textarea>
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-date col-md-12" v-if="attribute.type == 'date'" v-bind:class="{'has-error' : IsError('attribute.values.0.value')}">
                        <label>Дата по умолчанию</label>
                        <input type="date" name="date" class="form-control" v-model="attribute.values[0].value">
                        <span v-if="IsError('attribute.values.0.value')" class="help-block" v-for="e in IsError('attribute.values.0.value')">
                            {{ e }}
                        </span>
                    </div>

                    <div class="form-group attr-field attr-type-dropdown col-md-12" v-if="attribute.type == 'multiple_select' || attribute.type == 'dropdown' || attribute.type == 'color'">


                        <div class="table-responsive1">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="2">

                                            <button class="btn btn-primary" @click="addOption" type="button">
                                                <i class="fa fa-plus"></i>
                                                Создать вариант
                                            </button>

                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="30"><b>№</b></td>
                                        <td><b>Значение</b></td>
                                        <td><b>Код</b></td>
                                        <td><b>Свойство</b></td>
                                        <td width="30"><b>Удалить</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in attribute.values">
                                        <td>
                                            #{{ index + 1}}
                                        </td>
                                        <td>
                                            <input  type="text" v-model="attribute.values[index].value" class="form-control" v-bind:disabled="item.is_delete == 1" placeholder="Значение">
                                        </td>
                                        <td>
                                            <input  type="text" v-model="attribute.values[index].code"  class="form-control" v-bind:disabled="item.is_delete == 1" placeholder="Код">
                                        </td>
                                        <td>

                                            <div class="input-group" v-if="attribute.type == 'color'">
                                                <input v-model="attribute.values[index].props"
                                                       type="text"
                                                       placeholder="#f6f6f6"
                                                       class="form-control">
                                                <div class="input-group-addon">
                                                    <swatches
                                                            :trigger-style="{ width: '18px', height: '18px' }"
                                                            v-model="attribute.values[index].props"
                                                            colors="text-advanced"
                                                            popover-to="left"></swatches>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="text-center">
                                            <a title="Удалить" class="btn btn-xs btn-default red" @click="deleteOption(index)">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                            <span v-if="IsError('attribute.values.' + index + '.value')" class="help-block required" v-for="e in IsError('attribute.values.' + index + '.value')">
                                                    {{ e }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td width="30"><b>№</b></td>
                                        <td><b>Значение</b></td>
                                        <td><b>Код</b></td>
                                        <td><b>Свойство</b></td>
                                        <td width="30"><b>Удалить</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>





                    </div>














                </div><!-- /.box-body -->
                <div class="box-footer">

                    <div id="saveActions" class="form-group">

                        <input type="hidden" name="save_action" value="save_and_back">

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

                        <router-link :to="{path: '/attributes'}" class="btn btn-default">
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
    import Select2 from 'v-select2-component';

    //https://saintplay.github.io/vue-swatches/#sub-material-colors
    import Swatches from 'vue-swatches'
    // Import the styles too, globally
    import "vue-swatches/dist/vue-swatches.min.css"



    export default {
        components:{
            Select2, Swatches
        },
        data () {
            return {
                method_redirect: 'save_and_back',
                attribute_groups: [],
                attribute: {
                    id: 0,
                    name: '',
                    type: '',
                    required: 0,
                    code: '',
                    use_in_filter: 0,
                    description: '',
                    attribute_group_id: 0,
                    values: [{
                        id: 0,
                        value: '',
                        code: '',
                        props: '',
                        is_delete: 0
                    }]
                },
                types:[
                    {
                        value: '',
                        name: ''
                    },
                    {
                        value: 'text',
                        name: 'Текст - Text'
                    },
                    {
                        value: 'textarea',
                        name: 'Текстовая область - Text Area'
                    },
                    {
                        value: 'date',
                        name: 'Дата - Date'
                    },
                    {
                        value: 'multiple_select',
                        name: 'Множественный выбор - Multiple Select'
                    },
                    {
                        value: 'dropdown',
                        name: 'Выбор - Dropdown'
                    },
                    {
                        value: 'media',
                        name: 'Картинка - Image'
                    },
                    {
                        value: 'color',
                        name: 'Цвет товара - Color'
                    }
                ]
            }
        },
        created(){
            if(this.$route.params.id > 0)
            {
                axios.get('/admin/attribute-view/' + this.$route.params.id).then((res)=>{
                    this.attribute = res.data;

                    if(!this.attribute.attribute_group_id)
                        this.attribute.attribute_group_id = 0;
                });
            }

            axios.get('/admin/attribute-groups-list').then((res)=>{
                this.attribute_groups = res.data;
            });

        },
        watch: {
            'attribute.type': {
                handler: function (val, oldVal) {
                    if(val != 'dropdown' && val != 'multiple_select')
                        this.attribute.use_in_filter = 0;
                },
                deep: true
            },
        },
        methods:{
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option);
            },
            setFile(event){
                this.$set(this.attribute.values[0],'value', event.target.files[0]);
                this.$helper.setImgSrc(event.target.files[0], '#mainImage');
            },
            selectedAttributeType(){
                if(this.attribute.type != 'multiple_select' && this.attribute.type != 'dropdown')
                    this.attribute.values = [{
                        id: 0,
                        value: '',
                        code: '',
                        props: '',
                        is_delete: 0
                    }];

                this.viewImageClear();
            },
            clearImage(){
                if(this.attribute.id){
                    this.attribute.values[0].value = '';
                }else{
                    this.attribute.values = [{
                        id: 0,
                        value: '',
                        code: '',
                        props: '',
                        is_delete: 0
                    }];
                }
                this.viewImageClear();
            },
            viewImageClear(){
                $('#mainImage').attr('src', null);
                $('#uploadImage').val(null);
            },
            addOption(){
                this.attribute.values.push({
                    id: 0,
                    value: '',
                    code: '',
                    props: '',
                    is_delete: false
                });
            },
            deleteOption(index){
                    if(this.attribute.values[index].id){
                        this.$set(this.attribute.values[index], 'is_delete', this.attribute.values[index].is_delete ? 0 : 1);
                    }else
                        this.$delete(this.attribute.values, index);
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            attributeSave(event){
                event.preventDefault();
                this.SetErrors(null);

                var form_data = new FormData();

                form_data.append('attribute[id]',            this.attribute.id);
                form_data.append('attribute[name]',          this.attribute.name);
                form_data.append('attribute[type]',          this.attribute.type);
                form_data.append('attribute[required]',      this.attribute.required);
                form_data.append('attribute[code]',          this.attribute.code);
                form_data.append('attribute[use_in_filter]', this.attribute.use_in_filter);
                form_data.append('attribute[description]',   this.attribute.description);
                form_data.append('attribute[attribute_group_id]',   this.attribute.attribute_group_id);



                this.attribute.values.forEach(function (value, i) {
                    form_data.append('attribute[values]['+i+'][id]',        value.id);
                    form_data.append('attribute[values]['+i+'][value]',     value.value);
                    form_data.append('attribute[values]['+i+'][code]',      value.code);
                    form_data.append('attribute[values]['+i+'][props]',     value.props);
                    form_data.append('attribute[values]['+i+'][is_delete]', value.is_delete);
                });

                axios.post('/admin/attribute-save', form_data).then((res)=>{
                    if(res.data)
                    {

                        this.$helper.swalSuccess(this.attribute.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.attribute.id)
                            {
                                this.attribute.id = res.data;
                                this.$router.push('/attributes/edit/' + this.attribute.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/attributes/create';

                            this.attribute = {
                                id: 0,
                                    name: '',
                                    type: '',
                                    required: 0,
                                    code: '',
                                    use_in_filter: 0,
                                    description: '',
                                    attribute_group_id: 0,
                                    values: [{
                                        id: 0,
                                        value: '',
                                        code: '',
                                        props: '',
                                        is_delete: 0
                                    }]
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

<style scoped>
    #add_option, .remove-option{
        cursor: pointer;
    }
    img {
        max-width: 100%;
    }
</style>