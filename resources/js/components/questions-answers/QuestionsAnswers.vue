<template>
    <div class="box">

        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-4">
                    <a class="btn btn-primary ladda-button" @click="popupQuestionAnswer(null)">
                     <span class="ladda-label">
                        <i class="fa fa-plus"></i> Создать вопрос-ответ
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
            <table class="table table-bordered " v-if="questions_answers">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Имя</th>
                    <th>E-mail</th>
                    <th>Вопрос</th>
                    <th>Ответ</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
                <tbody  v-for="item in questions_answers.data">
                    <tr v-bind:class="{ 'deleted': !item.active }">
                        <td>{{ item.id }}</td>
                        <td>
                            <router-link :to="{ path: '/products/edit/' + item.product_id}">
                                {{ item.product.name }}
                            </router-link>
                        </td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.question }}</td>
                        <td>{{ item.answer }}</td>
                        <td>
                            <i class="fa fa-times-circle"
                               aria-hidden="true"
                               v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                        </td>
                        <td>{{ dateFormat(item.created_at) }}</td>
                        <td>
                            <a title="Изменить" class="btn btn-xs btn-default" @click="popupQuestionAnswer(item)">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a title="Удалить" class="btn btn-xs btn-default" @click="deleteQuestionAnswer(item)">
                                <i class="fa fa-remove"></i>
                            </a>
                        </td>
                    </tr>


                </tbody>
            <tfoot>
                <tr>
                    <th>№</th>
                    <th>Товар</th>
                    <th>Имя</th>
                    <th>E-mail</th>
                    <th>Вопрос</th>
                    <th>Ответ</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </tfoot>
        </table>
        </div>

        <div class="text-center">
                <paginate
                        v-if="questions_answers && questions_answers.last_page > 1"
                        v-model="questions_answers.current_page"
                        :page-count="questions_answers.last_page"
                        :click-handler="getQuestionsAnswers"
                        :prev-text="'<<'"
                        :next-text="'>>'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"></paginate>
         </div>


        <div class="modal fade form-popup" id="popup-question-answer" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <b> {{ question_answer.id ? 'Изменить вопрос-ответ' : 'Создать вопрос-ответ'}}</b>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <form  v-on:submit="saveQuestionAnswer">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.name')}">
                                        <label>Ваше имя <span class="red">*</span></label>
                                        <input v-model="question_answer.name" type="text" class="form-control" placeholder="Ваше имя"/>
                                        <span v-if="IsError('question_answer.name')" class="help-block" v-for="e in IsError('question_answer.name')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.email')}">
                                        <label>E-mail</label>
                                        <input v-model="question_answer.email" type="text" class="form-control" placeholder="E-mail"/>
                                        <span v-if="IsError('question_answer.email')" class="help-block" v-for="e in IsError('question_answer.email')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.question')}">
                                        <label>Вопрос <span class="red">*</span></label>
                                        <textarea v-model="question_answer.question" class="form-control" placeholder="Вопрос"></textarea>
                                        <span v-if="IsError('question_answer.question')" class="help-block" v-for="e in IsError('question_answer.question')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.answer')}">
                                        <label>Ответ <span class="red">*</span></label>
                                        <textarea v-model="question_answer.answer" class="form-control" placeholder="Ответ"></textarea>
                                        <span v-if="IsError('question_answer.answer')" class="help-block" v-for="e in IsError('question_answer.answer')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.active')}">
                                        <label>Статус <span class="red">*</span></label>
                                        <select v-model="question_answer.active" class="form-control">
                                            <option value="1">активен</option>
                                            <option value="0">не активен</option>
                                        </select>
                                        <span v-if="IsError('question_answer.active')" class="help-block" v-for="e in IsError('question_answer.active')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.created_at')}">
                                        <label>Дата <span class="red">*</span></label>
                                        <date-picker :config="datetimepicker" v-model="question_answer.created_at"></date-picker>
                                        <span v-if="IsError('question_answer.created_at')" class="help-block" v-for="e in IsError('question_answer.created_at')">
                                            {{ e }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12" v-if="!product_id">
                                    <div class="form-group" v-bind:class="{'has-error' : IsError('question_answer.product_id')}">
                                        <label>Товар <span class="red">*</span></label>

                                        <Select2
                                                @select="setQuestionAnswerProductId($event)"
                                                :settings="productsSearchSelect2.settings"
                                                :options="productsSearchSelect2.options"
                                        />

                                        <span v-if="IsError('question_answer.product_id')" class="help-block" v-for="e in IsError('question_answer.product_id')">
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
                                        {{ question_answer.id ? 'Изменить вопрос-ответ' : 'Создать вопрос-ответ'}}
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
                questions_answers: null,
                question_answer: {
                    id: 0,
                    name: '',
                    email: '',
                    question: '',
                    answer: '',
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
                    this.getQuestionsAnswers();
                },
                deep: true
            }
        },
        created() {
            this.getQuestionsAnswers();
        },
        methods:{
            convertDataSelect2(values, column_id, column_text, disabled_column, default_option){
                return this.$helper.convertDataSelect2(values, column_id, column_text, disabled_column, default_option);
            },

            setQuestionAnswerProductId(item){
                this.question_answer.product_id = item.id;
            },

            saveQuestionAnswer(event){
                event.preventDefault();

                var self = this;
                var data = new FormData();
                $.each(this.question_answer, function(column, value) {
                    data.append(column, self.$helper.isNullClear(value));
                });

                axios.post('/admin/question-answer-save', data).then(response => {
                    if(response.data){
                        this.$helper.swalSuccess(this.question_answer.id ? 'Вопрос-ответ изменен' : 'Вопрос-ответ создан' );
                        this.getQuestionsAnswers();

                        $('#popup-question-answer').modal('hide');
                    }
                });
            },
            dateFormat(date, type_format){
                return this.$helper.dateFormat(date, type_format);
            },



            getQuestionsAnswers(page) {
                page = !page ? (this.$route.query.page ? this.$route.query.page : 1) : page;
                var params = {};
                if(page > 1)
                    params['page'] = page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/questions-answers-list', {params:  params}).then(response => {
                    this.questions_answers = response.data;
                    if(!this.product_id)
                        this.$router.push({query: params});
                });
            },

            popupQuestionAnswer(item){

                this.question_answer.id           = item ? item.id         : 0;
                this.question_answer.name         = item ? item.name       : '';
                this.question_answer.email        = item ? item.email      : '';
                this.question_answer.question     = item ? item.question   : '';
                this.question_answer.answer       = item ? item.answer     : '';
                this.question_answer.product_id   = item ? item.product.id : (this.product_id > 0 ? this.product_id : 0);
                this.question_answer.active       = item ? item.active     : 0;
                this.question_answer.created_at   = item ? item.created_at : '';

                $('#popup-question-answer').modal('show');
            },
            deleteQuestionAnswer(item){

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
                        axios.post('/admin/question-answer-delete/' + item.id).then(response => {
                            if(response.data){
                                this.$helper.swalSuccess('Успешно удален');
                                this.getQuestionsAnswers();
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

<style>
    .select2-container{
        width: 100%!important;
    }
</style>
