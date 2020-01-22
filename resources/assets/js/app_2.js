
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import Vuex from 'vuex'


import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { locale });
import StoreData from './store_2/store'
import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);

window.eventBus = new Vue()
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Vuex)

const store = new Vuex.Store(StoreData)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import myHeader from './components_2/include/Header.vue';
import myUsers from './components/users/User'
import myLeave from './components_2/leave'
import myLeaveType from './components_2/leave/leave_type'
import myExpenses from './components_2/expenses'
import myAttendance from './components_2/attendance'

const routes = [
    {path: '/leave', component: myLeave },
    {path: '/leave_type', component: myLeaveType },
    {path: '/expenses', component: myExpenses },
    {path: '/attendance', component: myAttendance },
]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app_2',
    store,
    router,
    components: {
        myHeader, myUsers, myLeave, myLeaveType, myExpenses, myAttendance
    },
});
