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
                                <th>Товар</th>
                                <th>Фото товара</th>
                                <th>Дата начала</th>
                                <th>Дата окончания срока</th>
                                <th>Тип скидки</th>
                                <th>Снижение</th>
                                <th>Старая цена</th>
                                <th>Сниженная цена</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd even" v-for="(item, index) in specific_prices.data" v-bind:class="{'opacity': item.product.format_price == item.product.reduced_price}">
                                <td>{{ item.id }}</td>
                                <td>
                                    <router-link :to="{ path: '/products/edit/' + item.product.id}">
                                        {{ item.product.name }}
                                    </router-link>
                                </td>
                                <img v-bind:src="item.product.path_photo" width="70" class="img"/>
                                <td>{{ item.start_date }}</td>
                                <td>{{ item.expiration_date }}</td>
                                <td>{{ item.discount_type == 'percent' ? 'Процент' : 'Сумма' }}</td>
                                <td>{{ item.reduction }}</td>
                                <td>
                                    <del v-if="item.product.format_price != item.product.reduced_price">{{ item.product.format_price }}</del>
                                    <span v-else>
                                        {{ item.product.format_price }}
                                    </span>
                                </td>
                                <td>{{ item.product.reduced_price }}</td>
                                <td>
                                    <router-link :to="{ path: '/products/edit/' + item.product_id}" class="btn btn-xs btn-default">
                                        <i class="fa fa-edit"></i> Изменить
                                    </router-link>

                                    <a class="btn btn-xs btn-default" @click="specificPriceDelete(item, index)">
                                        <i class="fa fa-remove"></i> Удалить
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Товар</th>
                                <th>Фото товара</th>
                                <th>Дата начала</th>
                                <th>Дата окончания срока</th>
                                <th>Тип скидки</th>
                                <th>Снижение</th>
                                <th>Старая цена</th>
                                <th>Сниженная цена</th>
                                <th>Действия</th>
                            </tr>
                        </tfoot>
               </table>
        </div>

        <div class="text-center">
            <paginate
                    v-if="specific_prices.last_page > 1"
                    v-model="specific_prices.current_page"
                    :page-count="specific_prices.last_page"
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
                specific_prices: [],
                filter:{
                    page:   (this.$route.query.page   ? this.$route.query.page : 1),
                    search: (this.$route.query.search ? this.$route.query.search : '')
                }
            }
        },
        watch: {
            filter: {
                handler: function (val, oldVal) {
                    this.specificPriceList();
                },
                deep: true
            }
        },
        created(){
            this.specificPriceList();
        },
        methods:{
            SetPage(page){
                this.filter.page = page;
            },
            specificPriceDelete(item, index){
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
                        axios.post('/admin/specific-price-delete/' + item.id).then((res)=>{
                            if(res.data)
                            {
                                this.$helper.swalSuccess('Успешно удален');
                                this.$delete(this.specific_prices.data, index);
                            }
                        });
                    }
                });
            },
            specificPriceList(){
                var params = {};
                if(this.filter.page > 1 && !this.filter.search)
                    params['page'] = this.filter.page;

                if(this.filter.search)
                    params['search'] = this.filter.search;

                axios.get('/admin/specific-prices-list', {params:  params}).then((res)=>{
                    this.specific_prices = res.data;
                    this.$router.push({query: params});
                });
            }
        }

    }
</script>
