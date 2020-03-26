
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import VueRouter from 'vue-router'
import router from './router'
import Vuetify from 'vuetify'

import Vuex from 'vuex'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'
// import VueCharts from 'vue-chartjs'
// import { Bar, Line } from 'vue-chartjs'
import JsonExcel from 'vue-json-excel'

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { locale });
import StoreData from './store/store'

import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);
// import VueCharts from 'vue-chartjs'
// import { Bar, Line } from 'vue-chartjs'
window.eventBus = new Vue()

Vue.use(Vuetify)
// Vue.use(VueRouter)
Vue.use(Vuex)

const store = new Vuex.Store(StoreData)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// axios.defaults.baseURL = 'http://courier.dev/api/getData';
Vue.component('downloadExcel', JsonExcel)
// Vue.component('file-management', require('./components/upload/FileManagement.vue'));
// Vue.component('attachment-list', require('./components/upload/AttachmentList.vue'));
Vue.component('upload-list', require('./components/upload/Upload.vue'));

Vue.component('message', require('./components/message.vue'));
Vue.component('message', require('./components/chat/Message.vue'));
import myHeader from './components/include/Header.vue';
import myScreen from './components/screen';

import passportClients from './components/passport/Clients.vue'
import passportAuthorizedClients from './components/passport/AuthorizedClients.vue'
import passportPersonalAccessTokens from './components/passport/PersonalAccessTokens.vue'

// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );

// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );

// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );

const app = new Vue({
    el: '#app',
    store,
    router,
    components: {
        myScreen,
        myHeader,

        passportClients,
        passportAuthorizedClients,
        passportPersonalAccessTokens,
    },
    data() {
        return {
            timer: '',
            timeout: 7.8e+6
        }
    },
    mounted() {
        // window.addEventListener('click', this.resetTimer())

        this.inactivityTime()
        this.timer = setTimeout(() => {
            window.location.reload();
            // alert('test_1')
            // this.reload_page()
        }, this.timeout);
        // this.reload_page()

    },

    methods: {
        inactivityTime() {
            let self = this
            // document.querySelector('#app')
            window.addEventListener('keyup', function () {
                self.resetTimer()
            })
            window.addEventListener('click', function () {
                self.resetTimer()
            })
        },
        resetTimer() {
            // this.check_user()
            this.timeout = 7.8e+6
            clearInterval(this.timer);
            this.timer = setTimeout(() => {
                this.check_user()
                // window.location.reload();
            }, this.timeout);
        },
        check_user() {
            // alert('etettetet')
            var payload = {
                url: '/check_user'
            }
            this.$store.dispatch('checkUser', payload)
            // .then((res) => {
            //     this.inactivityTime()
            //     this.timer = setTimeout(() => {
            //         window.location.reload();
            //         // alert('test_1')
            //         // this.reload_page()
            //     }, this.timeout);
            // })

        },


    },

    created () {
        axios.post('/notification').then((response) => {
            this.notifications = response.data
        })

        var user_id = $('meta[name=user_id]').attr('content');
        Echo.private('App.User.' + user_id).notification((notifications) => {
            console.log(notification);

        })
    },
});
