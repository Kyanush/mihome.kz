<template>
    <span>
        <div class="input-group">
            <input placeholder="Поиск..." type="text" class="form-control" v-model="search"/>
            <span class="input-group-addon btn" @click="clearSearch">
              <i class="fa fa-remove red"></i>
            </span>
        </div>

        <br/>

        <div class="input-group">
            <a @click="search='Ремонт телефонов'">Ремонт телефонов</a>
            &nbsp;
            <a @click="search='Ремонт самокатов'">Ремонт самокатов</a>
        </div>

        <br/>

        <table v-if="results.length > 0" class="table">
            <tbody>
                <tr v-for="item in results">
                    <td width="100px">
                        <router-link target="_blank" :to="{ name: 'product_edit', params: { product_id: item.product.id} }" title="Изменить">
                            <img :src="item.photo_path" width="100px"/>
                        </router-link>
                    </td>
                    <td>
                         <a @click="selected(item.product)" :class="{ 'red': !item.product.active }">
                               {{ item.product.name }}
                         </a>
                    </td>
                   <td width="80px">
                        {{ item.price }}
                    </td>
                </tr>
            </tbody>
        </table>

    </span>
</template>

<script>
    export default {
        data () {
            return {
                search: '',
                results: []
            }
        },
        updated () {
        },
        methods:{
            searchProducts(search){
                axios.get('/admin/search-products?search=' + search).then((res)=>{
                    this.results = res.data;
                });
            },
            selected(product){
                this.results = [];
                this.search  = '';
                this.$emit('productSelected', product);
            },
            clearSearch(){
                this.search = '';
            }
        },
        watch: {
            search: {
                handler: function (val, oldVal) {
                   this.searchProducts(val);
                },
                deep: true
            }
        }
    }
</script>

<style scoped>

</style>