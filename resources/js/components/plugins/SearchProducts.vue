<template>
    <span>
        <div class="input-group">
            <input placeholder="Поиск..." type="text" class="form-control" v-model="search"/>
            <span class="input-group-addon btn" @click="clearSearch">
              <i class="fa fa-remove red"></i>
            </span>
        </div>

        <br/>

        <ul>
            <li v-for="item in results">
                <img :src="item.photo_path" width="50"/>
                ID:{{ item.product.id }}, {{ item.product.name }}
                <a class="pull-right" @click="selected(item.product)">Выбрать</a>
            </li>
        </ul>

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
    ul li{
        border-bottom: 1px solid #d6d2d2;
        padding: 5px 0;
    }
</style>
