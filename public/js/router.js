import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

import myUser from './components/users/'




const routes = [
    { path: '/users', component: myUser },
]

export default new VueRouter({routes})
