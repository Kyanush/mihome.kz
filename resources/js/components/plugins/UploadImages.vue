<template>
    <label class="dropzone">

        <p>
            <a for="pictures">
                <i class="fa fa-upload green"></i> Загрузить фото
                <input type="file" accept="image/*"  multiple id="pictures" @change="setValue($event)"/>
            </a>
            &nbsp;
            <a v-if="value.length" @click="deleteAll($event)">
                <i class="fa fa-remove red"></i>
                Удалить все
            </a>
        </p>

        <div class="images-view">
            <div class="image" v-for="(item, index) in value" v-if="!item.is_delete">
                <img v-bind:id="'img' + index" v-bind:src="item.image_view"/>
                <a @click="deleteImage($event, index)">
                    <i class="fa fa-remove"></i> Удалить
                </a>
                <p v-if="IsError(error_variable + '.' + index + '.value')" class="image-error" v-for="e in IsError(error_variable + '.' + index + '.value')">
                    {{ e }}
                </p>
            </div>
        </div>

    </label>
</template>


<script>
    import { mapGetters } from 'vuex';

    export default {
        props:['value', 'error_variable'],
        data () {
            return{

            }
        },
        methods:{
            setValue(event){
                for(var i = 0; i < event.target.files.length; i++)
                {
                    this.value.push({
                        id: 0,
                        is_delete: 0,
                        value: event.target.files[i]
                    });
                }
            },
            deleteImage(event, index){
                event.preventDefault();

                if(this.value[index])
                {
                    if(this.value[index].id > 0)
                        this.$set(this.value[index], 'is_delete', 1);
                    else
                        this.$delete(this.value, index);
                }else
                    this.$delete(this.value, index);

            },
            deleteAll(event){
                event.preventDefault();

                var self = this;
                $.each(this.value, function(index, item) {
                    self.deleteImage(event, index);
                });
            },
            setImgSrc(value, element){
                this.$helper.setImgSrc(value, element);
            }
        },
        computed:{
            ...mapGetters([
                'IsError'
            ])
        },
        watch: {
            value: {
                handler: function (val, oldVal) {
                    this.$emit('input', val);

                    var self = this;
                    $.each(val, function(key, value) {
                        if(value.value.name)
                            self.setImgSrc(value.value, '#img' + key);
                    });
                },
                deep: true
            }
        },
    }
</script>

<style scoped>
    .dropzone {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
        width: 100%;
        height: 270px;
        box-sizing: border-box;
        text-align: center;
        overflow-y: scroll;
    }
    .dropzone input[type=file]{
        display: none;
    }
    .dropzone p{
        font-weight: normal;
    }
    .images-view{
        text-align: center;
    }
    .images-view .image{
        width: 100px;
        margin: 2px;
        border: 1px solid #d9cece;
        padding: 2px;
        display: inline-block;
    }
    .images-view .image img{
        max-width: 100%;
    }
    .images-view .image a{
        font-size: 12px;
    }
    .images-view .image a .fa{
        color: #e30b0b;
    }
    .image-error{
        font-size: 8px;
        color: red;
    }
</style>