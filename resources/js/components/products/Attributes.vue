<template>
    <div class="row">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li v-bind:class="{'active' : attr_tab_active == 'attr_tab_main'}" @click="attr_tab_active = 'attr_tab_main'">
                        <a>
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Главный
                        </a>
                    </li>
                    <li v-bind:class="{'active' : attr_tab_active == 'attr_tab_more'}" @click="attr_tab_active = 'attr_tab_more'">
                        <a>
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                            Дополнительные
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content col-md-12">
                <div v-bind:class="{'active' : attr_tab_active == 'attr_tab_main'}" role="tabpanel" class="tab-pane" id="attr_tab_main">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td width="25%"><b>Название</b></td>
                            <td width="60%"><b>Значение</b></td>
                            <td width="15%"><b>Действия</b></td>
                        </tr>
                        </thead>
                        <tbody v-for="(item, index) in attributes" v-if="item.attribute_id != 1">
                        <tr v-for="attribute in attributes_list" v-if="item.attribute_id == attribute.id">
                            <td width="25%" class="text-right">
                                <label>
                                    <span class="red" v-if="attribute.required == 1">*</span>
                                    {{ attribute.name }}:
                                </label>
                            </td>
                            <td width="60%">

                                <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('attributes.' + index + '.value')}">

                                    <span v-if="attribute.type == 'text'">
                                        <p class="help-block">Текст</p>

                                        <input type="text" v-model="item.value" class="form-control">
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>

                                    <span v-if="attribute.type == 'textarea'">
                                        <p class="help-block">Текстовая область</p>
                                        <textarea v-model="item.value" class="form-control"></textarea>
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>

                                    <span v-if="attribute.type == 'date'">
                                        <p class="help-block">Дата</p>
                                        <input type="date" v-model="item.value" class="form-control"/>
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>

                                    <span v-if="attribute.type == 'multiple_select'">
                                        <p class="help-block">Множественный выбор</p>
                                        <Select2 v-model="item.value" :settings="{ multiple: true }" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>



                                    <span v-if="attribute.type == 'dropdown'">
                                        <p class="help-block">Выбор</p>
                                        <Select2 v-model="item.value" :options="convertDataSelect2(attribute.values, 'value', 'value')"/>
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>

                                    <span v-if="attribute.type == 'color'">
                                        <p class="help-block">Цвет</p>
                                        <SelectColor
                                                :colorOptions="convertColorOptions(attribute.values)"
                                                v-model="item.value"></SelectColor>
                                        <span v-if="IsError('attributes.' + index + '.value')" class="help-block" v-for="e in IsError('attributes.' + index + '.value')">
                                             {{ e }}
                                        </span>
                                    </span>
                                </div>
                            </td>
                            <td width="15%">

                                <router-link :title="'Изменить ' + attribute.name"  target="_blank" :to="{ name: 'attribute_edit', params:{ attribute_id: attribute.id }}" class="btn btn-xs btn-default">
                                    <i class="fa fa-edit"></i>
                                </router-link>

                                <button type="button" class="btn btn-xs btn-default" title="Удалить" @click="deleteAttribute(item, index)">
                                    <i class="fa fa-remove red"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td width="25%">
                            </td>
                            <td width="60%">
                                <Select2 v-model="select_attribute_id" :options="convertDataSelect2(attributes_list, 'id', 'name')"/>
                            </td>
                            <td width="15%">

                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div v-bind:class="{'active' : attr_tab_active == 'attr_tab_more'}" role="tabpanel" class="tab-pane" id="attr_tab_more">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <td><b>Название</b></td>
                            <td><b>Значение</b></td>
                            <td><b>Действия</b></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in attributes" v-if="item.attribute_id == 1">
                            <td>
                                <input v-model="item.name" class="form-control"/>
                            </td>
                            <td>
                                <input v-model="item.value" class="form-control"/>
                            </td>
                            <td>
                                <a title="Удалить" class="btn btn-xs btn-default red" @click="deleteAttribute(item, index)">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info float-right" @click="addMore">
                                    <i role="presentation" aria-hidden="true" class="fa fa-plus-square"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-success" @click="save">
                    <i role="presentation" aria-hidden="true" class="fa fa-save"></i>
                    Сохранить
                </button>

            </div>

        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Select2 from 'v-select2-component';
    import SelectColor from '../plugins/SelectColor';

    export default {
        components:{
            Select2,
            SelectColor
        },
        props:['product_id'],
        data () {
            return {
                attributes_list: [],
                attributes: [],
                select_attribute_id: 0,
                attr_tab_active: 'attr_tab_main',
            }
        },
        watch: {
            select_attribute_id:{
                handler: function (val, oldVal) {
                    var self = this;
                    var add = true;

                    this.attributes.forEach(function (item) {
                        if(item.attribute_id == self.select_attribute_id)
                        {
                            add = false;
                        }
                    });

                    if(add)
                    {
                        this.attributes.push({
                            attribute_id: this.select_attribute_id,
                            value: []
                        });
                    }else{
                        alert('Уже есть!');
                    }
                },
                deep: true
            }
        },
        methods:{
            addMore(){
                this.attributes.push({
                    attribute_id: 1,
                    name:         '',
                    value:        ''
                });
            },
            save(){
                axios.post('/admin/product-attribute/save', {
                    product_id: this.product_id,
                    data:       this.attributes
                }).then((res)=> {
                    if(res.data){
                        this.$helper.swalSuccess('Успешно сохранено');
                        this.getAttributes();
                    }else
                        alert('Error');
                });
            },
            deleteAttribute(item, index){
                this.$delete(this.attributes, index);
            },
            attributesList(){
                var params = {};
                params['per_page'] = 1000;
                axios.get('/admin/attributes-list', {params:  params}).then((res)=>{

                    this.attributes_list = res.data.data;
                });
            },
            convertDataSelect2(values, column_id, column_text){
                return this.$helper.convertDataSelect2(values, column_id, column_text);
            },
            convertColorOptions(values){
                var data = [];
                if(values)
                    values.forEach(function (item, index) {
                        data.push({
                            id:   item.value,
                            hex:  item.props,
                            name: item.value
                        });
                    });
                return data;
            },
            getAttributes(){
                axios.post('/admin/product-attribute/get/' + this.product_id).then((res)=>{
                    this.attributes = res.data;
                });
            }
        },
        created(){
            this.attributesList();
            this.getAttributes();
        },
        computed:{
            ...mapGetters([
                'IsError'
            ]),
        }
    }
</script>