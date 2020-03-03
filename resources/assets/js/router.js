import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

// import myUser from './components/users/'

import myUser from './components/users/User.vue';
import myClients from './components/users/clients';
import myRiders from './components/users/rider';
import myShipment from './components/shipments/Shipment.vue';
import myScanner from './components/scanner/Scanner.vue';
// import myContainer from './components/containers/Container.vue';
import myMap from './components/reports/Map.vue';
import myBranch from './components/branches/Branch.vue';
import myProfile from './components/users/Profile.vue';
import myCompany from './components/company/Company.vue';
import myCustomer from './components/customers/Customer.vue';
import mysubsicriber from './components/emails/Subscribe.vue';
// import myInvice from './components/invoices/Invoice.vue';
// import myReceipt from './components/receipt/Receipt.vue';
import myReports from './components/reports/Reports.vue';
import mybranchShip from './components/branches/BranchShipments.vue';
import myRoles from './components/users/roles/Roles.vue';
// import myscheduled from './components/shipments/Scheduled.vue';
// import myTasks from './components/tasks/Task.vue';
// import myUploadFile from './components/upload/UploadFile.vue';
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


import myDispatch from './components/scanner/dispatch'

import myUpdate from './components/shipments/update/Returns'

import mySendSms from './components/shipments/sms/Sendsms'

import myStatuses from './components/status/Status.vue';
import myDStatus from './components/status/DStatus.vue';
import myShipentUpdates from './components/shipment_status';

const routes = [
    // {path: '/', component: dashboard },
    { path: '/users', component: myUser },
    { path: '/clients', component: myClients },
    { path: '/riders', component: myRiders },
    { path: '/shipments', component: myShipment },
    { path: '/scanner', component: myScanner },
    // {path: '/containers', component: myContainer },
    { path: '/branches', component: myBranch },
    { path: '/profile', component: myProfile },
    { path: '/company', component: myCompany },
    // { path: '/subscribers', component: mysubsicriber },
    { path: '/customers', component: myCustomer },
    // { path: '/invoices', component: myInvice },
    // { path: '/receipts', component: myReceipt },
    { path: '/reports', component: myReports },
    { path: '/roles', component: myRoles },
    { path: '/branch/:id', component: mybranchShip },
    // { path: '/scheduled', component: myscheduled },
    // { path: '/tasks', component: myTasks },
    // { path: '/uploads', component: myUploadFile },
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

    // { path: '/screen', component: myScreen },

    { path: '/dispatch', component: myDispatch },

    { path: '/sms', component: mySendSms },
    { path: '/update', component: myUpdate },
    { path: '/shipment_status', component: myShipentUpdates },
]


export default new VueRouter({routes})
