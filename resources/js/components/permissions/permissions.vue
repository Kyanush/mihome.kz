<template>
    <div class="box">
        <div class="box-header with-border">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Фильтр</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive1">

                                <table class="table table-bordered ">
                                    <tbody>

                                    <tr class="odd even">
                                        <td><b>Название:</b></td>
                                        <td>
                                            <input class="form-control" v-model="filter.name"/>
                                        </td>
                                    </tr>
                                    <tr class="odd even">
                                        <td>
                                            <button type="button" class="btn btn btn-danger" @click="clear" >
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                Очистить
                                            </button>
                                        </td>
                                        <td>
                                            <button @click="viewPermission('')"
                                                    class="btn btn-primary"
                                                    title="Создать">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                Создать
                                            </button>

                                            <button type="button" class="btn btn-success float-right" @click="search">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                Поиск
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-bordered table-panel">
                    <thead>
                        <tr class="odd even">
                            <th>ID</th>
                            <th>Описание</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd even" v-for="(permission, index) in permissions.data">
                            <td>{{ permission.id }}</td>
                            <td>{{ permission.description }}</td>
                            <td>{{ permission.name }}</td>
                            <td>

                                <button @click="viewPermission(permission.id)" type="button" class="btn btn-xs btn-default" title="Изменить">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <a
                                   class="btn btn-xs btn-default"
                                   @click="deletePermission(permission, index)"
                                   title="Удалить">
                                    <i class="fa fa-remove red"></i> <!--Удалить-->
                                </a>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <p>{{ permissions.to }} из {{ permissions.total }}</p>

                <paginate
                        v-if="permissions.last_page > 1"
                        v-model="permissions.current_page"
                        :page-count="permissions.last_page"
                        :click-handler="setPage"
                        :prev-text="'<<'"
                        :next-text="'>>'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"></paginate>
            </div>

        </div>

        <RightSidePopup @state="statePermissionPopup"
                        ref="right_side_popup_permission"
                        :title="filter.p_permission_id > 0 ? 'Изменить права доступа:' + filter.p_permission_id : 'Создать права доступа'">

            <permission @permission_id="permissionSaved" :p_permission_id="filter.p_permission_id"/>

        </RightSidePopup>

    </div>
</template>

<script>
    import Paginate       from 'vuejs-paginate';
    import permission     from "./permission";
    import RightSidePopup from "../plugins/RightSidePopup";

    export default {
        components:{
            Paginate, RightSidePopup, permission
        },
        name: "permissions",
        data () {
            return {
                permissions: [],
                filter:{
                    name:            this.$route.query.name            ? this.$route.query.name        : '',
                    description:     this.$route.query.description     ? this.$route.query.description : '',
                    page:            this.$route.query.page,
                    p_permission_id: this.$route.query.p_permission_id ? this.$route.query.p_permission_id : ''
                }
            }
        },
        methods:{
            statePermissionPopup(state){
                if(state == 'close')
                {
                    this.$oneParameterCurrent('p_permission_id', 'delete');
                    this.filter.p_permission_id = 0;
                    this.search();
                }
            },
            permissionSaved(permission_id){
                if(permission_id){
                    this.search();
                    this.$oneParameterCurrent('p_permission_id', 'add', permission_id);
                }
            },
            setPage(page){
                this.filter.page = page;
                this.search();
            },
            search(){
                var params = this.$clearParams(this.filter);


                this.$router.push({query: params});

                axios.get('/admin/permissions', { params: params }).then((res)=>{
                    this.permissions = res.data;
                });
            },
            clear(){
                this.filter = {
                    name:        '',
                    description: '',
                    page:        1
                };
                this.$router.push({query: {}});
                this.search();
            },
            viewPermission(permission_id){
                this.filter.p_permission_id = permission_id;

                this.$refs.right_side_popup_permission.active = true;

                this.$oneParameterCurrent('p_permission_id', 'add', permission_id);
            },
            deletePermission(permission, index){

                    this.$swal({
                        title: 'Вы действительно хотите удалить' + ' "' + permission.name + '"?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Да',
                        cancelButtonText: 'Нет'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete('/admin/permissions/' + permission.id).then((res)=>{
                                if(res.data)
                                {
                                    this.$swalSuccess('Успешно удален');
                                    this.$delete(this.permissions.data, index);
                                }
                            });
                        }
                    });

            }
        },
        created(){

            this.search();

            setTimeout(function () {

                if(this.filter.p_permission_id)
                    this.viewPermission(this.filter.p_permission_id);

            }.bind(this), 1000);

        }
    }
</script>