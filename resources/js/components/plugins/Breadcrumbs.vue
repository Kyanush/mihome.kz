<template>
    <section class="content-header">
        <h1>
            <span>{{ routeName }}</span>
        </h1>
        <ol class="breadcrumb">
            <li v-for="(breadcrumb, idx) in breadcrumbList" :key="idx" :class="{'linked': !!breadcrumb.link}">
                <router-link :to="{ path: breadcrumb.link}">
                    {{ breadcrumb.name }}
                </router-link>
            </li>
            <li>
                <a class="active">
                    {{ routeName }}
                </a>
            </li>
        </ol>
    </section>
</template>

<script>
    export default {
        name: 'Breadcrumb',
        data () {
            return {
                breadcrumbList: []
            }
        },
        mounted () { this.updateList() },
        watch: { '$route' () { this.updateList() } },
        methods: {
            updateList () {
                this.breadcrumbList = this.$route.meta.breadcrumb;
            }
        },
        computed:{
            routeName(){
                return this.$route.name;
            }
        }
    }
</script>

<style scoped>
    a:not(.active){
        cursor: pointer;
    }
    a:not(.active){
        text-decoration: underline!important;
    }
</style>