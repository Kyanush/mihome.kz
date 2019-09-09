<template>
    <div>
        <VueCkeditor v-model="self_value" :config="ckeditor_config"></VueCkeditor>
    </div>
</template>

<script>
    //https://www.npmjs.com/package/vue-ckeditor2#npm
    import VueCkeditor from 'vue-ckeditor2';

    export default {
        props:['value', 'uploadFilePath'],
        components:{
            VueCkeditor
        },
        name: 'Ckeditor',
        data () {
            return {
                self_value: '',
                ckeditor_config: {
                    name: 'ckeditor',
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                        { name: 'about', items: [ 'About' ] }
                    ],
                    height: 300,

                    //filebrowserUploadUrl: '/ckeditor-upload-image?path=uploads/products/' + this.$route.params.id + '/',
                    filebrowserUploadUrl: '/ckeditor-upload-image?path=' + this.uploadFilePath,


                    filebrowserUploadMethod: 'form',

                    //allowedContent: 'p{text-align}(*); strong(*); em(*); b(*); i(*); u(*); sup(*); sub(*); ul(*); ol(*); li(*); a[!href](*); br(*); hr(*); img{*}[*](*); iframe(*)',
                    //disallowedContent: '*[on*]',

                    allowedContent: true,
                    extraAllowedContent: '*(*);*{*}',
                    extraAllowedContent: 'span;ul;li;table;td;style;*[id];*(*);*{*}'

                },
            }
        },
        created(){
            setInterval(function () {
                this.self_value = this.value;
            }.bind(this), 100);
        },
        watch: {
            self_value: {
                handler: function (val, oldVal) {
                    this.$emit('input', val);
                },
                deep: true
            }
        },
    }
</script>