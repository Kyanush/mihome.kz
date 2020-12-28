<template>
    <span>
        <!--  :disabled="item.order_product" -->
        <select :class="p_class" v-model="value2">
            <option v-for="(item, key) in stock" :value="item.id" :disabled="item.order_products_count >= item.quantity">
                {{ key + 1}}:
                Кол-во: {{ item.quantity }},
                Цена: {{ item.price }}
                {{ item.comment ? ', Комент: ' + item.comment : ''}}

                {{ item.order_products_count > 0 ? ', Продано: ' + item.order_products_count : '' }}

            </option>
        </select>
    </span>
</template>

<script>
    export default {
        props: ['value', 'product_id', 'p_class'],
        name: 'categories',
        data () {
            return {
                stock: [],
                value2: ''
            }
        },
        methods:{
        },
        created(){

            this.value2 = this.value;

            axios.get('/admin/product-stock/' + this.product_id).then((res)=>{
                this.stock = res.data;
            });
        },
        watch: {
            value2: {
                handler: function (val, oldVal) {
                    this.$emit('input', val ? val : '');
                },
                deep: true
            }
        },
    }
</script>