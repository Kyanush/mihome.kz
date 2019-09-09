<template>
        <div id="categories"></div>
</template>

<script>
    import 'jstree/jstree.js';

    export default {
        props: ['value', 'returnKey', 'multiple'],
        name: 'categories',
        data () {
            return {
                selected_keys: [],
                categories: []
            }
        },
        methods:{
            convertData(){

                var data = [{
                    'id'     : 0,
                    'parent' : '#',
                    'text'   : 'Нет категории',
                    'url'    : '',
                }];

                var self = this;
                this.categories.forEach(function (item, index){
                    var i = {
                        'id'     : item.id,
                        'parent' : (item.parent_id > 0 ? item.parent_id : '#'),
                        'text'   : item.name,
                        'url'    : item.url,
                        'icon'   : item.active == 0 ? 'fa fa-remove red' : ''
                    };

                    if(self.value)
                        if(self.value.indexOf(item[ self.returnKey ]) >= 0)
                            i['state'] = { 'selected' : true, opened: false};

                    data.push(i);
                });
                return data;
            },


            init(){
                    var self = this;
                    var data = this.convertData();

                    $('#categories').jstree({

                        checkbox: {
                            cascade: 'undetermined',
                            visible: false,
                            three_state: false
                        },

                        'plugins': ['search', 'checkbox', 'wholerow'],
                        'core': {
                            'multiple': self.multiple,
                            'data': data,
                            'animation': false,
                            //'expand_selected_onload': true,
                            'themes': {
                                'icons': true,
                            }
                        },
                        'search': {
                            'show_only_matches': true,
                            'show_only_matches_children': true
                        }
                    });


                    $('#categories').on('changed.jstree', function (e, data) {
                        var objects = data.instance.get_selected(true)

                        self.selected_keys = [];
                        objects.forEach(function (item, index){
                            if(self.multiple)
                                self.selected_keys.push(item.original[ self.returnKey ]);
                            else
                                self.selected_keys = item.original[ self.returnKey ];
                        });


                    });


            }
        },
        created(){
            axios.get('/admin/categories-list?per_page=1000').then((res)=> {
                this.categories = res.data.data;
                setTimeout(function () {
                    this.init();
                }.bind(this), 2000);
            });
        },
        watch: {
            selected_keys: {
                handler: function (val, oldVal) {
                    this.$emit('input', val ? val : '');
                },
                deep: true
            }
        },
    }
</script>

<style>
    @import 'https://static.jstree.com/3.2.1/assets/dist/themes/default/style.min.css';
    #categories{
        width: 100%;
    }
    .jstree-default .jstree-wholerow-clicked {
        background: #e8f2f6!important;
        background: -webkit-linear-gradient(top,#e8f2f6 0,#e8f2f6 100%)!important;
        background: linear-gradient(to bottom,#e8f2f6 0,#e8f2f6 100%)!important;
    }
</style>