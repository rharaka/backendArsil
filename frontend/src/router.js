import { createRouter, createWebHashHistory } from "vue-router";
import Login from './components/Login.vue';
import Logout from './components/Logout.vue';
import Register from './components/Register.vue';
import AddShipment from './components/AddShipment.vue';
import myShipments from './components/myShipments.vue';
import CheckOut from "./components/CheckOut.vue";

const routes = [
    {
        name: 'Login',
        path: '/Login',
        component: Login,
        meta: {public: true}
    },
    {
        name: 'Logout',
        path: '/logout',
        component: Logout,
        meta: {public: false}
    },
    {
        name: 'Register',
        path: '/Register',
        component: Register,
        meta: {public: true}
    },
    {
        name: 'AddShipment',
        path: '/add-shipment',
        component: AddShipment,
        meta: {public: true}
    },
    {
        name: 'myShipments',
        path: '/my-shipments',
        component: myShipments,
        meta: {public: false}
    },
    {
        name: 'Home',
        path: '/',
        component: AddShipment,
        meta: {public: true}
    },
    {
        name: 'Checkout',
        path: '/checkout',
        component: CheckOut,
        meta: {public: true},
        props: true
    }
];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

// router.beforeEach((to, from, next) => {
//     const isAuthenticated = !!localStorage.getItem('token');
//     if(!to.meta.public && !isAuthenticated) {
//         next({name: 'Login'});
//     } 
//     else {
//         next();
//     }
// });

export default router;