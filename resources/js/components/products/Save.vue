<template>
    <div class="row">
        <div class="col-md-12">

            <history_back></history_back>

            <form v-on:submit="productSave">

                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">Добавить новый товар</h3>
                    </div>
                    <div class="box-body row">

                        <div class="tab-container col-md-12">
                            <div class="nav-tabs-custom" id="form_tabs">
                                <ul class="nav nav-tabs">
                                    <li v-bind:class="{'active' : tab_active == 'tab_general'}" @click="setTab('tab_general')">
                                        <a>
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            Главная
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_category'}" @click="setTab('tab_category')" v-if="!product.parent_id">
                                        <a>
                                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                                            Категория
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_product_description_and_photo'}" @click="setTab('tab_product_description_and_photo')">
                                        <a>
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                            Описание и фото товара
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_attributes'}" @click="setTab('tab_attributes')">
                                        <a>
                                            <i class="fa fa-cogs" aria-hidden="true"></i>
                                            Характеристики
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_pictures'}" @click="setTab('tab_pictures')">
                                        <a>
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                            Картинки
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_specificprice'}" @click="setTab('tab_specificprice')">
                                        <a>
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            Скидки
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_product_groups'}" @click="setTab('tab_product_groups')" v-if="!product.parent_id">
                                        <a>
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            Торговые предложения
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_with_this_product_buy'}" @click="setTab('tab_with_this_product_buy')" v-if="!product.parent_id">
                                        <a>
                                            <i class="fa fa-gift" aria-hidden="true"></i>
                                            Аксессуары
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_seo'}" @click="setTab('tab_seo')">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-internet-explorer"></i>
                                            SEO
                                        </a>
                                    </li>
                                    <li v-bind:class="{'active' : tab_active == 'tab_reviews'}" @click="setTab('tab_reviews')" v-if="!product.parent_id">
                                        <a>
                                            <i class="fa fa-comments" aria-hidden="true"></i>
                                            Отзывы
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content col-md-12">
                            <div v-bind:class="{'active' : tab_active == 'tab_general'}" role="tabpanel" class="tab-pane" id="tab_general">

                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label><span class="red">*</span> Название:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.name')}">
                                                    <input type="text" v-model="product.name" class="form-control">
                                                    <span v-if="IsError('product.name')" class="help-block" v-for="e in IsError('product.name')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>
                                                    <i class="fa fa-link" aria-hidden="true"></i>
                                                    Ссылка:
                                                </label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.url')}">
                                                    <input type="text" v-model="product.url" class="form-control">
                                                    <span v-if="IsError('product.url')" class="help-block" v-for="e in IsError('product.url')">
                                                         {{ e }}
                                                    </span>
                                                    <p class="help-block pull-right">
                                                        Если пустая ссылка, генерируются автоматически
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label for="stock">Количество на складе(шт.):</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.stock')}">
                                                    <input id="stock" type="text" v-model="product.stock" class="form-control"/>
                                                    <span v-if="IsError('product.stock')" class="help-block" v-for="e in IsError('product.stock')">
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
                                                    Цена продажи:
                                                </label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.price')}">
                                                    <input id="price" type="number" v-model="product.price" class="form-control"/>
                                                    <span v-if="IsError('product.price')" class="help-block" v-for="e in IsError('product.price')">
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
                                                <div class="col-md-4" v-bind:class="{'has-error' : IsError('product.active')}">
                                                    <select v-model="product.active" class="form-control">
                                                        <option value="1">Активный</option>
                                                        <option value="0">Неактивный</option>
                                                    </select>
                                                    <span v-if="IsError('product.active')" class="help-block" v-for="e in IsError('product.active')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label for="stock">Количество просмотров:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6">
                                                    <input disabled type="text" v-model="product.view_count" class="form-control"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="!product.parent_id">
                                            <td width="25%" class="text-right">
                                                <label>
                                                    <i class="fa fa-youtube" aria-hidden="true"></i>
                                                    Youtube
                                                    <br/>
                                                    (Формат <a href="http://joxi.ru/EA4LOjjcoo3kYA" target="_blank">http://joxi.ru/EA4LOjjcoo3kYA</a>):
                                                </label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.youtube')}">
                                                    <input type="text" v-model="product.youtube" class="form-control" placeholder="Формат: jmu2zb_cocE"/>
                                                    <span v-if="IsError('product.youtube')" class="help-block" v-for="e in IsError('product.youtube')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Артикул:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.sku')}">
                                                    <input type="text" v-model="product.sku" class="form-control"/>
                                                    <span v-if="IsError('product.sku')" class="help-block" v-for="e in IsError('product.sku')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>



                            </div>


                            <div v-bind:class="{'active' : tab_active == 'tab_category'}" role="tabpanel" class="tab-pane" id="tab_category">
                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <p class="help-block" style="padding-left: 50px;font-weight: bold;color: #da0303;">Вы можете выбрать одну или несколько категорий, где будет отображаться товар</p>
                                            </td>
                                            <td width="75%">
                                                <Categories v-model="categories" :returnKey="'id'" :multiple="true"></Categories>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div v-bind:class="{'active' : tab_active == 'tab_product_description_and_photo'}" role="tabpanel" class="tab-pane" id="tab_product_description_and_photo">

                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label><span class="red" v-if="!product.id">*</span> Фото товара:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.photo')}">

                                                    <table class="table table-bordered ">
                                                        <tbody>
                                                            <tr>
                                                                 <td>
                                                                     <label>
                                                                         <input type="radio" v-model="product_photo_upload_type" value="file"/>
                                                                         Загрузить с компьютера
                                                                     </label>
                                                                 </td>
                                                                 <td>
                                                                     <label>
                                                                         <input type="radio" v-model="product_photo_upload_type" value="url">
                                                                         Вставить путь к файлу
                                                                     </label>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">

                                                                    <label v-if="product_photo_upload_type == 'file'" class="btn btn-primary btn-file">
                                                                        <i class="fa fa-file-image-o" aria-hidden="true"></i> Загрузить
                                                                        <input type="file" accept="image/*"  @change="setProductPhoto($event)"/>
                                                                    </label>

                                                                    <input v-if="product_photo_upload_type == 'url'"
                                                                           placeholder="Пример: https://test.kz/uploads/products/339/xiaomi-mi-9-se-664gb-ocean-blue.jpeg"
                                                                           class="form-control"
                                                                           type="text"
                                                                           v-model="product.photo"/>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <span v-if="IsError('product.photo')" class="help-block" v-for="e in IsError('product.photo')">
                                                         {{ e }}
                                                    </span>
                                                    <p v-if="product.pathPhoto">
                                                        <br/>
                                                        <img v-bind:src="product.pathPhoto" class="img" width="100"/>
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="!product.parent_id">
                                            <td width="25%" class="text-right">
                                                <label><span class="red">*</span> Описание:</label>
                                            </td>
                                            <td width="75%">
                                                <select v-model="product.description_full_screen" class="form-control">
                                                    <option value="1">На весь экран - да</option>
                                                    <option value="0">На весь экран - нет</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr v-if="!product.parent_id">
                                            <td width="100%" colspan="2">
                                                <div class="form-group col-md-12" v-bind:class="{'has-error' : IsError('product.description')}">
                                                    <Ckeditor v-model="product.description" :uploadFilePath="uploadFilePath"></Ckeditor>
                                                    <span v-if="IsError('product.description')" class="help-block" v-for="e in IsError('product.description')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>



                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_attributes'}" role="tabpanel" class="tab-pane" id="tab_attributes">
                                <Attributes v-if="product.id" :product_id="product.id"></Attributes>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_pictures'}" role="tabpanel" class="tab-pane" id="tab_pictures">
                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="100%" colspan="2">
                                                <upload-images v-model="product_images"
                                                               :error_variable="'product_images'"></upload-images>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_specificprice'}" role="tabpanel" class="tab-pane" id="tab_specificprice">


                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Тип скидки:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('specific_price.discount_type')}">
                                                    <select v-model="specific_price.discount_type" class="form-control">
                                                        <option value="sum">Сумма</option>
                                                        <option value="percent">Процент</option>
                                                    </select>
                                                    <span v-if="IsError('specific_price.discount_type')" class="help-block" v-for="e in IsError('specific_price.discount_type')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label for="reduction">Снижение:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('specific_price.reduction')}">
                                                    <input type="number" v-model="specific_price.reduction" id="reduction" class="form-control">
                                                    <span v-if="IsError('specific_price.reduction')" class="help-block" v-for="e in IsError('specific_price.reduction')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Дата начала:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('specific_price.start_date')}">
                                                    <div class="input-group date">
                                                        <date-picker :config="datetimepicker" v-model="specific_price.start_date"></date-picker>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>
                                                    </div>
                                                    <span v-if="IsError('specific_price.start_date')" class="help-block" v-for="e in IsError('specific_price.start_date')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Дата окончания срока:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('specific_price.expiration_date')}">
                                                    <div class="input-group date">
                                                        <date-picker :config="datetimepicker" v-model="specific_price.expiration_date"></date-picker>
                                                        <div class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </div>
                                                    </div>
                                                    <span v-if="IsError('specific_price.expiration_date')" class="help-block" v-for="e in IsError('specific_price.expiration_date')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_product_groups'}" role="tabpanel" class="tab-pane" id="tab_product_groups" v-if="!product.parent_id > 0">

                                <div class="col-md-12">

                                    <a target="_blank" v-if="product.id" :href="'/admin/product?parent_id=' + product.id" class="btn btn-primary" title="Создать">
                                        <i role="presentation" aria-hidden="true" class="fa fa-plus-square"></i>
                                        Создать
                                    </a>


                                    <div id="group-products">
                                        <div class="table-responsive1">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Название</th>
                                                        <th>Артикул</th>
                                                        <th>Цена</th>
                                                        <th>Статус</th>
                                                        <th>Действия</th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                            <tr class="tr-current-product" v-for="(item, index) in group_products">
                                                <td>{{ item.id }}</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.sku }}</td>
                                                <td>{{ item.price }}</td>
                                                <td>
                                                    <i class="fa fa-times-circle"
                                                       aria-hidden="true"
                                                       v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                                                </td>
                                                <td>
                                                    <router-link :to="{ path: '/product/' + item.id}" class="btn btn-xs btn-default" v-if="product.id != item.id" target="_blank">
                                                        <i class="fa fa-edit"></i> Изменить
                                                    </router-link>

                                                    <a class="btn btn-xs btn-default btn-remove-from-group" v-if="product.id != item.id" @click="tradingOffersDelete(item, index)">
                                                        <i class="fa fa-times"></i> Удалить
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_with_this_product_buy'}" role="tabpanel" class="tab-pane" id="tab_with_this_product_buy">
                                <div class="col-md-12">

                                    <div id="group-with_this_product_buy">
                                        <div class="table-responsive1">
                                            <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Товар ID</th>
                                                    <th>Название</th>
                                                    <th>Статус</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="tr-current-product" v-for="(item, index) in product_accessories">
                                                    <td>{{ item.id }}</td>
                                                    <td>{{ item.name }}</td>
                                                    <td>
                                                        <i class="fa fa-times-circle"
                                                           aria-hidden="true"
                                                           v-bind:class="{ 'fa-times-circle red'   : !item.active,
                                                                           'fa-check-circle green' : item.active }"></i>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-xs btn-default btn-remove-from-group" @click="deleteProductAccessory(index)">
                                                            <i class="fa fa-times"></i> Удалить
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <hr/>
                                    <h3>Добавить товар</h3>
                                    <div>
                                        <searchProducts ref="searchProducts" @productSelected="addProductAccessory"/>
                                    </div>

                                </div>
                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_seo'}" role="tabpanel" class="tab-pane" id="tab_seo">

                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Название:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-12" v-bind:class="{'has-error' : IsError('product.seo_title')}">
                                                    <textarea rows="4" v-model="product.seo_title" class="form-control"></textarea>
                                                    <br/>
                                                    <button type="button" @click="product.seo_title = product.name">
                                                        Вставить название
                                                    </button>
                                                    <span v-if="IsError('product.seo_title')" class="help-block" v-for="e in IsError('product.seo_title')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Keywords:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-12" v-bind:class="{'has-error' : IsError('product.seo_keywords')}">
                                                    <textarea rows="4" v-model="product.seo_keywords" class="form-control"></textarea>
                                                    <span v-if="IsError('product.seo_keywords')" class="help-block" v-for="e in IsError('product.seo_keywords')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>Description:</label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-12" v-bind:class="{'has-error' : IsError('product.seo_description')}">
                                                    <textarea rows="4" v-model="product.seo_description" class="form-control"></textarea>
                                                    <span v-if="IsError('product.seo_description')" class="help-block" v-for="e in IsError('product.seo_description')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>





                            </div>

                            <div v-bind:class="{'active' : tab_active == 'tab_reviews'}" role="tabpanel" class="tab-pane" id="tab_reviews" v-if="product.id > 0">

                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>
                                                    <i class="fa fa-comment"></i>
                                                    Средний рейтинг отзывов:
                                                </label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.reviews_rating_avg')}">
                                                    <input type="text" v-model="product.reviews_rating_avg" class="form-control">
                                                    <span v-if="IsError('product.reviews_rating_avg')" class="help-block" v-for="e in IsError('product.reviews_rating_avg')">
                                                             {{ e }}
                                                        </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" class="text-right">
                                                <label>
                                                    <i class="fa fa-comment"></i>
                                                    Количество отзывов:
                                                </label>
                                            </td>
                                            <td width="75%">
                                                <div class="col-md-6" v-bind:class="{'has-error' : IsError('product.reviews_count')}">
                                                    <input type="text" v-model="product.reviews_count" class="form-control">
                                                    <span v-if="IsError('product.reviews_count')" class="help-block" v-for="e in IsError('product.reviews_count')">
                                                         {{ e }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <reviews :product_id="product.id"></reviews>
                            </div>


                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" @click="setMethodRedirect('save_and_continue')">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и продолжить</span>
                            </button>
                            <button type="submit" class="btn btn-primary" @click="setMethodRedirect('save_and_back')">
                                <span class="fa fa-mail-reply" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и назад</span>
                            </button>
                            <button type="submit" class="btn btn-info" @click="setMethodRedirect('save_and_new')">
                                <span class="fa fa-plus-square" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и новый</span>
                            </button>

                            <a target="_blank" :href="detail_url" v-if="detail_url" class="btn btn-warning">
                                <i class="fa fa-internet-explorer" aria-hidden="true"></i>
                                Посмотреть товар
                            </a>

                            <router-link :to="{path: '/products'}" class="btn btn-default">
                                <span class="fa fa-ban"></span> &nbsp;
                                Отменить
                            </router-link>

                        </div>
                    </div><!-- /.box-footer-->

                </div><!-- /.box -->
            </form>
        </div>


    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';
    //https://select2.org/configuration/options-api
    import Select2 from 'v-select2-component';
    import UploadImages from '../plugins/UploadImages';
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import reviews from '../reviews/reviews';
    import Categories  from '../plugins/Categories';
    import Ckeditor    from  '../plugins/Ckeditor';
    import SelectColor from '../plugins/SelectColor';
    import searchProducts from '../plugins/SearchProducts';
    import Attributes  from '../products/Attributes';


    export default {
        components:{
            Paginate,
            Select2,
            UploadImages,
            datePicker,
            Ckeditor,
            reviews,
            Categories,
            SelectColor,
            searchProducts,
            Attributes
        },
        data () {
            return {
                datetimepicker: {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    locale: 'ru'
                },
                product:{
                    id:        this.$route.params.product_id ? this.$route.params.product_id : 0,
                    parent_id: this.$route.query.parent_id   ? this.$route.query.parent_id   : 0,
                    name: '',
                    url: '',
                    description: '',
                    photo: '',
                    pathPhoto: '',
                    price: 0,
                    sku: '',
                    stock: 1,
                    active: 1,
                    seo_title: '',
                    seo_keywords: '',
                    seo_description: '',
                    youtube: '',
                    view_count: 0,
                    reviews_rating_avg: 0,
                    reviews_count: 0,
                    description_full_screen: 0
                },
                product_photo_upload_type: 'file',
                product_accessories: [],
                attributes: [],
                product_images: [],
                specific_price:{
                    reduction: 0,
                    discount_type: 'percent',
                    start_date: '',
                    expiration_date: ''
                },

                categories: [],
                method_redirect: 'save_and_back',
                tab_active: 'tab_general',
                categories_list: [],
                group_products: [],
                detail_url: ''
            }
        },

        methods:{
            convertColorOptions(values){
                var data = [];
                values.forEach(function (item, index) {
                    data.push({
                        id:   item.value,
                        hex:  item.props,
                        name: item.value
                    });
                });
                return data;
            },
            deleteProductAccessory(index){
                 this.$delete(this.product_accessories, index);
            },
            addProductAccessory(product){

                var add = true;
                this.product_accessories.forEach(function (item, index){
                    if(item.id == product.id)
                    {
                        add = false;
                        return;
                    }
                });

                if(add)
                    this.product_accessories.push({
                        id:     product.id,
                        name:   product.name,
                        active: product.active
                    });
                else{
                    this.$helper.swalError('Товар уже добавлен');
                }
            },
            tradingOffersDelete(item, index){
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
                                this.$delete(this.group_products, index);
                            }
                        });
                    }
                });
            },
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            setProductPhoto(event){

                var self = this;
                var reader = new FileReader();
                reader.onload = function(e) {
                    self.product.pathPhoto = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);

                this.product.photo = event.target.files[0];
            },
            setTab(tab){
                this.tab_active = tab;
            },
            convertDataSelect2(values, column_id, column_text){
                return this.$helper.convertDataSelect2(values, column_id, column_text);
            },
            productSave(event){
                event.preventDefault();
                this.SetErrors(null);
                var self = this;

                var data = new FormData();

                //продукт
                $.each(this.product, function(column, value) {
                    if(column != 'view_count')
                        data.append('product[' + column + ']', self.$helper.isNullClear(value));
                });

                $.each(this.specific_price, function(column, value) {
                    data.append('specific_price[' + column + ']', self.$helper.isNullClear(value));
                });

                //Аксессуары
                $.each(this.product_accessories, function(index, item) {
                    data.append('accessories_product_ids[' + index + ']', item.id);
                });

                if(Array.isArray(this.categories)){
                    for(var i = 0; i < this.categories.length; i++)
                        data.append('categories[' + i + ']', this.categories[i]);
                }else
                    data.append('categories', this.categories);


                $.each(this.product_images, function(index, item) {
                    data.append('product_images[' + index + '][id]',        item.id);
                    data.append('product_images[' + index + '][is_delete]', item.is_delete);
                    data.append('product_images[' + index + '][value]',     item.value);
                });

                $.each(this.attributes, function(index, item) {
                    data.append('attributes[' + index + '][attribute_id]', item.attribute_id);

                    if(Array.isArray(item.value)){
                        for(var i = 0; i < item.value.length; i++)
                            data.append('attributes[' + index + '][value][' + i + ']', item.value[i]);
                    }else
                        data.append('attributes[' + index + '][value]', item.value);
                });

                axios.post('/admin/product-save', data).then((res)=>{
                    var product_id = res.data;

                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.product.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){

                            this.$router.push({
                                name: 'product_edit',
                                params: {
                                    product_id: product_id
                                }
                            });
                            location.reload();

                        }else if(this.method_redirect == 'save_and_new'){

                            this.$router.go({ name: 'product_create' });

                        }
                    }
                });
            },
            getProduct(product_id){
                if(product_id > 0)
                {

                            axios.get('/admin/product-view/' + product_id).then((res)=>{
                                document.querySelector('input[type=file]').value = '';

                                var data    = res.data;
                                var product = data.product;

                                this.product.id               = product.id;
                                this.product.parent_id        = product.parent_id;
                                this.product.name             = product.name;
                                this.product.url              = product.url;
                                this.product.description      = product.description;
                                this.product.seo_title        = product.seo_title;
                                this.product.seo_keywords     = product.seo_keywords;
                                this.product.seo_description  = product.seo_description;
                                this.product.photo            = product.photo;
                                this.product.pathPhoto        = product.pathPhoto;
                                this.product.price            = parseInt(product.price);
                                this.product.sku              = product.sku;
                                this.product.stock            = product.stock;
                                this.product.active           = product.active;
                                this.product.youtube          = product.youtube;
                                this.product.view_count       = product.view_count;
                                this.product.reviews_rating_avg = product.reviews_rating_avg;
                                this.product.reviews_count      = product.reviews_count;
                                this.product.description_full_screen      = product.description_full_screen;


                                this.group_products = product.children;

                                this.categories     = data.categories;
                                this.product_images = data.images;

                                console.log(data);

                                setTimeout(function () {
                                    var self = this;
                                    $.each(data.attributes, function(attribute_id, value) {
                                        self.attributes.forEach(function (item, index) {
                                            if(attribute_id == item.attribute_id)
                                            {
                                                self.$set(self.attributes[index], 'value' , value);
                                            }
                                        });
                                    });
                                }.bind(this, data), 1000);

                                this.product_accessories = data.product_accessories;


                                if(data.specific_price)
                                {
                                    this.specific_price.reduction       = data.specific_price.reduction;
                                    this.specific_price.discount_type   = data.specific_price.discount_type;
                                    this.specific_price.start_date      = data.specific_price.start_date;
                                    this.specific_price.expiration_date = data.specific_price.expiration_date;
                                }

                                this.detail_url = data.detail_url;

                            });
                }
            },
            ...mapActions(['SetErrors'])
        },
        created(){

            var params = {per_page: 100};
            axios.get('/admin/categories-list', {params:  params}).then((res)=>{
                this.categories_list = res.data.data;
            });

            setTimeout(function () {
                if(this.product.id > 0)
                    this.getProduct(this.product.id);
            }.bind(this), 1000);
        },

        computed:{
            ...mapGetters([
                'IsError'
            ]),
            uploadFilePath(){
                var product_id = 0;

                if(this.$route.params.id)
                    product_id = this.$route.params.id;
                else if(this.product)
                    product_id = this.product.id;

                if(product_id){
                    return 'uploads/products/' + product_id + '/';
                }else{
                    return '';
                }
            },


        },
        watch: {
            '$route'() {
                this.getProduct(this.$route.params.id);
            },
            'product.photo':{
                handler: function (val, oldVal) {
                    if(this.product_photo_upload_type == 'url'){
                        this.product.pathPhoto = val;
                    }
                },
                deep: true
            }
        },
    }
</script>

<style scoped>
    .nav-tabs li{
        cursor: pointer;
    }
    .nav-tabs-custom>.nav-tabs>li {
        font-size: 12px;
    }
    .width-input{
        width: 424px;
    }
</style>
