import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from "vue-router";
import Signup from './components/Authentication/Signup.vue'
import Signin from './components/Authentication/Signin.vue'
import EventNav from './components/Navigation/EventNav.vue'

import CategoryForm from './components/Pages/Category/CategoryForm.vue';
import CategoryView from './components/Pages/Category/CategoryView.vue';
import CategoryCard from './components/Pages/Category/CategoryCard.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {path: "/", component: Signin},
      {path: "/register", component: Signup},
      {path: "/signin", component: Signin},
      {path: "/home", component: EventNav},
    ],
});

const app = createApp(App);
app.component('event-nav', EventNav);

app.component('category-form', CategoryForm);
app.component('category-view', CategoryView);
app.component('category-card', CategoryCard);

app.use(router)

app.mount('#app');





