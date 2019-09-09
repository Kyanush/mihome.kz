<template>
    <div class="col-md-8 col-md-offset-2">

        <history_back></history_back>

        <form v-on:submit="userSave">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ user.id ? 'Редактировать' : 'Создать пользователь'}}</h3>
                </div>

                <div class="box-body row">

                    <div class="tab-container col-md-12">
                        <div class="nav-tabs-custom" id="form_tabs">
                            <ul class="nav nav-tabs">
                                <li v-bind:class="{'active' : tab_active == 'tab_general'}" @click="setTab('tab_general')">
                                    <a>Общий</a>
                                </li>
                                <li v-bind:class="{'active' : tab_active == 'tab_addresses'}" @click="setTab('tab_addresses')">
                                    <a>Адресы</a>
                                </li>
                                <li v-bind:class="{'active' : tab_active == 'tab_companies'}" @click="setTab('tab_companies')">
                                    <a>Компании</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content col-md-12">
                        <div v-bind:class="{'active' : tab_active == 'tab_general'}" role="tabpanel" class="tab-pane" id="tab_general">

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
                            <div class="form-group col-md-6" v-bind:class="{'has-error' : IsError('user.role_id')}">
                                <label>Роль <span class="red">*</span></label>
                                <select v-model="user.role_id" class="form-control">
                                    <option value="1" v-for="role in roles_list" v-bind:value="role.id">
                                        {{ role.description }}
                                    </option>
                                </select>
                                <span v-if="IsError('user.role_id')" class="help-block" v-for="e in IsError('user.role_id')">
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
                        </div>
                        <div v-bind:class="{'active' : tab_active == 'tab_addresses'}" role="tabpanel" class="tab-pane" id="tab_addresses">
                            <div class="row">
                                <div class="col-md-12">
                                    <a @click="showAddAddress" class="btn btn-primary add-address-btn">
                                        <i class="fa fa-plus"></i> Добавить адрес
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Адрес</th>
                                        <th>Город</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in user.addresses" v-bind:class="{'is-delete' : item.is_delete == 1}">
                                        <td class="vertical-align-middle">{{ item.address }}</td>
                                        <td class="vertical-align-middle">{{ item.city }}</td>
                                        <td class="vertical-align-middle">
                                                    <span class="btn btn-xs btn-default" @click="editAddress(item, index)">
                                                        <i class="fa fa-edit"></i> Изменить
                                                    </span>
                                            <span class="btn btn-xs btn-default" @click="deleteAddress(index)">
                                                         <span v-if="item.is_delete == 0"><i class="fa fa-remove" ></i> Удалить</span>
                                                         <span v-else><i class="fa green fa-history"></i> Восстановить</span>
                                                    </span>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-bind:class="{'active' : tab_active == 'tab_companies'}" role="tabpanel" class="tab-pane" id="tab_companies">
                            <div class="row">
                                <div class="col-md-12">
                                    <a @click="showAddCompany" class="btn btn-primary add-address-btn">
                                        <i class="fa fa-plus"></i> Добавить компанию
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Название компании</th>
                                        <th>Адрес</th>
                                        <th>Страна</th>
                                        <th>Город</th>
                                        <th>Информация о компании<br/>реквизиты банка и.д.</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in user.companies" v-bind:class="{'is-delete' : item.is_delete == 1}">
                                        <td class="vertical-align-middle">{{ item.name }}</td>
                                        <td class="vertical-align-middle">{{ item.address }}</td>
                                        <td class="vertical-align-middle">{{ item.county }}</td>
                                        <td class="vertical-align-middle">{{ item.city }}</td>
                                        <td class="vertical-align-middle">{{ item.info }}</td>

                                        <td class="vertical-align-middle">
                                            <span class="btn btn-xs btn-default" @click="editCompany(item, index)">
                                                <i class="fa fa-edit"></i> <!--Изменить-->
                                            </span>
                                            <span class="btn btn-xs btn-default" @click="deleteCompany(index)">
                                                 <span v-if="item.is_delete == 0"><i class="fa fa-remove" ></i> <!--Удалить--></span>
                                                 <span v-else><i class="fa green fa-history"></i> <!--Восстановить--></span>
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!-- /.box-body -->




                <div class="box-footer">
                    <div  class="form-group">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success" @click="setMethodRedirect('save_and_back')">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Сохранить и назад</span>
                            </button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">▼</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a @click="setMethodRedirect('save_and_continue')">
                                        <button type="submit" class="btn-transparent">Сохранить и продолжить</button>
                                    </a>
                                </li>
                                <li>
                                    <a @click="setMethodRedirect('save_and_new')">
                                        <button type="submit" class="btn-transparent">Сохранить и новый</button>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <router-link :to="{path: '/users'}" class="btn btn-default">
                            <span class="fa fa-ban"></span> &nbsp;
                            Отменить
                        </router-link>



                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </form>



        <div class="add-address-modal modal fade" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-plus"></i>
                            {{ address_save.index == -1 ? 'Добавить адрес' : 'Изменить адрес'}}
                        </h4>
                    </div>
                    <div id="add-address-fields">
                        <form v-on:submit="saveAddress">
                            <div class="modal-body">
                                <div class="form-group" v-bind:class="{'has-error' : IsError('address_save.address')}">
                                    <label>Адрес <span class="red">*</span></label>
                                    <input v-model="address_save.address" type="text" class="form-control" required/>
                                    <span v-if="IsError('address_save.address')" class="help-block" v-for="e in IsError('address_save.address')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error' : IsError('address_save.city')}">
                                    <label>Город <span class="red">*</span></label>
                                    <input v-model="address_save.city" type="text" class="form-control" required/>
                                    <span v-if="IsError('address_save.city')" class="help-block" v-for="e in IsError('address_save.city')">
                                        {{ e }}
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary btn-add-address">{{ address_save.index == -1 ? 'Добавить' : 'Изменить'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>







        <div class="save-company-model modal fade" role="dialog" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="fa fa-plus"></i>
                            {{ company_save.index == -1 ? 'Добавить компанию' : 'Изменить компанию'}}
                        </h4>
                    </div>
                    <div>
                        <form v-on:submit="saveCompany">
                            <div class="modal-body">

                                <div class="form-group" v-bind:class="{'has-error' : IsError('company_save.name')}">
                                    <label>Название компании <span class="red">*</span></label>
                                    <input v-model="company_save.name" type="text" class="form-control" required/>
                                    <span v-if="IsError('company_save.name')" class="help-block" v-for="e in IsError('company_save.name')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error' : IsError('company_save.address')}">
                                    <label>Адрес <span class="red">*</span></label>
                                    <input v-model="company_save.address" type="text" class="form-control" required/>
                                    <span v-if="IsError('company_save.address')" class="help-block" v-for="e in IsError('company_save.address')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error' : IsError('company_save.county')}">
                                    <label>Страна <span class="red">*</span></label>
                                    <input v-model="company_save.county" type="text" class="form-control" required/>
                                    <span v-if="IsError('company_save.county')" class="help-block" v-for="e in IsError('company_save.county')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error' : IsError('company_save.city')}">
                                    <label>Город <span class="red">*</span></label>
                                    <input v-model="company_save.city" type="text" class="form-control" required/>
                                    <span v-if="IsError('company_save.city')" class="help-block" v-for="e in IsError('company_save.city')">
                                        {{ e }}
                                    </span>
                                </div>
                                <div class="form-group" v-bind:class="{'has-error' : IsError('company_save.info')}">
                                    <label>Информация о компании/реквизиты банка и.д. <span class="red">*</span></label>
                                    <textarea v-model="company_save.info" type="text" class="form-control" required></textarea>
                                    <span v-if="IsError('company_save.info')" class="help-block" v-for="e in IsError('company_save.info')">
                                        {{ e }}
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-primary btn-add-address">{{ company_save.index == -1 ? 'Добавить' : 'Изменить'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



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
                user: this.userDefaultValues(),
                address_save: {
                    index: -1,
                    address: '',
                    city: '',
                    comment: '',
                },
                company_save: {
                    index: -1,
                    name: '',
                    address: '',
                    county: '',
                    city: '',
                    info: ''
                },
                roles_list: []
            }
        },
        created(){
            if(this.$route.params.id > 0)
            {
                axios.get('/admin/user-view/' + this.$route.params.id).then((res)=>{
                        var data = res.data;

                        this.user.id         = data.id;
                        this.user.name       = data.name;
                        this.user.surname    = data.surname;
                        this.user.email      = data.email;
                        this.user.phone      = data.phone;
                        this.user.role_id    = data.role_id;
                        this.user.active     = data.active;
                        this.user.addresses  = data.addresses;
                        this.user.companies  = data.companies;

                });
            }

            axios.get('/admin/roles-list').then((res)=>{
                this.roles_list =  res.data;
            });

            setTimeout(()=>{
                $(".phone-mask").mask("+7(999) 999-9999");
            },2000);

        },
        methods:{
            showAddAddress(){
                this.address_save.index   = -1;
                this.address_save.address = '';
                this.address_save.city    = '';
                this.address_save.comment = '';
                $('.add-address-modal').modal('show');
            },
            saveAddress(event){
                event.preventDefault();

                var index = this.address_save.index;

                if(index != -1)
                {
                    this.user.addresses[index].address = this.address_save.address;
                    this.user.addresses[index].city    = this.address_save.city;
                    this.user.addresses[index].comment = this.address_save.comment;
                }else{
                    this.user.addresses.push({
                        id        : 0,
                        address   : this.address_save.address,
                        city      : this.address_save.city,
                        comment   : this.address_save.comment,
                        is_delete : 0
                    });
                }
                $('.add-address-modal').modal('hide');
            },
            editAddress(item, index){
                this.address_save.index   = index;
                this.address_save.address = item.address;
                this.address_save.city    = item.city;
                this.address_save.comment = item.comment;
                $('.add-address-modal').modal('show');
            },
            deleteAddress(index){
                if(this.user.addresses[index].id > 0)
                    this.$set(this.user.addresses[index], 'is_delete', !this.user.addresses[index].is_delete);
                else
                    this.$delete(this.user.addresses, index);
            },
            showAddCompany(){
                this.company_save.index   = -1;
                this.company_save.name    = '';
                this.company_save.address = '';
                this.company_save.county  = '';
                this.company_save.city    = '';
                this.company_save.info    = '';
                $('.save-company-model').modal('show');
            },
            saveCompany(event){
                event.preventDefault();

                var index = this.company_save.index;

                if(index != -1)
                {
                    this.user.companies[index].name    = this.company_save.name;
                    this.user.companies[index].address = this.company_save.address;
                    this.user.companies[index].county  = this.company_save.county;
                    this.user.companies[index].city    = this.company_save.city;
                    this.user.companies[index].info    = this.company_save.info;
                }else{
                    this.user.companies.push({
                        id        : 0,
                        name      : this.company_save.name,
                        address   : this.company_save.address,
                        county    : this.company_save.county,
                        city      : this.company_save.city,
                        info      : this.company_save.info,
                        is_delete : 0
                    });
                }
                $('.save-company-model').modal('hide');
            },
            editCompany(item, index){
                this.company_save.index   = index;
                this.company_save.name    = item.name;
                this.company_save.address = item.address;
                this.company_save.county  = item.county;
                this.company_save.city    = item.city;
                this.company_save.info    = item.info;
                $('.save-company-model').modal('show');
            },
            deleteCompany(index){
                if(this.user.companies[index].id > 0)
                    this.$set(this.user.companies[index], 'is_delete', !this.user.companies[index].is_delete);
                else
                    this.$delete(this.user.companies, index);
            },





















            setMethodRedirect(value){
                this.method_redirect = value;
            },
            setTab(tab){
                this.tab_active = tab;
            },
            userDefaultValues(){
                return {
                    id: this.$route.params.id ? this.$route.params.id : 0,
                    name: '',
                    surname: '',
                    email: '',
                    phone: '',
                    password: '',
                    password_confirmation: '',
                    role_id: 0,
                    active: 1,
                    addresses: [],
                    companies: []
                };
            },
            userSave(event){
                event.preventDefault();
                this.SetErrors(null);

                axios.post('/admin/user-save', {user: this.user}).then((res)=>{
                    if(res.data)
                    {
                        this.$helper.swalSuccess(this.user.id ? 'Успешно изменено' : 'Успешно создано');

                        if(this.method_redirect == 'save_and_back'){
                            history.back();

                        }else if(this.method_redirect == 'save_and_continue'){
                            if(!this.user.id)
                            {
                                this.user.id = res.data;
                                this.$router.push('/users/edit/' + this.user.id);
                            }
                        }else if(this.method_redirect == 'save_and_new'){
                            window.location = '/admin/users/create';
                            this.user = this.userDefaultValues();
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