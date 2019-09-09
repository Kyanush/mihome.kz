<template>
    <div class="wrapper-dropdown">

        <span @click="toggleDropdown()" v-html="selector"></span>

        <ul class="dropdown" v-show="active">
            <li v-for="item in colors" @click="setColor(item)">
                <span class="color" :style="{background: item.hex}"></span>
                {{item.name}}
            </li>
        </ul>

    </div>
</template>


<script>
    export default {
        props: ['value', 'colorOptions'],
        data () {
            return{
                selected: {
                    id: 0,
                    hex: '',
                    name: ''
                },
                active: false,
                colors: this.colorOptions
            }
        },
        computed: {
            selector: function() {
                if(this.value && !this.selected.id)
                {
                    var self = this;
                    this.colorOptions.forEach(function (item, index) {
                        if(item.id == self.value)
                        {
                            self.selected = item;
                            return;
                        }
                    });
                }

                if(!this.selected.id) {
                    return 'Выберите цвет';
                } else {
                    return '<span class="color" style="background: ' + this.selected.hex + '"></span> ' + this.selected.name;
                }
            }
        },
        methods: {
            setColor: function(item) {
                this.selected = item;
                this.active = false;
                this.$emit('input', this.selected.id);
            },
            toggleDropdown: function() {
                this.active = !this.active;
            },
        }
    }
</script>

<style>
    .color {
        padding: 0 12px;
        margin-right: 5px;
    }
    .wrapper-dropdown {
        position: relative;
        width: 100%;
        background: #FFF;
        color: #2e2e2e;
        outline: none;
        cursor: pointer;
    }
    .wrapper-dropdown > span {
        width: 100%;
        display: block;
        border: 1px solid #ababab;
        padding: 5px;
    }
    .wrapper-dropdown > span > span {
        padding: 0 12px;
        margin-right: 5px;
    }
    .wrapper-dropdown > span > span.noColor {
        background: #CCC;
        position: relative;
    }
    .wrapper-dropdown > span > span.noColor:after {
        content: "";
        background: red;
        -webkit-transform: rotate(-32deg);
        transform: rotate(-32deg);
        display: inline-block;
        width: 28px;
        height: 2px;
        position: absolute;
        bottom: 7px;
        left: -2px;
    }
    .wrapper-dropdown > span:after {
        content: "";
        width: 0;
        height: 0;
        position: absolute;
        right: 16px;
        top: calc(50% + 4px);
        margin-top: -6px;
        border-width: 6px 6px 0 6px;
        border-style: solid;
        border-color: #2e2e2e transparent;
    }

    .wrapper-dropdown .dropdown {
        height: 200px;
        overflow-x: auto;
        position: absolute;
        z-index: 10;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        font-weight: normal;
        list-style-type: none;
        padding-left: 0;
        margin: 0;
        border: 1px solid #ababab;
        border-top: 0;
    }

    .wrapper-dropdown .dropdown li {
        display: block;
        text-decoration: none;
        color: #2e2e2e;
        padding: 5px;
        cursor: pointer;
        min-height: 28px;
    }
    .wrapper-dropdown .dropdown li > span.noColor {
        background: #CCC;
        position: relative;
    }
    .wrapper-dropdown .dropdown li > span.noColor:after {
        content: "";
        background: red;
        -webkit-transform: rotate(-32deg);
        transform: rotate(-32deg);
        display: inline-block;
        width: 28px;
        height: 2px;
        position: absolute;
        bottom: 7px;
        left: -2px;
    }

    .wrapper-dropdown .dropdown li:hover {
        background: #eee;
        cursor: pointer;
    }
</style>