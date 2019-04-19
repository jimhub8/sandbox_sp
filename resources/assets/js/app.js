
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import Print from 'vue-print-nb'
// import * as VueGoogleMaps from 'vue2-google-maps'
// import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'vuetify/dist/vuetify.min.css'
// import VueCharts from 'vue-chartjs'
// import { Bar, Line } from 'vue-chartjs'
import JsonExcel from 'vue-json-excel'
import * as VueGoogleMaps from 'vue2-google-maps'
import { abilitiesPlugin } from '@casl/vue'
import VueChatScroll from 'vue-chat-scroll'
// import VueResource from "vue-resource"
// window.Echo = new Echo({

//     broadcaster: 'pusher',

//     key: 'c0a8d7b1122459cd74c9' //Add your pusher key here

// });

import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'
window.eventBus = new Vue()
import Pusher from 'pusher-js';

import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, { timeout: 5000 })
// import jsPDF from 'jsPDF'
// vue.use(Vuetify, {
//     iconfont: 'mdi'
// })
// Vue.use(VueChartkick, {adapter: Chart})

Vue.use(abilitiesPlugin)
Vue.use(VueChatScroll)
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyBNzKeF6ZwxlAOUCyeH8UxvvYRHP_w_Guk',
        libraries: ['geometry', 'places'],
        // libraries: 'places',
    },
})
// Vue.use(VueResource);

Vue.use(Print);
Vue.use(Vuetify)
Vue.use(VueRouter)


let passportAuthorizedclients = require('./components/passport/AuthorizedClients.vue')
let passportClients = require('./components/passport/Clients.vue')
let passportPersonalaccesstokens = require('./components/passport/PersonalAccessTokens.vue')
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import myStatuses from './components/status/Status.vue';
import myDStatus from './components/status/DStatus.vue';
// axios.defaults.baseURL = 'http://courier.dev/api/getData';
Vue.component('downloadExcel', JsonExcel)
// Vue.component('file-management', require('./components/upload/FileManagement.vue'));
// Vue.component('attachment-list', require('./components/upload/AttachmentList.vue'));
Vue.component('upload-list', require('./components/upload/Upload.vue'));

Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));


Vue.component('message', require('./components/message.vue'));
Vue.component('message', require('./components/chat/Message.vue'));
import myHeader from './components/include/Header.vue';
import myUser from './components/users/User.vue';
import myShipment from './components/shipments/Shipment.vue';
import myScanner from './components/scanner/Scanner.vue';
// import myContainer from './components/containers/Container.vue';
// import myMap from './components/reports/Map.vue';
import myBranch from './components/branches/Branch.vue';
import myProfile from './components/users/profile/Profile.vue';
import profileDash from './components/users/profile/Dashboard.vue';
import myCompany from './components/company/Company.vue';
import myCustomer from './components/customers/Customer.vue';
import mysubsicriber from './components/emails/Subscribe.vue';
// import myInvice from './components/invoices/Invoice.vue';
// import myReceipt from './components/receipt/Receipt.vue';
import myReports from './components/reports/Reports.vue';
import mybranchShip from './components/branches/BranchShipments.vue';
import myRoles from './components/users/roles/Roles.vue';
import myscheduled from './components/shipments/Scheduled.vue';
import myTasks from './components/tasks/Task.vue';
import myUploadFile from './components/upload/UploadFile.vue';
import myCharges from './components/charge/Charge.vue';
import myTown from './components/town/Town.vue';
import mySticker from './components/shipments/print/Sticker.vue';
import myWaybill from './components/shipments/print/Waybills.vue';
import myStatus from './components/shipments/status/Status.vue';
import myCountry from './components/country/Country.vue';
import myRinder from './components/drivers/Driver.vue';
import myunauth from './components/Unauthorized.vue';

import myCustDash from './components/customers/Dashboard.vue';
import myDrivDash from './components/drivers/Dashboard.vue';

import myDash from './components/App.vue';

import myFilter from './components/scanner/Filter.vue';
import myChatty from './components/chat/Chatty.vue';
import myFinance from './components/finance/Finance.vue';
import myFinClient from './components/finance/Clients.vue';
import myLogs from './components/splogs/Log.vue';
import mySc from './components/splogs/Schedule.vue';
import Api from './components/api/Api.vue';


const routes = [
    // {path: '/', component: dashboard },
    { path: '/users', component: myUser },
    { path: '/shipments', component: myShipment },
    { path: '/scanner', component: myScanner },
    // {path: '/containers', component: myContainer },
    { path: '/branches', component: myBranch },
    { path: '/profile', component: myProfile },
    { path: '/companies', component: myCompany },
    { path: '/subscribers', component: mysubsicriber },
    { path: '/customers', component: myCustomer },
    // { path: '/invoices', component: myInvice },
    // { path: '/receipts', component: myReceipt },
    { path: '/reports', component: myReports },
    { path: '/roles', component: myRoles },
    { path: '/branch/:id', component: mybranchShip },
    { path: '/scheduled', component: myscheduled },
    { path: '/tasks', component: myTasks },
    { path: '/uploads', component: myUploadFile },
    { path: '/charges', component: myCharges },
    { path: '/towns', component: myTown },
    { path: '/print', component: myWaybill },
    { path: '/sticker', component: mySticker },

    { path: '/status', component: myStatus },
    { path: '/country', component: myCountry },
    { path: '/rinders', component: myRinder },
    { path: '/unauthorized', component: myunauth },

    { path: '/clientDashboard', component: myCustDash },
    { path: '/rinderDashboard', component: myDrivDash },

    { path: '/', component: myDash },
    { path: '/statuses', component: myStatuses },
    { path: '/deliverystatus', component: myDStatus },
    { path: '/deliverystatus', component: myDStatus },

    { path: '/filter', component: myFilter },
    { path: '/chatty', component: myChatty },
    { path: '/finance', component: myFinance },
    { path: '/logs', component: myLogs },
    { path: '/schedulelogs', component: mySc },
    { path: '/api', component: profileDash },

]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        myHeader, myUser, myShipment, myScanner,
        myBranch, myProfile, myCompany, myCustomer, mysubsicriber,
        myReports, mybranchShip, myRoles, myscheduled, myTasks, myUploadFile, myCharges,
        myTown, myWaybill, myStatus, myStatuses, myCountry, myRinder, myCustDash, myDrivDash,
        myunauth, myDash, myFilter, myChatty, myFinance, myFinClient, mySticker, myDStatus, myLogs, mySc,
        passportAuthorizedclients, passportClients, passportPersonalaccesstokens, profileDash
        // Api
        // myContainer
    },
    // data: {
    //     messages: []
    // },

    // created() {
    //     this.fetchMessages();

    //     Echo.private('chat')
    //         .listen('MessageSent', (e) => {
    //             this.messages.push({
    //                 message: e.message.message,
    //                 user: e.user
    //             });
    //         });
    // },

    // methods: {
    //     fetchMessages() {
    //         axios.get('/messages').then(response => {
    //             this.messages = response.data;
    //         });
    //     },

    //     addMessage(message) {
    //         this.messages.push(message);

    //         axios.post('/messages', message).then(response => {
    //             console.log(response.data);
    //         });
    //     }
    // }
});
