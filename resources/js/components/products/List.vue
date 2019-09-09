<template>
    <div class="box">

        <div class="box-header with-border">
            <router-link :to="{ path: '/product/create'}" class="btn btn-primary ladda-button">
                <span class="ladda-label">
                    <i class="fa fa-plus"></i> Добавить товар
                </span>
            </router-link>

            <button type="button" class="btn btn-danger pull-right" @click="clearFilters">
                <i class="fa fa-times" aria-hidden="true"></i>
                Очистить
            </button>

            <div class="btn btn-primary pull-right" @click="showReport" style="margin-right: 5px;">
                <i class="fa fa-print" aria-hidden="true"></i>
                Отчеты
            </div>

        </div>

        <div class="box-header with-border">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Фильтр</b>

                    <i @click="setProductShowFilter"
                       class="fa pull-right cursor"
                       aria-hidden="true"
                       v-bind:title="product_show_filter ? 'Скрыть фильтр' : 'Показать фильтр'"
                       v-bind:class="{'fa-eye green': !product_show_filter,  'fa-eye-slash red': product_show_filter}"></i>

                </div>
                <div class="panel-body" v-show="product_show_filter">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive1">
                                <table class="table table-bordered ">
                                <tbody class="filter">
                                <tr class="odd even">
                                    <td><b>Название товара:</b></td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="Название товара" v-model="filter.name">
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td><b>Ссылка товара:</b></td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="Ссылка товара" v-model="filter.url">
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td><b>Статус:</b></td>
                                    <td>
                                        <select class="form-control" v-model="filter.active">
                                            <option value="">Все</option>
                                            <option value="0">Неактивный</option>
                                            <option value="1">Активный</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="odd even">
                                    <td><b>Цена:</b></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input min="10000" v-bind:min="products_price.min" type="number" class="form-control" v-bind:placeholder="products_price.min" v-model="filter.price_start">
                                            </div>
                                            <div class="col-md-6">
                                                <input min="10000" v-bind:max="products_price.max" step="10000" type="number" class="form-control" v-bind:placeholder="products_price.max" v-model="filter.price_end">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td><b>SKU:</b></td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="SKU" v-model="filter.sku">
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td><b>Количество на складе:</b></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" placeholder="Min" v-model="filter.stock_start">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" placeholder="Max" v-model="filter.stock_end">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="odd even">
                                    <td><b>Дата создания:</b></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <date-picker :config="datetimepicker" v-model="filter.created_at_start"></date-picker>
                                            </div>
                                            <div class="col-md-6">
                                                <date-picker :config="datetimepicker" v-model="filter.created_at_end"></date-picker>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="scroll-catalog">
                                <Categories v-model="filter.category" :returnKey="'url'" :multiple="false"></Categories>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="panel panel-default" id="products-attributes-filters">
                <div class="panel-heading">
                    <b>Свойства товара</b>

                    <i @click="setProductSttributeShowFilter"
                       class="fa pull-right cursor"
                       aria-hidden="true"
                       v-bind:title="product_attribute_show_filter ? 'Скрыть фильтр' : 'Показать фильтр'"
                       v-bind:class="{'fa-eye green': !product_attribute_show_filter,  'fa-eye-slash red': product_attribute_show_filter}"></i>
                </div>
                <div class="panel-body" v-show="product_attribute_show_filter">
                    <div class="table-responsive1">
                        <table class="table table-bordered ">
                        <tbody class="filter">
                        <tr class="odd even" v-for="item in products_attributes_filters">
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-2">
                                        <b>{{ item.name }}</b>
                                    </div>
                                    <div class="col-md-10">
                                        <ul>
                                            <li v-for="value in item.values">
                                                <label v-bind:for="'value' + value.id">
                                                    <input v-bind:id="'value' + value.id"
                                                           type="checkbox"
                                                           v-bind:checked="filter[ item.code ] == value.code"
                                                           v-model="filter[ item.code ]"
                                                           v-bind:value="value.code"/>
                                                    {{ value.value }}
                                                </label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>





        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sort" id="products-list">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" v-model="selected.all"/>
                        </th>
                        <th>
                            ID
                            <SortTable v-model="filter.sort" :column="'id'"></SortTable>
                        </th>
                        <th width="200">
                            Название
                            <SortTable v-model="filter.sort" :column="'name'"></SortTable>
                        </th>
                        <th>Фото товара</th>
                        <th>Категории</th>
                        <th>SKU</th>
                        <th>
                            Цена
                            <SortTable v-model="filter.sort" :column="'price'"></SortTable>
                        </th>
                        <th width="100">Кол-во на<br/> складе
                            <SortTable v-model="filter.sort" :column="'stock'"></SortTable>
                        </th>
                        <th width="110">Кол-во <br/>просмотров
                            <SortTable v-model="filter.sort" :column="'view_count'"></SortTable>
                        </th>
                        <th>
                            Дата создания<br/>Дата изменения
                            <SortTable v-model="filter.sort" :column="'created_at'"></SortTable>
                        </th>
                        <th width="100">
                            Статус
                            <SortTable v-model="filter.sort" :column="'active'"></SortTable>
                        </th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd even" v-for="(item, index) in products.data"
                        v-bind:class="{ 'deleted': !item.active || !item.stock }"
                        title="Нажмите дважды чтобы изменить"
                        v-on:dblclick="changeQuicklySelect(item)">

                        <td>
                           <input type="checkbox" v-model="selected.products_ids" :value="item.id" v-if="!selected.all"/>
                        </td>
                        <td>
                            {{ item.id }}
                        </td>
                        <td>
                            <router-link :to="{ path: '/products/edit/' + item.id}">
                                {{ item.name }}
                            </router-link>
                        </td>
                        <td>
                            <img v-bind:src="item.path_photo" width="70" class="img"/>
                        </td>
                        <td>
                            <p v-for="category in item.categories" class="margin-padding-none">
                                {{ category.name }}
                            </p>
                        </td>
                        <td>{{ item.sku }}</td>
                        <td>
                            <span v-if="item.price_discount">
                                 <del> {{ item.format_price }}</del>
                                 <br/>
                                 {{ item.price_discount }}
                            </span>
                            <span v-else>
                                {{ item.format_price }}
                            </span>
                        </td>
                        <td :class="{ 'red': !item.stock }">{{ item.stock }} шт.</td>
                        <td>{{ item.view_count }}</td>
                        <td>
                            {{ dateFormat(item.created_at) }}
                            <br/>
                            {{ dateFormat(item.updated_at) }}
                        </td>
                        <td>
                            <i class="fa fa-times-circle" aria-hidden="true" v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                        </td>
                        <td>
                            <p>
                                <a class="btn btn-xs btn-default" :href="item.detail_url_product" target="_blank" title="Посмотреть товар">
                                    <i class="fa fa-internet-explorer" aria-hidden="true"></i>
                                </a>

                                <router-link :to="{ path: '/products/edit/' + item.id}" class="btn btn-xs btn-default" title="Изменить">
                                    <i class="fa fa-edit"></i> <!--Изменить-->
                                </router-link>
                            </p>
                            <p>
                                <a class="btn btn-xs btn-default" @click="deleteProduct(item, index)" title="Удалить">
                                    <i class="fa fa-remove"></i> <!--Удалить-->
                                </a>
                                <a class="btn btn-xs btn-default clone-btn" @click="cloneShow(item)" title="Создать дубликат">
                                    <i class="fa fa-clone"></i> <!--Создать дубликат-->
                                </a>
                            </p>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <input type="checkbox" v-model="selected.all"/>
                        </th>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Фото товара</th>
                        <th>Категории</th>
                        <th>SKU</th>
                        <th>Цена</th>
                        <th>Количество на<br/> складе</th>
                        <th>Кол-во <br/>просмотров</th>
                        <th>Дата создания<br/>Дата изменения</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                    <tr v-if="selected.products_ids.length > 0 || selected.all">
                        <th><b class="green">{{ selected.all ? 'Все' : selected.products_ids.length }}</b></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <input type="text" class="form-control" v-model="selected.stock" @change="editSelected('stock')"/>
                        </th>
                        <th></th>
                        <th></th>
                        <th>
                            <select class="form-control" v-model="selected.active" @change="editSelected('active')">
                                <option value=""></option>
                                <option value="1">Активный</option>
                                <option value="0">Неактивный</option>
                            </select>
                        </th>
                        <th>
                            <button class="btn btn-danger" @click="editSelected('delete')" title="Удалить всех">
                                <i class="fa fa-remove"></i>
                            </button>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center">
            <p>{{ products.to }} из {{ products.total }}</p>

            <paginate
                    v-if="products.last_page > 1"
                    v-model="products.current_page"
                    :page-count="products.last_page"
                    :click-handler="SetPage"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>





        <div class="clone-product-modal modal fade" id="clone" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-clone"></i> Клонирование товара
                        </h4>
                    </div>
                    <form v-on:submit="cloneProduct">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('clone_product.name')}">
                                    <label>Название <span class="red">*</span></label>
                                    <input type="text" class="form-control" v-model="clone_product.name"/>
                                    <span>Должно быть уникальным</span>
                                    <span v-if="IsError('clone_product.name')" class="help-block" v-for="e in IsError('clone_product.name')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('clone_product.sku')}">
                                    <label>SKU <span class="red">*</span></label>
                                    <input type="text" class="form-control" v-model="clone_product.sku"/>
                                    <span>Должно быть уникальным</span>
                                    <span v-if="IsError('clone_product.sku')" class="help-block" v-for="e in IsError('clone_product.sku')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12"  v-bind:class="{'has-error' : IsError('clone_product.images')}">
                                    <label>Клонировать еще ?</label>

                                    <ul>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.attributes"/>
                                                Атрибуты
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.photo"/>
                                                Фото товара
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.product_images"/>
                                                Картинки
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.specific_price"/>
                                                Скидки
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.group"/>
                                                Группа товаров
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.product_accessories"/>
                                                С этим товаром покупают
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.reviews"/>
                                                Отзывы
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" v-model="clone_product.questions_answers"/>
                                                Вопросы-ответы
                                            </label>
                                        </li>

                                    </ul>
                                    <span v-if="IsError('clone_product.images')" class="help-block" v-for="e in IsError('clone_product.images')">
                                            {{ e }}
                                        </span>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                            <button type="submit" class="btn btn-primary">Создать дубликат</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="changeQuickly" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form v-on:submit="changeQuicklySave">
                        <div class="modal-header">
                            <b class="modal-title" id="exampleModalLabel">
                                №{{ change_quickly.id }} | {{ change_quickly.name }}
                            </b>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered ">
                                <tbody>
                                    <tr>
                                        <td width="25%" class="text-right">
                                            <label for="stock">Количество на складе(шт.):</label>
                                        </td>
                                        <td width="75%">
                                            <div class="col-md-6" v-bind:class="{'has-error' : IsError('change_quickly.stock')}">
                                                <input required id="stock" type="number" v-model="change_quickly.stock" class="form-control"/>
                                                <span v-if="IsError('change_quickly.stock')" class="help-block" v-for="e in IsError('change_quickly.stock')">
                                                     {{ e }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="text-right">
                                            <label>
                                                <span class="red">*</span>
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                                Цена:
                                            </label>
                                        </td>
                                        <td width="75%">
                                            <div class="col-md-6" v-bind:class="{'has-error' : IsError('change_quickly.price')}">
                                                <input required id="price" type="number" v-model="change_quickly.price" class="form-control"/>
                                                <span v-if="IsError('change_quickly.price')" class="help-block" v-for="e in IsError('change_quickly.price')">
                                                     {{ e }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" class="text-right">
                                            <label>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                Статус:
                                            </label>
                                        </td>
                                        <td width="75%">
                                            <div class="col-md-4" v-bind:class="{'has-error' : IsError('change_quickly.active')}">
                                                <select required v-model="change_quickly.active" class="form-control">
                                                    <option value="1">Активный</option>
                                                    <option value="0">Неактивный</option>
                                                </select>
                                                <span v-if="IsError('change_quickly.active')" class="help-block" v-for="e in IsError('change_quickly.active')">
                                                     {{ e }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                Отменить
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Изменить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <report :report_types="report_types" :filter="filter"></report>

    </div>
</template>


<script>
    import Paginate       from 'vuejs-paginate';
    import datePicker     from 'vue-bootstrap-datetimepicker';
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import Categories     from '../plugins/Categories';
    import SortTable      from '../plugins/SortTable';
    import report     from '../plugins/Report';

    export default {
        components:{
            Paginate, datePicker, Categories, SortTable, report
        },
        data () {
            return {
                report_types:[
                    {
                        id: 'yandex-directory',
                        text: 'Яндекс справочник'
                    }
                ],

                product_show_filter: false,
                product_attribute_show_filter: false,

                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                },
                wait: true,

                products_price: [],

                products_attributes_filters: [],

                products: [],
                filter:{
                    page:               this.urlParamsGet('page'),
                    name:               this.urlParamsGet('name'),
                    active:             this.urlParamsGet('active'),
                    url:                this.urlParamsGet('url'),
                    price_start:        this.urlParamsGet('price_start'),
                    price_end:          this.urlParamsGet('price_end'),
                    sku:                this.urlParamsGet('sku'),
                    stock_start:        this.urlParamsGet('stock_start'),
                    stock_end:          this.urlParamsGet('stock_end'),
                    created_at_start:   this.urlParamsGet('created_at_start'),
                    created_at_end:     this.urlParamsGet('created_at_end'),
                    category:           this.urlParamsGet('category'),
                    sort:               this.urlParamsGet('sort')
                },
                clone_product:{
                    product_id: 0,
                    name: '',
                    sku: '',
                    attributes: true,
                    photo: false,
                    product_images: false,
                    specific_price: true,
                    group: true,
                    product_accessories: false,
                    reviews: false,
                    questions_answers: false
                },
                selected: {
                    products_ids: [],
                    stock:  '',
                    active: '',
                    all: false
                },
                change_quickly: {
                    id:     0,
                    name:   '',
                    price:  0,
                    stock:  0,
                    active: 1
                }
            }
        },
        created() {
            var product_show_filter = localStorage.getItem('product_show_filter');
            if(product_show_filter)
                this.product_show_filter = product_show_filter === 'true' ? true : false;

            var product_attribute_show_filter = localStorage.getItem('product_attribute_show_filter');
            if(product_attribute_show_filter)
                this.product_attribute_show_filter = product_attribute_show_filter === 'true' ? true : false;

            axios.post('/admin/products-attributes-filters', this.urlParamsGet()).then((res)=>{
                var data = res.data;
                var self = this;
                Object.keys(data).forEach(function (column) {
                    var code = data[column].code;
                    var value = self.urlParamsGet(code);

                    if(!$.isArray(value)){
                        self.$set(self.filter, code, [value]);
                    }else
                        self.$set(self.filter, code, value);
                });
            });

            setTimeout(function () {
                this.productsList();
            }.bind(this), 500)



        },

        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.productsList();
                },
                deep: true
            }
        },
        methods:{
            showReport(){
                $('#popup-peport').modal('show');
            },
            changeQuicklySelect(product){
                this.change_quickly.id     = product.id;
                this.change_quickly.name   = product.name;
                this.change_quickly.price  = product.price;
                this.change_quickly.stock  = product.stock;
                this.change_quickly.active = product.active;
                $('#changeQuickly').modal('show');
            },
            changeQuicklySave(event){
                event.preventDefault();

                axios.post('/admin/product-change-quickly-save', this.change_quickly).then((res)=>{
                    if(res.data)
                    {
                        this.productsList();
                        $('#changeQuickly').modal('hide');
                    }else
                        alert('Error');
                });
            },
            editSelected(action){
                var title = 'Вы действительно хотите изменить?';

                if(action == 'stock')
                    title = 'Вы действительно хотите изменить количество на складе?';

                if(action == 'active')
                    title = 'Вы действительно хотите изменить статус?';

                if(action == 'delete')
                    title = 'Внимание! Вы действительно хотите УДАЛИТЬ?';

                this.$swal({
                    title: title,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/products-selected-edit', {

                            products_ids: this.selected.products_ids,
                            stock:        this.selected.stock,
                            active:       this.selected.active,
                            action:       action,
                            filter:       this.filter,
                            all:          this.selected.all,

                        }).then((res)=>{
                            if(res.data)
                            {
                                this.productsList();
                                this.selected = {
                                    products_ids: [],
                                    stock:  '',
                                    active: ''
                                };
                            }
                        });
                    }else{
                        this.selected.stock  = '';
                        this.selected.active = '';
                    }
                });
            },
            setProductShowFilter(){
                this.product_show_filter = !this.product_show_filter;
                localStorage.setItem('product_show_filter', this.product_show_filter);
            },
            setProductSttributeShowFilter(){
                this.product_attribute_show_filter = !this.product_attribute_show_filter;
                localStorage.setItem('product_attribute_show_filter', this.product_attribute_show_filter);
            },

            urlParamsGenerate(){

                var params = '';

                var self = this;
                Object.keys(this.filter).forEach(function (column) {
                    if(self.filter[column])
                    {
                        if(column == 'page' && self.filter[column] == 1) return;

                        var value = self.filter[column];

                        if($.isArray(self.filter[column])){
                            value = '';
                            $.each(self.filter[column], function(idx2, val2) {
                                if(val2)
                                    value += val2 + '-or-';
                            });
                            if(value)
                                value = value.slice(0,-4);
                        }

                        if(value)
                            params += column + '-' + value + '/';
                    }
                });

                if(params)
                    params = params.slice(0,-1);

                return params;
            },
            urlParamsGet(key){
                var filters = {};
                var hash = this.$route.hash;
                hash = hash.substring(1);
                hash = hash.split('/');
                for (var i = 0; i < hash.length; i++)
                {
                    var param = hash[i].split('-');
                    var d = hash[i].replace(param[0] + '-','');
                    filters[param[0]] = d.indexOf('-or-') >= 0 ? d.split('-or-') : d;
                }

                return key ? (filters[key] ? filters[key] : '') : filters;
            },
            clearFilters(){
                var self = this;
                Object.keys(this.filter).forEach(function (column) {
                    if($.isArray(self.filter[column])){
                        self.filter[column] = [];
                    }else if(self.filter[column]){
                        self.filter[column] = '';
                    }
                });
                this.$router.push({path: '/products'});
                this.selected = {
                    products_ids: [],
                    stock:  '',
                    active: ''
                };
            },
            dateFormat(date, type_format){
                return this.$helper.dateFormat(date, type_format);
            },
            cloneShow(product){
                this.clone_product.product_id = product.id;
                this.clone_product.name = product.name;
                this.clone_product.sku = product.sku;
                $('#clone').modal('show');
            },
            cloneProduct(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/clone-product', {clone_product : this.clone_product}).then((res)=>{
                    if(res.data)
                    {
                        this.productsList();
                        $('#clone').modal('hide');
                    }
                });
            },
            SetPage(page){
                this.filter.page = page;
            },
            deleteProduct(item, index){
                this.$swal({
                    title: 'Вы действительно хотите удалить' + ' "' + item.name + '"?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/product-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.products.data, index);
                            }
                        });
                    }
                });
            },

            productsList(){
                if(this.wait)
                {
                    this.wait = false;
                    var urlParamsGenerate = this.urlParamsGenerate();
                    this.$router.push({hash: urlParamsGenerate});

                    axios.post('/admin/products-attributes-filters', this.filter).then((res)=>{
                        var data = res.data;
                        this.products_attributes_filters = data;
                    });

                    axios.post('/admin/products-list', this.filter).then((res)=>{
                        this.products = res.data;
                        this.wait = true;
                    });

                    axios.post('/admin/product-price-min-max', this.filter).then((res)=>{
                        this.products_price = res.data;
                    });

                }
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
    #products-attributes-filters ul li{
        float: left;
        margin-right: 15px;
        list-style:none;
    }
    #products-attributes-filters ul li label{
        cursor: pointer;
    }
    #products-list tbody tr:hover{
        background-color: #ecf0f5;
        cursor: pointer;
    }
</style>
