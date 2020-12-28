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
                            <div class="scroll-catalog">
                                <Categories v-model="filter.category_id" :returnKey="'id'" :multiple="false"></Categories>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered ">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Сортировка:</label>
                                        </td>
                                        <td>
                                            <select class="form-control" v-model="filter.sort">
                                                <option value="price-asc">Цена 1..10</option>
                                                <option value="price-desc">Цена 10..1</option>
                                                <option value="name-asc">Название а..я</option>
                                                <option value="name-desc">Название я..а</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Поступление:</label>
                                        </td>
                                        <td>
                                            <select class="form-control" v-model="filter.arrival_id">
                                                <option v-for="item_arrival in arrival" :value="item_arrival.id">
                                                    {{ item_arrival.name }}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <button class="btn btn-primary pull-right" @click="reportDownload" >
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                            Загрузить отчет
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success float-right" @click="getProducts">
                                            <i aria-hidden="true" class="fa fa-search"></i>
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


        <div class="table-responsive">
            <table class="table table-bordered table-panel">
            <thead>

                <tr>
                    <td width="40"><b>№</b></td>
                    <td width="80"><b>Фото</b></td>
                    <td width="250">
                        <b>Товар</b>
                    </td>
                    <td width="80"><b>Цена</b></td>
                    <td width="80"><b>Поступление</b></td>
                    <td width="50"><b>Продажа</b></td>
                    <td width="50"><b>Остаток</b></td>
                    <td width="100"><b>Остаток<br/>продажи</b></td>
                    <td width="100"><b>Остаток<br/>себестоимость</b></td>
                    <td width="100"><b>Прыбол продажи</b></td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>{{ totalBalanceStock  }}</td>
                    <td>{{ totalBalanceSold }}</td>
                    <td>{{ totalBalanceBalance }}</td>

                    <td>{{ remaining_sale_total }}</td>
                    <td>{{ cost_price_total }}</td>
                    <td>{{ profit_total }}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products.data">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <router-link :to="{ name: 'product_edit', params: { product_id: product.id} }">
                            <img v-bind:src="product.path_photo" width="100" class="img"/>
                        </router-link>
                    </td>
                    <td  :style="{ 'background-color': product.balance.stock == product.balance.sold ? '#9e9e9e' : ''}">
                        {{ product.name }}
                        <br/>
                        <span v-html="product.status.class + ' ' + product.status.name"></span>
                   </td>
                    <td><b>{{ product.format_price }}</b></td>
                    <td title="Поступление" style="background-color: #ababab;font-weight: bold;">{{ product.balance.stock }}</td>
                    <td title="Продажа" style="background-color: #4aa90b;font-weight: bold;">{{ product.balance.sold }}</td>
                    <td title="Остаток" style="background-color: #d60b00;font-weight: bold;">{{ product.balance.balance }}</td>
                    <td title="Остаток продажи" style="background-color: #9C27B0;font-weight: bold;">
                        {{ product.balance.remaining_sale.format }}
                    </td>
                    <td title="Остаток себестоимость" style="background-color: #FFC107;font-weight: bold;">
                        {{ product.balance.cost_price.format }}
                    </td>
                    <td title="Прыбол продажи" style="background-color: #4aa90b;font-weight: bold;">
                        {{ product.balance.profit.format }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ totalBalanceStock  }}</td>
                    <td>{{ totalBalanceSold }}</td>
                    <td>{{ totalBalanceBalance }}</td>
                    <td>{{ remaining_sale_total }}</td>
                    <td>{{ cost_price_total }}</td>
                    <td>{{ profit_total }}</td>
                </tr>
            </tfoot>
        </table>
        </div>

    </div>
</template>

<script>
    import Categories     from '../plugins/Categories';

    export default {
        components:{
             Categories
        },
        data () {
            return {
                products: [],
                filter:{
                    category_id: this.$route.query.category_id ? this.$route.query.category_id : 1522,
                    perPage:     10000000,
                    sort:        this.$route.query.sort ? this.$route.query.sort : 'name-asc',
                    is_stock:    true,
                    arrival_id:  this.$route.query.arrival_id ? this.$route.query.arrival_id : '',
                },
                arrival: []
            }
        },
        methods:{
            getProducts(){

                var loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: false,
                    onCancel: this.onCancel,
                });

                var params = this.filter;

                this.$router.push({query: params});

                axios.post('/admin/products-list', params).then((res)=>{
                    this.products = res.data;
                    loader.hide();
                });

            },
            reportDownload(){

                    var query = this.$route.query;

                    let routeData = this.$router.resolve({
                        path: '/product-stock-report',
                        query:  this.filter
                    });

                    window.open(routeData.href, '_blank');

            },

        },
        created() {

            axios.get('/admin/product-stock-arrival').then((res)=>{
                var data = res.data;
                this.arrival = data;
            });

        },
        computed: {
            remaining_sale_total(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += product.balance.remaining_sale.sum;
                    });

                if(total)
                    total = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ');

                return total;
            },
            cost_price_total(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += product.balance.cost_price.sum;
                    });

                if(total)
                    total = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ');

                return total;
            },
            profit_total(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += product.balance.profit.sum;
                    });

                if(total)
                    total = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ');

                return total;
            },
            totalBalanceStock(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += parseInt(product.balance.stock);
                    });

                return total;
            },
            totalBalanceSold(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += parseInt(product.balance.sold);
                    });

                return total;
            },
            totalBalanceBalance(){
                var total = 0

                if(this.products.data)
                    this.products.data.forEach(function (product) {
                        total += parseInt(product.balance.balance);
                    });

                return total;
            },


        }
    }
</script>

<style>
    .table-panel>thead>tr, .table-panel>thead>tr>th, .table-panel>tbody>tr>th, .table-panel>tfoot>tr>th, .table-panel>thead>tr>td, .table-panel>tbody>tr>td, .table-panel>tfoot>tr>td {
        border: 1px solid #837b7b!important;
    }
</style>