<template>
    <div class="access-is-denied">
        <h3 class="text-center">Доступ запрещен 403</h3>
        <h3 class="text-center">Страница: {{ page }}</h3>
        <h3 class="text-center">
            <img src="/images/403.png">
        </h3>
    </div>
</template>

<script>
    export default {
        components:{
        },
        data() {
            return {
                page: this.$route.query.page
            }
        },
        methods:{
        },
        created(){
        }
    }
</script>

<style>
    .access-is-denied{
        width: 100%;
    }
</style>
