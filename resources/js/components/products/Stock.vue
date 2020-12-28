<template>
    <div class="box">

            <h1 class="text-center">{{ product ? product.name : '' }}</h1>

            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th width="20"></th>
                        <th>Кол-во: {{ quantitySum }}</th>
                        <th>IMEI</th>
                        <th>Поступление/поставщик</th>
                        <th>Цена поступление</th>
                        <th>Количество продажи</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in product_stock">
                        <td width="20">{{ key + 1 }}</td>
                        <td>
                            <input type="number" required v-model="item.quantity" class="form-control quantity"/>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text"  v-model="item.imei" class="form-control"/>
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-search" @click="barcode(key)">
                                      <i class="fa fa-barcode" aria-hidden="true"></i>
                                  </button>
                                </span>
                            </div>
                        </td>
                        <td>
                            {{ item.arrival ? item.arrival.name : ''}}
                            &nbsp;
                            <button @click="showArrival(key)">...</button>
                        </td>
                        <td>
                            <input style="width: 100px;" type="number" required v-model="item.price" class="form-control"/>
                        </td>
                        <td>
                            {{ item.order_products_count > 0 ? item.order_products_count : '' }}
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" @click="select(item.id)" v-if="item.id > 0 && item.order_products_count != item.quantity">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Выбирать
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th width="20"></th>
                        <th>Кол-во: {{ quantitySum }}</th>
                        <th>IMEI</th>
                        <th>Дата</th>
                        <th>Цена поступление</th>
                        <th>Продажа</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>
                            <button type="button" class="btn btn-primary" @click="add">
                               <i class="fa fa-plus"></i>
                                Новое
                            </button>
                        </th>
                        <th>
                            <button type="button" class="btn btn-success" @click="save">
                                <i class="fa fa-plus"></i>
                                Сохранить
                            </button>
                        </th>
                    </tr>
                </tfoot>
            </table>

        <rightSidePopup  ref="right_side_popup" :title="'Поступление/поставщик'">
            <stockArrival @arrival="selectArrival"/>
        </rightSidePopup>

    </div>
</template>


<script>

    import stockArrival   from './StockArrival';
    import rightSidePopup from '../plugins/RightSidePopup';

    export default {
        props:['product_id'],
        components:{
            stockArrival,
            rightSidePopup
        },
        data () {
            return {
                datetimepicker: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    locale: 'ru'
                },
                product_stock: [],

                product: null,
                stock_index: -1
            }
        },
        created() {
           this.getProductStock();
        },
        methods:{
            selectArrival(arrival){

                this.$set(this.product_stock[this.stock_index], 'arrival',    arrival);
                this.$set(this.product_stock[this.stock_index], 'arrival_id', arrival.id);

                this.$refs.right_side_popup.active = false;
            },
            showArrival(index){
                this.$refs.right_side_popup.active = true;
                this.stock_index = index;
            },
            select(id){
                this.$emit('select_stock_id', id);
            },
            barcode(index){
                axios.get('/admin/barcode').then((res)=>{
                    var data = res.data;
                    this.$set(this.product_stock[index], 'imei', data);
                });
            },
            save(){
                axios.post('/admin/product-stock', this.product_stock).then((res)=>{
                    this.getProductStock();

                    this.$helper.swalSuccess('Успешно');
                });
            },
            add(){
                this.product_stock.push({
                    id: 0,
                    product_id: this.product_id,
                    quantity:   1,
                    arrival_id: '',
                    price: 0,
                });

            },
            getProductStock(){
                axios.get('/admin/product-stock/' + this.product_id).then((res)=>{
                    this.product_stock = res.data ? res.data : [];
                });
            }
        },
        computed:{
            quantitySum(){
                var sum = 0;
                this.product_stock.forEach(e => {
                    sum += e.quantity;
                });
                return sum
            }
        },
        watch: {
            product_id: {
                handler: function (val, oldVal) {
                    this.getProductStock();

                    axios.get('/admin/product-view/' + this.product_id).then((res)=>{
                        var data    = res.data;
                        console.log(data.product);
                        this.product = data.product;
                    });

                },
                deep: true
            }
        }
    }
</script>

<style>
    .date, .quantity{
        width: 95px;
    }
</style>