<template>
    <div class="box">

        <div class="box-header with-border">

            <router-link :to="{ path: '/attributes/create'}" class="btn btn-primary ladda-button">
                            <span class="ladda-label">
                                <i class="fa fa-plus"></i> Создать атрибут
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
                <th>Тип</th>
                <th>Обязательные поля</th>
                <th>Код</th>
                <th>Показывать в фильтре</th>
                <th>Описание</th>
                <th>Группа</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd even" v-for="(item, index) in attributes.data">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.type }}</td>
                <td>{{ item.required == 1 ? 'Да' : 'Нет' }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.use_in_filter == 1 ? 'Да' : 'Нет' }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.attribute_group ? item.attribute_group.name : ''}}</td>
                <td>
                    <router-link :to="{ path: '/attributes/edit/' + item.id}" class="btn btn-xs btn-default">
                        <i class="fa fa-edit"></i>
                    </router-link>

                    <span class="btn btn-xs btn-default" @click="deleteAttribute(item, index)">
                         <i class="fa fa-remove"></i>
                    </span>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Тип</th>
                <th>Обязательные поля</th>
                <th>Код</th>
                <th>Показывать в фильтре</th>
                <th>Описание</th>
                <th>Группа</th>
                <th>Действия</th>
            </tr>
            </tfoot>
        </table>
        </div>

        <div class="text-center">
            <paginate
                    v-if="attributes.last_page > 1"
                    v-model="attributes.current_page"
                    :page-count="attributes.last_page"
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
                attributes: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.attributesList();
                },
                deep: true
            }
        },
        created(){
            this.attributesList();
        },
        methods:{
            SetPage(page){
                this.filter.page = page;
            },
            deleteAttribute(item, index){
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
                        axios.post('/admin/attribute-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.attributes.data, index);
                            }
                        });
                    }
                });
            },
            attributesList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                params['per_page'] = 10;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/attributes-list', {params:  params}).then((res)=>{
                    this.attributes = res.data;
                    this.$delete(params, 'per_page');
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>