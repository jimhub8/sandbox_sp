
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
import jsPDF from 'jsPDF'
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
let myStatuses = require('./components/status/Status.vue');
let myDStatus = require('./components/status/DStatus.vue');
// axios.defaults.baseURL = 'http://courier.dev/api/getData';
Vue.component('downloadExcel', JsonExcel)
// Vue.component('file-management', require('./components/upload/FileManagement.vue'));
// Vue.component('attachment-list', require('./components/upload/AttachmentList.vue'));
Vue.component('upload-list', require('./components/upload/Upload.vue'));

Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));


Vue.component('message', require('./components/message.vue'));
Vue.component('message', require('./components/chat/Message.vue'));
let myHeader = require('./components/include/Header.vue');
let myUser = require('./components/users/User.vue');
let myShipment = require('./components/shipments/Shipment.vue');
let myScanner = require('./components/scanner/Scanner.vue');
// let myContainer = require('./components/containers/Container.vue');
let myMap = require('./components/reports/Map.vue');
let myBranch = require('./components/branches/Branch.vue');
let myProfile = require('./components/users/Profile.vue');
let myCompany = require('./components/company/Company.vue');
let myCustomer = require('./components/customers/Customer.vue');
let mysubsicriber = require('./components/emails/Subscribe.vue');
let myInvice = require('./components/invoices/Invoice.vue');
let myReceipt = require('./components/receipt/Receipt.vue');
let myReports = require('./components/reports/Reports.vue');
let mybranchShip = require('./components/branches/BranchShipments.vue');
let myRoles = require('./components/users/roles/Roles.vue');
let myscheduled = require('./components/shipments/Scheduled.vue');
let myTasks = require('./components/tasks/Task.vue');
let myUploadFile = require('./components/upload/UploadFile.vue');
let myCharges = require('./components/charge/Charge.vue');
let myTown = require('./components/town/Town.vue');
let mySticker = require('./components/shipments/print/Sticker.vue');
let myWaybill = require('./components/shipments/print/Waybills.vue');
let myStatus = require('./components/shipments/status/Status.vue');
let myCountry = require('./components/country/Country.vue');
let myRinder = require('./components/drivers/Driver.vue');
let myunauth = require('./components/Unauthorized.vue');

let myCustDash = require('./components/customers/Dashboard.vue');
let myDrivDash = require('./components/drivers/Dashboard.vue');

let myDash = require('./components/App.vue');

let myFilter = require('./components/scanner/Filter.vue');
let myChatty = require('./components/chat/Chatty.vue');
let myFinance = require('./components/finance/Finance.vue');
let myFinClient = require('./components/finance/Clients.vue');
let myLogs = require('./components/splogs/Log.vue');
let mySc = require('./components/splogs/Schedule.vue');
let Api = require('./components/api/Api.vue');


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
    { path: '/invoices', component: myInvice },
    { path: '/receipts', component: myReceipt },
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
    { path: '/api', component: Api },

]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        myHeader, myUser, myShipment, myScanner, myMap,
        myBranch, myProfile, myCompany, myCustomer, mysubsicriber, myInvice, myReceipt,
        myReports, mybranchShip, myRoles, myscheduled, myTasks, myUploadFile, myCharges,
        myTown, myWaybill, myStatus, myStatuses, myCountry, myRinder, myCustDash, myDrivDash,
        myunauth, myDash, myFilter, myChatty, myFinance, myFinClient, mySticker, myDStatus, myLogs, mySc,
        passportAuthorizedclients, passportClients, passportPersonalaccesstokens,
        Api
        // myContainer
    },
    data: {
        messages: []
    },

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        }
    }
});
