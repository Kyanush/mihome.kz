<template>
    <div class="cd-panel cd-panel--from-right js-cd-panel-main" :class="{ 'cd-panel--is-visible': active }">
        <div class="cd-panel__container">
            <header class="cd-panel__header">
                <span>{{ title }}</span>
                <a class="cd-panel__close js-cd-close" @click="active = false">Закрыть</a>
            </header>
            <div class="cd-panel__content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],
        name: 'Breadcrumb',
        data () {
            return {
                active: false,
            }
        },
        methods: {
            panelClose(event) {
                var className = 'cd-panel--is-visible';
                var close = !!event.target.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'))
                if (close)
                    this.active = false;
            },
        },
        watch: {
            active: {
                handler: function (val, oldVal) {

                    if(val){
                        $('body').css('overflow', 'hidden');
                    }else{
                        $('body').css('overflow', 'unset');
                    }

                    this.$emit('state', val ? 'open' : 'close');
                },
                deep: true
            },
        }
    }
</script>

<style scoped>
    .cd-panel {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        visibility: hidden;
        -webkit-transition: visibility 0s 0.6s;
        transition: visibility 0s 0.6s;
        z-index: 1030;
    }

    .cd-panel::after {
        /* overlay layer */
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent;
        /*cursor: pointer;*/
        -webkit-transition: background 0.3s 0.3s;
        transition: background 0.3s 0.3s;
    }

    .cd-panel.cd-panel--is-visible {
        visibility: visible;
        -webkit-transition: visibility 0s 0s;
        transition: visibility 0s 0s;
    }

    .cd-panel.cd-panel--is-visible::after {
        background: rgba(0, 0, 0, 0.6);
        -webkit-transition: background 0.3s 0s;
        transition: background 0.3s 0s;
    }

    .cd-panel__header {
        padding: 15px 17px;
        width: 100%;
        background: rgba(255, 255, 255, 0.96);
        z-index: 2;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.08);
        -webkit-transition: -webkit-transform 0.3s 0s;
        transition: -webkit-transform 0.3s 0s;
        transition: transform 0.3s 0s;
        transition: transform 0.3s 0s, -webkit-transform 0.3s 0s;
        -webkit-transform: translateY(-50px);
        -ms-transform: translateY(-50px);
        transform: translateY(-50px);
    }

    .cd-panel__header span {
        color: #89ba2c;
        font-size: 18px;
        margin: 0;
        padding: 0;
        font-weight: 700;
    }

    .cd-panel--is-visible .cd-panel__header {
        -webkit-transition: -webkit-transform 0.3s 0.3s;
        transition: -webkit-transform 0.3s 0.3s;
        transition: transform 0.3s 0.3s;
        transition: transform 0.3s 0.3s, -webkit-transform 0.3s 0.3s;
        -webkit-transform: translateY(0px);
        -ms-transform: translateY(0px);
        transform: translateY(0px);
    }

    .cd-panel__close {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 60px;
        /* image replacement */
        display: inline-block;
        overflow: hidden;
        text-indent: 100%;
        white-space: nowrap;
    }

    .cd-panel__close::before, .cd-panel__close::after {
        /* close icon created in CSS */
        content: '';
        position: absolute;
        top: 25px;
        left: 20px;
        height: 3px;
        width: 20px;
        background-color: #424f5c;
        /* this fixes a bug where pseudo elements are slighty off position */
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }

    .cd-panel__close::before {
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .cd-panel__close::after {
        -webkit-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    .cd-panel__close:hover {
        background-color: #424f5c;
    }

    .cd-panel__close:hover::before, .cd-panel__close:hover::after {
        background-color: #ffffff;
        -webkit-transition: -webkit-transform 0.3s;
        transition: -webkit-transform 0.3s;
        transition: transform 0.3s;
        transition: transform 0.3s, -webkit-transform 0.3s;
    }

    .cd-panel__close:hover::before {
        -webkit-transform: rotate(220deg);
        -ms-transform: rotate(220deg);
        transform: rotate(220deg);
    }

    .cd-panel__close:hover::after {
        -webkit-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
        transform: rotate(135deg);
    }

    .cd-panel--is-visible .cd-panel__close::before {
        -webkit-animation: cd-close-1 0.6s 0.3s;
        animation: cd-close-1 0.6s 0.3s;
    }

    .cd-panel--is-visible .cd-panel__close::after {
        -webkit-animation: cd-close-2 0.6s 0.3s;
        animation: cd-close-2 0.6s 0.3s;
    }

    @-webkit-keyframes cd-close-1 {
        0%, 50% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    }

    @keyframes cd-close-1 {
        0%, 50% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    }

    @-webkit-keyframes cd-close-2 {
        0%, 50% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }
    }

    @keyframes cd-close-2 {
        0%, 50% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }
    }

    .cd-panel__container {
        position: fixed;
        width: 90%;
        height: 100%;
        top: 0;
        background: #dbe2e9;
        z-index: 1;
        -webkit-transition: -webkit-transform 0.3s 0.3s;
        transition: -webkit-transform 0.3s 0.3s;
        transition: transform 0.3s 0.3s;
        transition: transform 0.3s 0.3s, -webkit-transform 0.3s 0.3s;
    }

    .cd-panel--from-right .cd-panel__container {
        right: 0;
        -webkit-transform: translate3d(100%, 0, 0);
        transform: translate3d(100%, 0, 0);
    }

    .cd-panel--from-left .cd-panel__container {
        left: 0;
        -webkit-transform: translate3d(-100%, 0, 0);
        transform: translate3d(-100%, 0, 0);
    }

    .cd-panel--is-visible .cd-panel__container {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        -webkit-transition-delay: 0s;
        transition-delay: 0s;
    }

    @media only screen and (min-width: 768px) {
        .cd-panel__container {
            width: 90%;
        }
    }

    @media only screen and (min-width: 1170px) {
        .cd-panel__container {
            width: 90%;
        }
    }

    .cd-panel__content {
        width: 100%;
        height: 100%;
        padding: 20px;
        overflow: auto;
    }

    .cd-panel__content p {
        font-size: 1.4rem;
        color: #424f5c;
        line-height: 1.4;
        margin: 2em 0;
    }

    .cd-panel__content p:first-of-type {
        margin-top: 0;
    }

    @media only screen and (min-width: 768px) {
        .cd-panel__content p {
            font-size: 1.6rem;
            line-height: 1.6;
        }
    }
</style>