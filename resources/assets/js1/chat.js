
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
        libraries: 'places',
    },
})
// Vue.use(VueResource);

Vue.use(Print);
Vue.use(Vuetify)
Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let myStatuses = require('./components/status/Status.vue');
// axios.defaults.baseURL = 'http://courier.dev/api/getData';
Vue.component('downloadExcel', JsonExcel)
// Vue.component('file-management', require('./components/upload/FileManagement.vue'));
// Vue.component('attachment-list', require('./components/upload/AttachmentList.vue'));
Vue.component('upload-list', require('./components/upload/Upload.vue'));

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
let myPrintPdf = require('./components/shipments/PrintPdf.vue');
let myStatus = require('./components/shipments/status/Status.vue');
let myCountry = require('./components/country/Country.vue');
let myRinder = require('./components/drivers/Driver.vue');
let myunauth = require('./components/Unauthorized.vue');

let myCustDash = require('./components/customers/Dashboard.vue');
let myDrivDash = require('./components/drivers/Dashboard.vue');

let myDash = require('./components/App.vue');

let myFilter = require('./components/scanner/Filter.vue');
let myChatty = require('./components/chat/Chatty.vue');


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
    { path: '/print', component: myPrintPdf },
    { path: '/status', component: myStatus },
    { path: '/country', component: myCountry },
    { path: '/rinders', component: myRinder },
    { path: '/unauthorized', component: myunauth },

    { path: '/clientDashboard', component: myCustDash },
    { path: '/rinderDashboard', component: myDrivDash },

    { path: '/', component: myDash },
    { path: '/statuses', component: myStatuses },

    { path: '/filter', component: myFilter },
    { path: '/chatty', component: myChatty },

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
        myTown, myPrintPdf, myStatus, myStatuses, myCountry, myRinder, myCustDash, myDrivDash,
        myunauth, myDash, myFilter, myChatty,
        // myContainer
    },
    data: {
        shipments: [],
        loading: false,
        error: false,
        query: '',
        // chats: '',

        chatMessage: [],

        userId: null,

        chats: [],

        chatWindows: [],

        chatStatus: 0,

        chatWindowStatus: [],

        chatCount: []
    },
    // methods: {

    //     search: function () {
    //         // Clear the error message.
    //         this.error = '';
    //         // Empty the shipments array so we can fill it with the new shipments.
    //         this.shipments = [];
    //         // Set the loading property to true, this will display the "Searching..." button.
    //         this.loading = true;

    //         // Making a get request to our API and passing the query to it.
    //         this.$http.get('/search?q=' + this.query).then((response) => {
    //             // If there was an error set the error message, if not fill the shipments array.
    //             response.body.error ? this.error = response.body.error : this.shipments = response.body;
    //             // The request is finished, change the loading to false again.
    //             this.loading = false;
    //             // Clear the query.
    //             this.query = '';
    //         });
    //     }
    // },


    created() {

        window.Echo.channel('chat-message' + window.userid)

            .listen('ChatMessage', (e) => {

                console.log(e.user);

                this.userId = e.user.sourceuserid;

                if (this.chats[this.userId]) {

                    this.show = 1;

                    this.$set(app.chats[this.userId], this.chatCount[this.userId], e.user);

                    this.chatCount[this.userId]++;

                    console.log("pusher");

                    console.log(this.chats[this.userId]);

                } else {

                    this.createChatWindow(e.user.sourceuserid, e.user.name)

                    this.$set(app.chats[this.userId], this.chatCount[this.userId], e.user);

                    this.chatCount[this.userId]++;

                }

            });

    },

    http: {

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    },

    methods: {

        sendMessage(event) {

            this.userId = event.target.id;

            var message = this.chatMessage[this.userId];

            axios.post('chat', {

                'userid': this.userId,

                'message': message

            })
                .then((response) => {


                    this.chatMessage[this.userId] = '';

                    this.$set(app.chats[this.userId], this.chatCount[this.userId], {

                        "message": message,

                        "name": window.username

                    });

                    this.chatCount[this.userId]++;

                    console.log("send");
                })
                .catch((error) => {
                    console.log(response);
                    this.errors = error.response.data.errors
                })


            // this.$http.post('chat', {

            //     'userid': this.userId,

            //     'message': message

            // }).then(response => {

            //     this.chatMessage[this.userId] = '';

            //     this.$set(app.chats[this.userId], this.chatCount[this.userId], {

            //         "message": message,

            //         "name": window.username

            //     });

            //     this.chatCount[this.userId]++;

            //     console.log("send");

            // }, response => {

            //     this.error = 1;

            //     console.log("error");

            //     console.log(response);

            // });

        },

        getUserId(event) {

            this.userId = event.target.id;

            this.createChatWindow(this.userId, event.target.innerHTML);

            console.log(this.userId);

        },

        createChatWindow(userid, username) {

            if (!this.chatWindowStatus[userid]) {

                this.chatWindowStatus[userid] = 1;

                this.chatMessage[userid] = '';

                this.$set(app.chats, userid, {});

                this.$set(app.chatCount, userid, 0);

                this.chatWindows.push({ "senderid": userid, "name": username });

            }

        }
    }
    // mounted() {
    //     Echo.private('chat_channel')
    //         .listen('chat_save', (e) => {
    //             console.log(e);
    //         });
});




















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
        libraries: 'places',
    },
})
// Vue.use(VueResource);

Vue.use(Print);
Vue.use(Vuetify)
Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let myStatuses = require('./components/status/Status.vue');
// axios.defaults.baseURL = 'http://courier.dev/api/getData';
Vue.component('downloadExcel', JsonExcel)
// Vue.component('file-management', require('./components/upload/FileManagement.vue'));
// Vue.component('attachment-list', require('./components/upload/AttachmentList.vue'));
Vue.component('upload-list', require('./components/upload/Upload.vue'));

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
let myPrintPdf = require('./components/shipments/PrintPdf.vue');
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
    { path: '/print', component: myPrintPdf },
    { path: '/status', component: myStatus },
    { path: '/country', component: myCountry },
    { path: '/rinders', component: myRinder },
    { path: '/unauthorized', component: myunauth },

    { path: '/clientDashboard', component: myCustDash },
    { path: '/rinderDashboard', component: myDrivDash },

    { path: '/', component: myDash },
    { path: '/statuses', component: myStatuses },

    { path: '/filter', component: myFilter },
    { path: '/chatty', component: myChatty },
    { path: '/finance', component: myFinance },
    { path: '/clients', component: myFinClient },

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
        myTown, myPrintPdf, myStatus, myStatuses, myCountry, myRinder, myCustDash, myDrivDash,
        myunauth, myDash, myFilter, myChatty,myFinance, myFinClient
        // myContainer
    },
    data: {
        role: '',
        message:'',
        chat:{
            message:[],
            user:[],
            color:[],
            time:[]
        },
        typing:'',
        numberOfUsers:0,
        shipments: [],
        loading: false,
        error: false,
        query: '',
        // chats: '', 
    }, watch: {
        message() {
            Echo.private('chat')
                .whisper('typing', {
                    name: this.message
                });
        }
    },
    methods: {
        send() {
            if (this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.color.push('success');
                this.chat.user.push('me');
                this.chat.time.push(this.getTime());
                axios.post('/send', {
                    message: this.message,
                    chat: this.chat
                })
                    .then(response => {
                        console.log(response);
                        this.message = ''
                        // this.$toaster.success('success');
                    })
                    .catch(error => {
                        console.log(error);
                        // this.$toaster.error('failed');
                    });
            }
        },
        getTime() {
            let time = new Date();
            return time.getHours() + ':' + time.getMinutes();
        },
        getOldMessages() {
            axios.post('/getOldMessage')
                .then(response => {
                    console.log(response);
                    if (response.data != '') {
                        this.chat = response.data;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteSession() {
            axios.post('/deleteSession')
                .then(response => this.$toaster.success('Chat history is deleted'));
        }
    },
    mounted() {
        axios.post('/getRole')
            .then((response) => this.role = response.data)
            .catch((error) => this.errors = error.response.data.errors)


        this.getOldMessages();
        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user);
                this.chat.color.push('warning');
                this.chat.time.push(this.getTime());
                axios.post('/saveToSession', {
                    chat: this.chat
                })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                // console.log(e);
            })
            .listenForWhisper('typing', (e) => {
                if (e.name != '') {
                    this.typing = 'typing...'
                } else {
                    this.typing = ''
                }
            })

        Echo.join(`chat`)
            .here((users) => {
                this.numberOfUsers = users.length;
            })
            .joining((user) => {
                this.numberOfUsers += 1;
                // console.log(user);
                this.$toaster.success(user.name + ' has joined the chat room');
            })
            .leaving((user) => {
                this.numberOfUsers -= 1;
                this.$toaster.warning(user.name + ' has left the chat room');
            });
    }
});
