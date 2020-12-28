<template>
    <div class="box">
        <div class="box-body">

            <history_back :router="'permissions'" :text="'Права доступа'"></history_back>

            <div class="row">
                <div class="col-md-6">
                    <form v-on:submit="save">
                        <table class="table table-bordered">
                            <tbody>
                            <tr class="odd even">
                                <td><b>Название <i class="red">*</i></b></td>
                                <td>
                                    <input class="form-control" v-model="permission.name"/>
                                </td>
                            </tr>
                            <tr class="odd even">
                                <td><b>Описание <i class="red">*</i></b></td>
                                <td>
                                    <textarea class="form-control" v-model="permission.description"></textarea>
                                </td>
                            </tr>


                            <tr class="odd even">
                                <td>
                                    <button type="button" class="btn btn btn-danger" @click="clear">Очистить</button>
                                </td>
                                <td>
                                    <button
                                            type="submit"
                                            class="btn btn-success float-right">Сохранить</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['p_permission_id'],
        name: "permission",
        data () {
            return {
                permission: {
                    id:          0,
                    name:        '',
                    description: ''
                },
            }
        },
        created(){

            this.getPermission(this.p_permission_id, true);
        },
        methods:{
            getPermission(permission_id, load){
                if(permission_id)
                {
                    if(load)
                        var loader = this.$loading.show({
                            // Optional parameters
                            container: this.fullPage ? null : this.$refs.formContainer,
                            canCancel: false,
                            onCancel: this.onCancel,
                        });

                    axios.get('/admin/permissions/' + permission_id).then((res)=>{
                        var permission = res.data;
                        this.permission.id          = permission.id;
                        this.permission.name        = permission.name;
                        this.permission.description = permission.description;

                        if(load)
                            loader.hide();
                    });
                }
            },
            clear(){
                this.permission.name = '';

            },
            save(event){
                event.preventDefault();

                    let loader = this.$loading.show({
                        // Optional parameters
                        container: this.fullPage ? null : this.$refs.formContainer,
                        canCancel: false,
                        onCancel: this.onCancel,
                    });



                    axios.post('/admin/permissions', this.permission).then((res)=>{
                        loader.hide();

                        var permission_id = res.data;
                        if(permission_id){

                            this.getPermission(permission_id);
                            this.$emit('permission_id', permission_id);
                            this.$notify({
                                group: 'foo',
                                title: 'Права доступа сохранена'
                            });

                        }else{
                            alert('Error');
                        }

                    });

            }
        },
        watch: {
            p_permission_id: {
                handler: function (val, oldVal) {
                    if(val)
                        this.getPermission(val, true);
                    else{
                        this.permission = {
                            id: 0,
                            name: '',
                            description: ''
                        };
                    }
                },
                deep: true
            },
        },
    }
</script>