<template>
    <div class="box">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Поступление/поставщик</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in stock_arrival">
                        <td width="20">{{ key + 1 }}</td>
                        <td>
                            <input type="text" required v-model="item.name" class="form-control"/>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" @click="select(item)" v-if="item.id > 0">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Выбирать
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Номер</th>
                        <th>Поступление/поставщик</th>
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
    </div>
</template>


<script>
    export default {
        props:['product_id'],
        data () {
            return {
                stock_arrival: [],
            }
        },
        created() {
           this.getArrival();
        },
        methods:{
            select(item){
                this.$emit('arrival', item);
            },
            getArrival(){
                axios.get('/admin/product-stock-arrival').then((res)=>{
                    var data = res.data;
                    this.stock_arrival = data;
                });
            },
            save(){
                axios.post('/admin/product-stock-arrival', this.stock_arrival).then((res)=>{
                    this.getArrival();

                    this.$helper.swalSuccess('Успешно');
                });
            },
            add(){
                this.stock_arrival.push({
                    id: 0,
                    name: ''
                });

            }
        },
    }
</script>