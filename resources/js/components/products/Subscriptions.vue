<template>
    <div class="box">

        <div class="table-responsive">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th v-if="!product_id">Товар</th>
                        <th>Почта</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody v-if="subscriptions">
                    <tr v-for="item in subscriptions.data">
                        <td v-if="!product_id">{{ item.product ? item.product.name : '' }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.created_at }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th v-if="!product_id">Товар</th>
                        <th>Почта</th>
                        <th>Дата</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center">
            <paginate
                    v-if="subscriptions && subscriptions.last_page > 1"
                    v-model="subscriptions.current_page"
                    :page-count="subscriptions.last_page"
                    :click-handler="getSubscriptions"
                    :prev-text="'<<'"
                    :next-text="'>>'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"></paginate>
        </div>


    </div>
</template>


<script>
    import Paginate from 'vuejs-paginate';
    import { mapGetters } from 'vuex';

    export default {
        props:['product_id'],
        components:{
            Paginate
        },
        data () {
            return {
                filter:{
                    page:   (this.$route.query.page       ? this.$route.query.page : 1)
                },
                subscriptions: []
            }
        },
        created() {
            this.getSubscriptions();
        },
        methods:{
            getSubscriptions(page) {

                page = !page ? (this.$route.query.page ? this.$route.query.page : 1) : page;

                var params = {};

                if(page > 1)
                    params['page'] = page;

                if(this.product_id)
                    params['product_id'] = this.product_id;

                axios.get('/admin/subscriptions', {params:  params}).then(response => {
                    this.subscriptions = response.data;

                    if(!this.product_id && !this.$route.query.review_id)
                        this.$router.push({query: params});
                });
            },

        },
        computed:{
            ...mapGetters([
                'IsError'
            ]),
        }
    }
</script>