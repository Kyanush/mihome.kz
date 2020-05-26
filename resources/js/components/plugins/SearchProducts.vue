<template>
    <span>
        <div class="input-group">
            <input placeholder="Поиск..." type="text" class="form-control" v-model="search"/>
            <span class="input-group-addon btn" @click="clearSearch">
              <i class="fa fa-remove red"></i>
            </span>
        </div>

        <br/>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Название</th>
                    <th width="70">Цена</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in results">
                    <td>{{ item.id }}</td>
                    <td>
                        <router-link target="_blank" :to="{ name: 'product_edit', params: { product_id: item.id} }" title="Изменить">
                            <img :src="item.photo_path" width="30"/>
                        </router-link>
                    </td>
                    <td>
                        <router-link target="_blank" :to="{ name: 'product_edit', params: { product_id: item.id} }" title="Изменить" :class="{ 'red': !item.active}">
                            {{ item.name }},
                        </router-link>
                    </td>
                    <td width="70">
                        {{ item.reduced_price_format }}
                    </td>
                    <td>
                        <button class="btn btn-success" @click="selected(item)">
                            <i class="fa fa-plus"></i>
                            Выбрать
                        </button>
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
