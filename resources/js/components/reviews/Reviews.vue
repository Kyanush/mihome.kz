<template>
    <div class="box">

        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-primary ladda-button" @click="popupReview(null)">
                     <span class="ladda-label">
                        <i class="fa fa-plus"></i> Создать отзыв
                    </span>
                    </a>
                </div>
                <div class="col-md-8">
                    <div class="pull-right">
                        <input id="filter-search" type="search" class="form-control input-sm pull-right" placeholder="Поиск" v-model="filter.search">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Недостатки</th>
                    <th>Достоинства</th>
                    <th>Ваш e-mail</th>
                    <th>Комментарий</th>
                    <th>Ваше имя</th>
                    <th>Оценка</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody v-if="reviews">
                <tr v-for="item in reviews.data" v-bind:class="{ 'deleted': !item.active }">
                    <td>{{ item.id }}</td>
                    <td>
                        <router-link :to="{ path: '/products/edit/' + item.product_id}">
                            {{ item.product.name }}
                        </router-link>
                    </td>
                    <td>{{ item.minus }}</td>
                    <td>{{ item.plus }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.comment }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.rating }}</td>
                    <td>
                        <i class="fa fa-times-circle"
                           aria-hidden="true"
                           v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                    </td>
                    <td>{{ dateFormat(item.created_at) }}</td>
                    <td>
                        <a title="Изменить" class="btn btn-xs btn-default" @click="popupReview(item)">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a title="Удалить" class="btn btn-xs btn-default" @click="deleteReview(item)">
                            <i class="fa fa-remove"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Недостатки</th>
                    <th>Достоинства</th>
                    <th>Ваш e-mail</th>
                    <th>Комментарий</th>
                    <th>Ваше имя</th>
                    <th>Оценка</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </tfoot>
        </table>
        </div>

        <div class="text-center">
                <paginate
                        v-if="reviews && reviews.last_page > 1"
                        v-model="reviews.current_page"
                        :page-count="reviews.last_page"
                        :click-handler="getReviews"
                        :prev-text="'<<'"
                        :next-text="'>>'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"></paginate>
         </div>

        <div class="modal fade form-popup" id="popup-review" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <b> {{ review.id ? 'Изменить отзыв' : 'Создать отзыв'}}</b>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <form  v-on:submit="saveReview">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.name')}">
                                        <label>Ваше имя <span class="red">*</span></label>
                                        <input required v-model="review.name" type="text" class="form-control" placeholder="Ваше имя"/>
                                        <span v-if="IsError('review.name')" class="help-block" v-for="e in IsError('review.name')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.email')}">
                                        <label>E-mail</label>
                                        <input v-model="review.email" type="text" class="form-control" placeholder="E-mail"/>
                                        <span v-if="IsError('review.email')" class="help-block" v-for="e in IsError('review.email')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.comment')}">
                                        <label>Комментарий</label>
                                        <textarea   v-model="review.comment" class="form-control" placeholder="Комментарий"></textarea>
                                        <span v-if="IsError('review.comment')" class="help-block" v-for="e in IsError('review.comment')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.plus')}">
                                        <label>Достоинства</label>
                                        <textarea v-model="review.plus" class="form-control" placeholder="Комментарий"></textarea>
                                        <span v-if="IsError('review.plus')" class="help-block" v-for="e in IsError('review.plus')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.minus')}">
                                        <label>Недостатки</label>
                                        <textarea v-model="review.minus" class="form-control" placeholder="Недостатки"></textarea>
                                        <span v-if="IsError('review.minus')" class="help-block" v-for="e in IsError('review.minus')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.rating')}">
                                        <label>Оценка <span class="red">*</span></label>
                                        <select required v-model="review.rating" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        <span v-if="IsError('review.rating')" class="help-block" v-for="e in IsError('review.rating')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.active')}">
                                        <label>Статус <span class="red">*</span></label>
                                        <select required v-model="review.active" class="form-control">
                                            <option value="1">активен</option>
                                            <option value="0">не активен</option>
                                        </select>
                                        <span v-if="IsError('review.active')" class="help-block" v-for="e in IsError('review.active')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.created_at')}">
                                        <label>Дата <span class="red">*</span></label>
                                        <date-picker required :config="datetimepicker" v-model="review.created_at"></date-picker>
                                        <span v-if="IsError('review.created_at')" class="help-block" v-for="e in IsError('review.created_at')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12" v-if="!product_id">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('review.product_id')}">
                                        <label>Товар <span class="red">*</span></label>

                                        <Select2
                                                @select="setReviewProductId($event)"
                                                :settings="productsSearchSelect2.settings"
                                                :options="productsSearchSelect2.options"
                                        />

                                        <span v-if="IsError('review.product_id')" class="help-block" v-for="e in IsError('review.product_id')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>



                            </div>
                            <div class="row btn-item">
                                <div class="form-group col-md-6">
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close">
                                        Закрыть
                                    </button>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        {{ review.id ? 'Изменить отзыв' : 'Создать отзыв'}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';
    import { mapGetters } from 'vuex';
    import Select2 from 'v-select2-component';

    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {
        props:['product_id'],
        components:{
            Paginate,
            Select2,
            datePicker
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
                reviews: null,
                review: {
                    id: 0,
                    name: '',
                    email: '',
                    comment: '',
                    plus: '',
                    minus: '',
                    rating: 0,
                    product_id: (this.product_id > 0 ? this.product_id : 0),
                    active: 1,
                    created_at: ''
                },
                filter:{
                    page:   (this.$route.query.page       ? this.$route.query.page : 1),
                    search: (this.$route.query.search     ? this.$route.query.search : ''),
                },
                productsSearchSelect2:{
                    options:  [],
                    settings: {
                        placeholder: "Поиск",
                        ajax: {
                            url: '/admin/search-products',
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    perPage: 5
                                }
                                return query;
                            },
                            processResults: function (data) {
                                var results = [];
                                data.forEach(function (item, index){
                                    results.push({
                                        id:     item.id,
                                        text:   item.name
                                    });
                                });
                                return {
                                    results: results
                                };
                            }
                        }
                    }
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.getReviews();
                },
                deep: true
            }
        },
        created() {
            this.getReviews();
        },
        methods:{
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option);
            },

            setReviewProductId(item){
                this.review.product_id = item.id;
            },

            saveReview(event){
                event.preventDefault();

                var self = this;
                var data = new FormData();
                $.each(this.review, function(column, value) {
                    data.append(column, self.$helper.isNullClear(value));
                });

                axios.post('/admin/review-save', data).then(response => {
                    if(response.data){
                        this.$helper.swalSuccess(this.review.id ? 'Отзыв изменен' : 'Отзыв создан' );
                        this.getReviews();

                        $('#popup-review').modal('hide');
                    }
                });
            },
            dateFormat(date, type_format){
                return this.$helper.dateFormat(date, type_format);
            },
            getReviews(page) {
                page = !page ? (this.$route.query.page ? this.$route.query.page : 1) : page;
                var params = {};
                if(page > 1)
                    params['page'] = page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                if(this.product_id)
                    params['product_id'] = this.product_id;

                axios.get('/admin/reviews-list', {params:  params}).then(response => {
                    this.reviews = response.data;
                    if(!this.product_id)
                        this.$router.push({query: params});
                });
            },

            popupReview(item){

                this.review.id         = item ? item.id         : 0;
                this.review.name       = item ? item.name       : '';
                this.review.email      = item ? item.email      : '';
                this.review.comment    = item ? item.comment    : '';
                this.review.plus       = item ? item.plus       : '';
                this.review.minus      = item ? item.minus      : '';
                this.review.rating     = item ? item.rating     : 0;
                this.review.product_id = item ? item.product.id : (this.product_id > 0 ? this.product_id : 0);
                this.review.active     = item ? item.active     : 0;
                this.review.created_at = item ? item.created_at : '';

                $('#popup-review').modal('show');
            },
            deleteReview(item){

                this.$swal({
                    title: 'Вы действительно хотите удалить "' + item.name + '"?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/review-delete/' + item.id).then(response => {
                            if(response.data){
                                this.$helper.swalSuccess('Успешно удален');
                                this.getReviews();
                            }
                        });
                    }
                });
            }
        },
        computed:{
            ...mapGetters([
                'IsError'
            ]),
        }
    }
</script>