<template>
    <div class="box">

        <div class="box-header with-border">

            <router-link :to="{ path: '/news/create'}" class="btn btn-primary ladda-button">
                <span class="ladda-label">
                    <i class="fa fa-plus"></i> Создать
                </span>
            </router-link>

            <input id="filter-search" type="search" class="form-control input-sm pull-right" placeholder="Поиск" v-model="filter.search">
        </div>

       <div class="table-responsive">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Ссылка</th>
                        <th>Картина</th>
                        <th>Описание</th>
                        <th>Текст</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd even" v-for="(item, index) in news.data">
                        <td>{{ item.id }}</td>
                        <td>{{ item.title }}</td>
                        <td>{{ item.code }}</td>
                        <td>
                            <img class="img" v-if="item.image" v-bind:src="item.image ? '/uploads/news/' + item.image : ''" width="70"/>
                        </td>
                        <td>{{ limitText(item.preview_text) }}</td>
                        <td>{{ limitText(item.detail_text) }}</td>
                        <td>
                            {{ dateFormat(item.created_at) }}
                            <br/>
                            {{ dateFormat(item.updated_at) }}
                        </td>
                        <td>
                            <i class="fa fa-times-circle" aria-hidden="true" v-bind:class="{ 'fa-times-circle red': !item.active, 'fa-check-circle green': item.active }"></i>
                        </td>
                        <td>
                            <router-link :to="{ path: '/news/edit/' + item.id}" class="btn btn-xs btn-default">
                                <i class="fa fa-edit"></i> Изменить
                            </router-link>

                            <a class="btn btn-xs btn-default" @click="newsDelete(item, index)">
                                <i class="fa fa-remove"></i> Удалить
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Ссылка</th>
                        <th>Картина</th>
                        <th>Описание</th>
                        <th>Текст</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </tfoot>
       </table>
       </div>

        <div class="text-center">
            <paginate
                    v-if="news.last_page > 1"
                    v-model="news.current_page"
                    :page-count="news.last_page"
                    :click-handler="SetPage"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>


    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';

    export default {
        components:{
            Paginate
        },
        data () {
            return {
                news: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.newsList();
                },
                deep: true
            }
        },
        created(){
            this.newsList();
        },
        methods:{
            limitText(text){
                var count = 50;
                return text.slice(0, count) + (text.length > count ? "..." : "");
            },
            dateFormat(date, type_format){
                return this.$helper.dateFormat(date, type_format);
            },
            SetPage(page){
                this.filter.page = page;
            },
            newsDelete(item, index){
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
                        axios.post('/admin/news-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.news.data, index);
                            }
                        });
                    }
                });
            },
            newsList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/news-list', {params:  params}).then((res)=>{
                    this.news = res.data;
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>