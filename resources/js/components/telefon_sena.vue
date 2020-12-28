<template>
    <div>
        <div class="accordion" id="accordionExample" v-for="(category, category_key) in categories">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-left" type="button" @click="showCategory(category, category_key)">
                            {{ category.name_short }}
                        </button>
                    </h2>
                </div>
                <div class="collapse" :class="{ 'show': category_id_active == category.id }">

                    <div class="card-body">



                        <div class="accordion" v-for="(product, product_key) in category.products">
                            <div class="card">
                                <div>
                                    <h2 class="mb-0">
                                        <button class="btn btn-block text-left" type="button" @click="showProduct(product, product_key, category_key)">
                                            {{ product.name_short }} - {{ product.price_type }} {{ product.price }}
                                        </button>
                                    </h2>
                                </div>
                                <div class="collapse" :class="{ 'show': product_id_active == product.id }">
                                    <div class="card-body1">

                                         <br/>
                                             <input type="number"
                                                   placeholder="Цена"
                                                    style="width: 100px"
                                                   v-model="product.price"
                                                   @change="updatePrice($event, product.id)"
                                                   class="form-control"/>

                                            <input type="text"
                                                   placeholder="от, до или пусто"
                                                   v-model="product.price_type"
                                                   @change="updateType($event, product.id)"
                                                   class="form-control"/>
                                        <br/>

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr v-for="product2 in product.children">
                                                    <td>
                                                        {{ product2.name_catalog ? product2.name_catalog : product2.name }}
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="number"
                                                                       placeholder="Цена"
                                                                       v-model="product2.price"
                                                                       @change="updatePrice($event, product2.id)"
                                                                       class="form-control"/>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text"
                                                                       placeholder="от, до или пусто"
                                                                       v-model="product2.price_type"
                                                                       @change="updateType($event, product2.id)"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                categories: [],
                category_id_active: 0,
                product_id_active: 0,
            }
        },
        created(){
            axios.get('/telefon-sena/categories').then((res)=>{
                this.categories = res.data;
            });
        },
        methods:{
            showCategory(category, category_key){


                if(this.category_id_active == category.id)
                {
                    this.category_id_active = 0;
                }else{
                    this.category_id_active = category.id;

                    if(!category.categories)
                    {
                        axios.get('/telefon-sena/products?category_id=' + category.id).then((res)=>{
                            this.$set(this.categories[category_key], 'products', res.data);
                        });
                    }
                }
            },
            showProduct(product, product_key, category_key){

                if(this.product_id_active == product.id)
                {
                    this.product_id_active = 0;
                }else {
                    this.product_id_active = product.id;

                    if(!product.children)
                    {
                        var params = {
                            product_id: product.id
                        };
                        axios.get('/telefon-sena/children', { params:  params }).then((res) => {
                            this.$set(this.categories[category_key].products[product_key], 'children', res.data);
                        });
                    }
                }
            },
            updatePrice(event, product_id){

                var params = {
                    product_price: event.target.value,
                    product_id:    product_id,
                };

                axios.get('/telefon-sena/update-price', { params:  params }).then((res) => {
                    console.log(res.data);
                });
            },
            updateType(event, product_id){
                var params = {
                    price_type: event.target.value,
                    product_id: product_id,
                };

                axios.get('/telefon-sena/update-price-type', { params:  params }).then((res) => {
                    console.log(res.data);
                });
            }
        }

    }
</script>
