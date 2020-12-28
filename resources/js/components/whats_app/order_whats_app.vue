<template>




    <div id="whatsapp" class="row app-one" style="height: 600px;">

        <div class="col-sm-4 side">
            <div class="side-one">

                <!-- SearchBox -->
                <div class="row searchBox">
                    <div class="col-sm-12 searchBox-inner">
                        <div class="form-group has-feedback">
                            <input v-model="search_dialog" id="searchText" type="text" class="form-control" name="searchText" placeholder="Поиск">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                </div>

                <!-- Search Box End -->
                <!-- sideBar -->
                <div class="row sideBar">


                    <div class="row sideBar-body" :class="{ 'active': dialog_item.id == dialog.id }" v-for="dialog_item in resultDialogs" @click="selectDialog(dialog_item)">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img :src="dialog_item.image ? dialog_item.image : 'https://www.palmdalewater.org/wp-content/uploads/2019/03/no-photo-male.jpg'"/>
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                                    <span class="name-meta">{{ dialog_item.name }}</span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                    <span class="time-meta pull-right">{{ convertTimestamp(dialog_item.last_time) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
                <!-- Sidebar End -->
            </div>

        </div>


        <!-- New Message Sidebar End -->

        <!-- Conversation Start -->
        <div class="col-sm-8 conversation">
            <!-- Heading -->
            <div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img :src="dialog.image">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta">
                        {{ dialog.name}}
                    </a>
                    <span class="heading-online">Online</span>
                </div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                </div>
            </div>
            <!-- Heading End -->

            <!-- Message Box -->
            <div class="row message" id="conversation">

                <!--
                    <div class="row message-previous">
                        <div class="col-sm-12 previous">
                            <a onclick="previous(this)" id="ankitjain28" name="20">
                                Show Previous Message!
                            </a>
                        </div>
                    </div>
                --->

                <div class="row message-body" v-for="message in messages">
                    <div class="col-sm-12" :class="{ 'message-main-sender': message.fromMe, 'message-main-receiver': !message.fromMe }">
                        <div class="receiver" :class="{ 'sender': message.fromMe, 'receiver': !message.fromMe }">
                            <div class="message-text">

                                <b v-if="message.senderName && dialog.metadata.isGroup">{{ message.senderName }}</b>

                                <div class="quoted-msg-body" v-if="message.quotedMsgBody">{{ message.quotedMsgBody }}</div>

                                <div v-if="message.type == 'chat' || message.type == 'call_log'">{{ message.body }}</div>

                                <div v-else-if="message.type == 'image'">
                                    <img :src="message.body" width="350"/>
                                </div>

                                <a v-else-if="message.type == 'document'" :href="message.body" download="" class="messages-item__document">
                                        <span aria-label="File Pdf icon" role="img" class="material-design-icon file-pdf-icon icon icon--file-pdf">
                                            <svg data-v-c3b50b02="" fill="currentColor" width="36" height="36" viewBox="0 0 24 24" class="material-design-icon__svg"><path data-v-c3b50b02="" d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2M10.1,11.4C10.08,11.44 9.81,13.16 8,16.09C8,16.09 4.5,17.91 5.33,19.27C6,20.35 7.65,19.23 9.07,16.59C9.07,16.59 10.89,15.95 13.31,15.77C13.31,15.77 17.17,17.5 17.7,15.66C18.22,13.8 14.64,14.22 14,14.41C14,14.41 12,13.06 11.5,11.2C11.5,11.2 12.64,7.25 10.89,7.3C9.14,7.35 9.8,10.43 10.1,11.4M10.91,12.44C10.94,12.45 11.38,13.65 12.8,14.9C12.8,14.9 10.47,15.36 9.41,15.8C9.41,15.8 10.41,14.07 10.91,12.44M14.84,15.16C15.42,15 17.17,15.31 17.1,15.64C17.04,15.97 14.84,15.16 14.84,15.16M7.77,17C7.24,18.24 6.33,19 6.1,19C5.87,19 6.8,17.4 7.77,17M10.91,10.07C10.91,10 10.55,7.87 10.91,7.92C11.45,8 10.91,10 10.91,10.07Z">
                                                <title data-v-c3b50b02="">File Pdf icon</title></path>
                                            </svg>
                                        </span>
                                    {{ message.body }}
                                </a>

                                <audio v-else-if="message.type == 'audio' || message.type == 'ptt'" controls="controls" preload="metadata">
                                    <source :src="message.body" type="audio/ogg">
                                </audio>

                            </div>
                            <span class="message-time pull-right">
                              {{ convertTimestamp(message.time) }}
                            </span>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Message Box End -->

            <!-- Reply Box -->
            <div class="row reply">
                <div class="col-sm-1 col-xs-1 reply-emojis">
                    <div class="dropup clearfix">
                        <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-9 col-xs-9 reply-main">
                    <textarea @keyup.enter.exact="sendMessage" v-model="message" class="form-control" rows="1" id="comment"></textarea>
                </div>
                <div class="col-sm-1 col-xs-1 reply-recording">
                    <i @click="createOrder" title="Создать заказ" class="fa fa-plus-square fa-2x create-order" aria-hidden="true"></i>
                </div>
                <div class="col-sm-1 col-xs-1 reply-send">
                    <i class="fa fa-send fa-2x" aria-hidden="true" @click="sendMessage"></i>
                </div>
            </div>
            <!-- Reply Box End -->
        </div>
        <!-- Conversation End -->
    </div>
    <!-- App One End -->



</template>


<script>

    export default {
        props: ['p_search_dialog'],
        data() {
            return {
                messages: [],
                dialogs:  [],
                dialog:   {},
                search_dialog: '',
                message: ''
            }
        },
        methods:{
            sendMessage(){

                var data = {
                    message: this.message,
                    chat_id: this.dialog ? this.dialog.id : '',
                    phone:   this.p_search_dialog
                };

                axios.post('/whats-app/send-message', data).then((res)=>{
                    var result = res.data;
                    if(result.sent)
                    {
                        this.getMessages(this.dialog.id);
                        this.message = '';
                    }

                });
            },
            selectDialog(dialog){

                this.dialog = dialog;
                this.getMessages(dialog.id);
            },
            getMessages(chat_id){
                axios.get('/whats-app/messages?chat_id=' + chat_id).then((res)=>{
                    var data = res.data;

                    this.messages = data;

                    setTimeout(function(){
                        $("#conversation").scrollTop($("#conversation")[0].scrollHeight);
                    }, 500);

                });
            },
            convertTimestamp(timestamp) {
                if(!timestamp)
                    return '';
                var date = this.$helper.convertTimestamp(timestamp);
                return this.$helper.dateFormatTodayYesterday(date);
            },
            createOrder(){

                var data = {
                    id: 0,
                    user_id: '',
                    type_id: 7,
                    status_id: 1,
                    carrier_id: 2,
                    comment: '',
                    delivery_date: '',
                    payment_id: 1,
                    paid: 0,
                    payment_date: '',
                    created_at: '',
                    city: '',
                    address: '',
                    user_name:  this.dialog.name,
                    user_phone: this.dialog.id.replace(/[^0-9]/g,''),
                    user_email: '',
                    products: []
                };

                axios.post('/admin/order-save', {
                    order: data
                }).then((res)=>{
                    if(res.data)
                    {
                        $('#whatsapp-popup').css('display', 'none');


                        this.$router.push({
                            name: 'order_edit',
                            params:{
                                order_id: res.data
                            }
                        });

                    }
                });
            }
        },
        created(){
            this.search_dialog = this.p_search_dialog;

            axios.get('/whats-app/dialogs').then((res)=>{
                var data = res.data;
                this.dialogs = data;
            });

        },
        computed: {
            resultDialogs()
            {
                if(this.search_dialog){

                    if(this.dialogs.length > 0)
                    {
                        return this.dialogs.filter((item)=>{
                            var result = this.search_dialog.toLowerCase().split(' ').every(
                                v => item.id.replace(/[^0-9]/g,'').toLowerCase().includes(v) || item.name.toLowerCase().includes(v),
                            );

                            if(result)
                                this.selectDialog(item);

                            return result;
                        });
                    }

                }else{
                    return this.dialogs;
                }
            }
        }
    }


</script>

<style scoped>



    .fa-2x {
        font-size: 1.5em;
    }


    .app-one {
        background-color: #f7f7f7;
        height: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
    }

    .side {
        padding: 0;
        margin: 0;
        height: 100%;
    }
    .side-one {
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        z-index: 1;
        position: relative;
        display: block;
        top: 0;
    }

    .side-two {
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        z-index: 2;
        position: relative;
        top: -100%;
        left: -100%;
        -webkit-transition: left 0.3s ease;
        transition: left 0.3s ease;

    }


    .heading {
        padding: 10px 16px 10px 15px;
        margin: 0;
        height: 60px;
        width: 100%;
        background-color: #eee;
        z-index: 1000;
    }

    .heading-avatar {
        padding: 0;
        cursor: pointer;

    }

    .heading-avatar-icon img {
        border-radius: 50%;
        height: 40px;
        width: 40px;
    }

    .heading-name {
        padding: 0 !important;
        cursor: pointer;
    }

    .heading-name-meta {
        font-weight: 700;
        font-size: 100%;
        padding: 5px;
        padding-bottom: 0;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000;
        display: block;
    }
    .heading-online {
        display: none;
        padding: 0 5px;
        font-size: 12px;
        color: #93918f;
    }
    .heading-compose {
        padding: 0;
    }

    .heading-compose i {
        text-align: center;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }

    .heading-dot {
        padding: 0;
        margin-left: 10px;
    }

    .heading-dot i {
        text-align: right;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }

    .searchBox {
        padding: 0 !important;
        margin: 0 !important;
        height: 60px;
        width: 100%;
    }

    .searchBox-inner {
        height: 100%;
        width: 100%;
        padding: 10px !important;
        background-color: #fbfbfb;
    }


    /*#searchBox-inner input {
      box-shadow: none;
    }*/

    .searchBox-inner input:focus {
        outline: none;
        border: none;
        box-shadow: none;
    }

    .sideBar {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #fff;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 120px);
    }

    .sideBar-body {
        position: relative;
        padding: 10px !important;
        border-bottom: 1px solid #f7f7f7;
        height: 72px;
        margin: 0 !important;
        cursor: pointer;
    }

    .sideBar-body:hover, .sideBar-body.active {
        background-color: #f2f2f2;
    }

    .sideBar-avatar {
        text-align: center;
        padding: 0 !important;
    }

    .avatar-icon img {
        border-radius: 50%;
        height: 49px;
        width: 49px;
    }

    .sideBar-main {
        padding: 0 !important;
    }

    .sideBar-main .row {
        padding: 0 !important;
        margin: 0 !important;
    }

    .sideBar-name {
        padding: 10px !important;
    }

    .name-meta {
        font-size: 100%;
        padding: 1% !important;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000;
    }

    .sideBar-time {
        padding: 10px !important;
    }

    .time-meta {
        text-align: right;
        font-size: 12px;
        padding: 1% !important;
        color: rgba(0, 0, 0, .4);
        vertical-align: baseline;
    }

    /*New Message*/

    .newMessage {
        padding: 0 !important;
        margin: 0 !important;
        height: 100%;
        position: relative;
        left: -100%;
    }
    .newMessage-heading {
        padding: 10px 16px 10px 15px !important;
        margin: 0 !important;
        height: 100px;
        width: 100%;
        background-color: #00bfa5;
        z-index: 1001;
    }

    .newMessage-main {
        padding: 10px 16px 0 15px !important;
        margin: 0 !important;
        height: 60px;
        margin-top: 30px !important;
        width: 100%;
        z-index: 1001;
        color: #fff;
    }

    .newMessage-title {
        font-size: 18px;
        font-weight: 700;
        padding: 10px 5px !important;
    }
    .newMessage-back {
        text-align: center;
        vertical-align: baseline;
        padding: 12px 5px !important;
        display: block;
        cursor: pointer;
    }
    .newMessage-back i {
        margin: auto !important;
    }

    .composeBox {
        padding: 0 !important;
        margin: 0 !important;
        height: 60px;
        width: 100%;
    }

    .composeBox-inner {
        height: 100%;
        width: 100%;
        padding: 10px !important;
        background-color: #fbfbfb;
    }

    .composeBox-inner input:focus {
        outline: none;
        border: none;
        box-shadow: none;
    }

    .compose-sideBar {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #fff;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 160px);
    }

    /*Conversation*/

    .conversation {
        padding: 0 !important;
        margin: 0 !important;
        height: 100%;
        /*width: 100%;*/
        border-left: 1px solid rgba(0, 0, 0, .08);
        /*overflow-y: auto;*/
    }

    .message {
        padding: 0 !important;
        margin: 0 !important;
        /*background: url("w.jpg") no-repeat fixed center;*/
        background-size: cover;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 120px);
    }
    .message-previous {
        margin : 0 !important;
        padding: 0 !important;
        height: auto;
        width: 100%;
    }
    .previous {
        font-size: 15px;
        text-align: center;
        padding: 10px !important;
        cursor: pointer;
    }

    .previous a {
        text-decoration: none;
        font-weight: 700;
    }

    .message-body {
        margin: 0 !important;
        padding: 0 !important;
        width: auto;
        height: auto;
        margin-bottom: 10px!important;
    }

    .message-main-receiver {
        /*padding: 10px 20px;*/
        max-width: 60%;
    }

    .message-main-sender {
        padding: 3px 20px !important;
        margin-left: 40% !important;
        max-width: 60%;
    }

    .message-text {
        margin: 0 !important;
        padding: 5px !important;
        word-wrap:break-word;
        font-weight: 200;
        font-size: 14px;
        padding-bottom: 0 !important;
    }

    .message-time {
        margin: 0 !important;
        margin-left: 50px !important;
        font-size: 12px;
        text-align: right;
        color: #9a9a9a;

    }

    .receiver {
        width: auto !important;
        padding: 4px 10px 7px !important;
        border-radius: 10px 10px 10px 0;
        background: #ffffff;
        font-size: 12px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
        word-wrap: break-word;
        display: inline-block;
        max-width: 100%;
    }

    .sender {
        float: right;
        width: auto !important;
        background: #dcf8c6;
        border-radius: 10px 10px 0 10px;
        padding: 4px 10px 7px !important;
        font-size: 12px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
        display: inline-block;
        word-wrap: break-word;
    }


    /*Reply*/

    .reply {
        height: 60px;
        width: 100%;
        background-color: #f5f1ee;
        padding: 10px 5px 10px 5px !important;
        margin: 0 !important;
        z-index: 1000;
    }

    .reply-emojis {
        padding: 5px !important;
    }

    .reply-emojis i {
        text-align: center;
        padding: 5px 5px 5px 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-recording {
        padding: 5px !important;
    }

    .reply-recording i {
        text-align: center;
        padding: 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-send {
        padding: 5px !important;
    }

    .reply-send i {
        text-align: center;
        padding: 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-main {
        padding: 2px 5px !important;
    }

    .reply-main textarea {
        width: 100%;
        resize: none;
        overflow: hidden;
        padding: 5px !important;
        outline: none;
        border: none;
        text-indent: 5px;
        box-shadow: none;
        height: 100%;
        font-size: 16px;
    }

    .reply-main textarea:focus {
        outline: none;
        border: none;
        text-indent: 5px;
        box-shadow: none;
    }

    @media screen and (max-width: 700px) {
        .app {
            top: 0;
            height: 100%;
        }
        .heading {
            height: 70px;
            background-color: #009688;
        }
        .fa-2x {
            font-size: 2.3em !important;
        }
        .heading-avatar {
            padding: 0 !important;
        }
        .heading-avatar-icon img {
            height: 50px;
            width: 50px;
        }
        .heading-compose {
            padding: 5px !important;
        }
        .heading-compose i {
            color: #fff;
            cursor: pointer;
        }
        .heading-dot {
            padding: 5px !important;
            margin-left: 10px !important;
        }
        .heading-dot i {
            color: #fff;
            cursor: pointer;
        }
        .sideBar {
            height: calc(100% - 130px);
        }
        .sideBar-body {
            height: 80px;
        }
        .sideBar-avatar {
            text-align: left;
            padding: 0 8px !important;
        }
        .avatar-icon img {
            height: 55px;
            width: 55px;
        }
        .sideBar-main {
            padding: 0 !important;
        }
        .sideBar-main .row {
            padding: 0 !important;
            margin: 0 !important;
        }
        .sideBar-name {
            padding: 10px 5px !important;
        }
        .name-meta {
            font-size: 16px;
            padding: 5% !important;
        }
        .sideBar-time {
            padding: 10px !important;
        }
        .time-meta {
            text-align: right;
            font-size: 14px;
            padding: 4% !important;
            color: rgba(0, 0, 0, .4);
            vertical-align: baseline;
        }
        /*Conversation*/
        .conversation {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            /*width: 100%;*/
            border-left: 1px solid rgba(0, 0, 0, .08);
            /*overflow-y: auto;*/
        }
        .message {
            height: calc(100% - 140px);
        }
        .reply {
            height: 70px;
        }
        .reply-emojis {
            padding: 5px 0 !important;
        }
        .reply-emojis i {
            padding: 5px 2px !important;
            font-size: 1.8em !important;
        }
        .reply-main {
            padding: 2px 8px !important;
        }
        .reply-main textarea {
            padding: 8px !important;
            font-size: 18px;
        }
        .reply-recording {
            padding: 5px 0 !important;
        }
        .reply-recording i {
            padding: 5px 0 !important;
            font-size: 1.8em !important;
        }
        .reply-send {
            padding: 5px 0 !important;
        }
        .reply-send i {
            padding: 5px 2px 5px 0 !important;
            font-size: 1.8em !important;
        }
    }
    .quoted-msg-body{
        background-color: #009688;
        border-radius: 4px;
        padding: 1px 5px;
        color: #fff;
        width: 100%;
    }
    .create-order{
        color: #00a65a!important;
    }
</style>