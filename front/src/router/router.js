import {createRouter, createWebHistory} from 'vue-router'

import Signin from '../components/Authentication/Signin.vue'
import Register from '../components/Authentication/Signup.vue'
import CategoryView from '../view/CategoryView.vue'
import MyEventView from '../view/MyEventView.vue'
import FindEventView from '../view/FindEventView.vue'

const routes = [
    {
        path: '/',
        component: Signin,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/signin',
        component: Signin
    },
    {
        path: '/my-event',
        component: MyEventView
    },
    {
        path: '/find-event',
        component: FindEventView
    },
    {
        path: '/category',
        component: CategoryView
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;