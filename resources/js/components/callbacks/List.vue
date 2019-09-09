<template>
    <div class="box">

        <div class="box-header with-border">
            <input id="filter-search" type="search" class="form-control input-sm pull-right" placeholder="Поиск" v-model="filter.search">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Тип</th>
                        <th>Статус</th>
                        <th>Телефон</th>
                        <th width="200">Сообщение</th>
                        <th>E-mail</th>
                        <th>Комментарий<br/>администратора</th>
                        <th>Дата заявки</th>
                        <th>Дата изменения</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd even" v-for="(item, index) in callbacks.data">
                        <td>{{ item.id }}</td>
                        <td>{{ item.type }}</td>
                        <td>
                            <i :class="item.status.class" aria-hidden="true"></i>
                            {{ item.status.name }}
                        </td>
                        <td>{{ item.phone }}</td>
                        <td width="200">{{ item.message }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.comment }}</td>
                        <td>{{ dateFormatTodayYesterday(item.created_at) }}</td>
                        <td>{{ dateFormatTodayYesterday(item.updated_at) }}</td>
                        <td>
                            <router-link :to="{ path: '/callbacks/edit/' + item.id}" class="btn btn-xs btn-default" title="Изменить">
                                <i class="fa fa-edit"></i> <!--Изменить-->
                            </router-link>
                            <a class="btn btn-xs btn-default" @click="callbackDelete(item, index)">
                                <i class="fa fa-remove"></i> <!--Удалить-->
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Тип</th>
                        <th>Статус</th>
                        <th>Телефон</th>
                        <th width="200">Сообщение</th>
                        <th>E-mail</th>
                        <th>Комментарий<br/>администратора</th>
                        <th>Дата заявки</th>
                        <th>Дата изменения</th>
                        <th>Действия</th>
                    </tr>
                </tfoot>
       </table>
        </div>

        <div class="text-center">
            <paginate
                    v-if="callbacks.last_page > 1"
                    v-model="callbacks.current_page"
                    :page-count="callbacks.last_page"
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
                callbacks: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.callbacksList();
                },
                deep: true
            }
        },
        created(){
            this.callbacksList();
        },
        methods:{
            dateFormatTodayYesterday(dateString){
                return this.$helper.dateFormatTodayYesterday(dateString);
            },
            SetPage(page){
                this.filter.page = page;
            },
            callbackDelete(item, index){
                this.$swal({
                    title: 'Вы действительно хотите удалить' + ' "' + item.phone + '"?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/callback-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.callbacks.data, index);
                            }
                        });
                    }
                });
            },
            callbacksList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/callbacks-list', {params:  params}).then((res)=>{
                    this.callbacks = res.data;
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>