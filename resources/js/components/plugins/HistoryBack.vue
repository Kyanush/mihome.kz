<template>

        <a @click="historyBack" id="history-back">
            <i class="fa fa-angle-double-left"></i>
            &nbsp;НАЗАД&nbsp;
        </a>

</template>

<script>
    export default {
        name: 'HistoryBack',
        data () {
            return {
            }
        },
        methods: {
            historyBack(){
                history.back();
            }
        }
    }
</script>

<style>
    #history-back{
        margin-bottom: 15px;
        display: block;
        font-weight: bold;
        color: #3c8dbc;
    }
</style>