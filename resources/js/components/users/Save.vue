<template>
    <div class="col-md-8 col-md-offset-2">

        <history_back></history_back>

        <form v-on:submit="userSave">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ user.id ? 'Редактировать' : 'Создать пользователь'}}</h3>
                </div>

                <div class="box-body row">
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.name')}">
                                <label>Имя <span class="red">*</span></label>
                                <input v-model="user.name" type="text" class="form-control">
                                <span v-if="IsError('user.name')" class="help-block" v-for="e in IsError('user.name')">
                                        {{ e }}
                                    </span>
                            </div>
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.surname')}">
                                <label>Фамилия</label>
                                <input v-model="user.surname" type="text" class="form-control">
                                <span v-if="IsError('user.surname')" class="help-block" v-for="e in IsError('user.surname')">
                                        {{ e }}
                                    </span>
                            </div>
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.email')}">
                                <label>E-mail <span class="red">*</span></label>
                                <input v-model="user.email" type="text" class="form-control">
                                <span v-if="IsError('user.email')" class="help-block" v-for="e in IsError('user.email')">
                                         {{ e }}
                                    </span>
                            </div>
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.phone')}">
                                <label>Телефон</label>

                                <input
                                        @blur="user.phone = $event.target.value;"
                                        v-model="user.phone"
                                        type="text"
                                        class="form-control phone-mask"/>

                                <span v-if="IsError('user.phone')" class="help-block" v-for="e in IsError('user.phone')">
                                   {{ e }}
                                </span>
                            </div>
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.password')}">
                                <label>Пароль <span v-if="user.id == 0" class="red">*</span></label>
                                <input v-model="user.password" type="password" class="form-control">
                                <span v-if="IsError('user.password')" class="help-block" v-for="e in IsError('user.password')">
                                         {{ e }}
                                    </span>
                            </div>
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.password_confirmation')}">
                                <label>Подтверждение пароля <span v-if="user.id == 0" class="red">*</span></label>
                                <input v-model="user.password_confirmation" type="password" class="form-control">
                                <span v-if="IsError('user.password_confirmation')" class="help-block" v-for="e in IsError('user.password_confirmation')">
                                         {{ e }}
                                    </span>
                            </div>

                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.active')}">
                                <label>Статус <span class="red">*</span></label>
                                <select v-model="user.active" class="form-control">
                                    <option value="1">Активен</option>
                                    <option value="0">Неактивен</option>
                                </select>
                                <span v-if="IsError('user.active')" class="help-block" v-for="e in IsError('user.active')">
                                     {{ e }}
                                </span>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Роль <span class="red">*</span></label>
                                <select v-model="user.role_id" class="form-control">
                                    <option :value="role.id" v-for="role in roles_list">
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">

                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr class="odd even">
                                            <td><b>Переопределить разрешения</b></td>
                                            <td>
                                                <div class="input-group">
                                                    <input class="form-control" v-model="permission_search" placeholder="Поиск права"/>
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-danger" type="button" title="Очистить" @click="permission_search = ''">
                                                        <i class="fa fa-remove" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="odd even">
                                            <td></td>
                                            <td>
                                                <ul class="ul-li-no-style">
                                                    <li v-for="permission in permissions" v-show="permission.description.toLowerCase().indexOf(permission_search.toLowerCase()) > -1">
                                                        <label class="">
                                                            <input checked="checked" v-model="permission_ids" type="checkbox" :value="permission.id"/>
                                                            - {{ permission.description }}
                                                        </label>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>



                </div><!-- /.box-body -->




                <div class="box-footer">
                    <div  class="form-group">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success" @click="setMethodRedirect('save_and_continue')">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и продолжить</span>
                            </button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">▼</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a @click="setMethodRedirect('save_and_back')">
                                        <button type="submit" class="btn-transparent">Сохранить и назад</button>
                                    </a>
                                </li>
                                <li>
                                    <a @click="setMethodRedirect('save_and_new')">
                                        <button type="submit" class="btn-transparent">Сохранить и новый</button>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <router-link :to="{ name: 'users' }" class="btn btn-default">
                            <span class="fa fa-ban"></span> &nbsp;
                            Отменить
                        </router-link>



                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </form>


    </div>
</template>


<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';

    export default {
        data () {
            return {
                tab_active: 'tab_general',
                method_redirect: 'save_and_back',
                user: {
                        id: this.$route.params.user_id ? this.$route.params.user_id : 0,
                        name: '',
                        surname: '',
                        email: '',
                        phone: '',
                        password: '',
                        password_confirmation: '',
                        active: 1
                },
                roles_list: [],

                permission_ids: [],
                permission_search: '',
                permissions: []
            }
        },
        created(){


            axios.get('/admin/permissions?perPage=100&sort_column=description&sort_type=ASC').then((res)=>{
                this.permissions = res.data.data;
            });


            if(this.$route.params.user_id > 0)
            {
                axios.get('/admin/user-view/' + this.$route.params.user_id).then((res)=>{
                        var data = res.data;
                        var user = data.user;

                        console.log(data);

                        this.user.id         = user.id;
                        this.user.name       = user.name;
                        this.user.surname    = user.surname;
                        this.user.email      = user.email;
                        this.user.phone      = user.phone;
                        this.user.active     = user.active;
                        this.user.role_id    = user.role_id;

                        this.permission_ids = data.permission_ids;

                });
            }

            axios.get('/admin/roles-list').then((res)=>{
                this.roles_list =  res.data;
            });

            setTimeout(()=>{
                $(".phone-mask").mask("+7(999)999-99-99");
            },2000);

        },
        methods:{
            setMethodRedirect(value){
                this.method_redirect = value;
            },
            setTab(tab){
                this.tab_active = tab;
            },
            userSave(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/user-save', {

                    user: this.user,
                    permission_ids: this.permission_ids

                }).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.user.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.user.id)
                            {
                                this.user.id = res.data;
                                this.$router.push({ name: 'user_edit', params: { user_id: this.user.id }});
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            this.$router.go({
                                name: 'user_create',
                            });
                        }
                    }
                });

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
