<template>
    <span>
        <i @click="setSort(column + '-asc')"  v-bind:class="{ 'red': value == (column + '-asc')  }" title="по возрастанию" class="asc  fa fa-sort-asc  pull-right cursor-pointer"></i>
        <i @click="setSort(column + '-desc')" v-bind:class="{ 'red': value == (column + '-desc') }" title="по убыванию"    class="desc fa fa-sort-desc pull-right cursor-pointer"></i>
    </span>
</template>

<script>
    export default {
        props: ['value', 'column'],
        data () {
            return{
            }
        },
        methods: {
            setSort(value){
                if(value == this.value)
                    value = '';

                this.$emit('input', value);
            }
        }
    }
</script>


<style>
    .table-sort .asc{
        top: 5px;
    }
    .table-sort .desc{
        bottom: 5px;
    }
    .table-sort .asc, .table-sort .desc{
        right: 5px;
        position: absolute;
        color: #3c8dbc;
        font-size: 20px;
    }
    .table-sort th{
        position: relative;
    }
</style>