<template>
    <div class="box">

        <div class="box-header with-border">

            <router-link :to="{ path: '/carriers/create'}" class="btn btn-primary ladda-button">
                <span class="ladda-label">
                    <i class="fa fa-plus"></i> Создать курьер
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
                                <th>Цена</th>
                                <th>Описание</th>
                                <th>Логотип</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd even" v-for="(item, index) in carriers.data">
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.price }}</td>
                                <td>{{ item.delivery_text }}</td>
                                <td>
                                    <img class="img" v-if="item.logo" v-bind:src="item.logo ? '/uploads/carriers/' + item.logo : ''" width="70"/>
                                </td>
                                <td>
                                    <router-link :to="{ path: '/carriers/edit/' + item.id}" class="btn btn-xs btn-default">
                                        <i class="fa fa-edit"></i> Изменить
                                    </router-link>

                                    <a class="btn btn-xs btn-default" @click="carrierDelete(item, index)">
                                        <i class="fa fa-remove"></i> Удалить
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Описание</th>
                                <th>Логотип</th>
                                <th>Действия</th>
                            </tr>
                        </tfoot>
               </table>
        </div>
        <div class="text-center">
            <paginate
                    v-if="carriers.last_page > 1"
                    v-model="carriers.current_page"
                    :page-count="carriers.last_page"
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
                carriers: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.carriersList();
                },
                deep: true
            }
        },
        created(){
            this.carriersList();
        },
        methods:{
            SetPage(page){
                this.filter.page = page;
            },
            carrierDelete(item, index){
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
                        axios.post('/admin/carrier-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.carriers.data, index);
                            }
                        });
                    }
                });
            },
            carriersList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/carriers-list', {params:  params}).then((res)=>{
                    this.carriers = res.data;
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>
