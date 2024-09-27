import { createRouter, createWebHistory } from "vue-router";
import appComponent from '../components/app.vue';


const routes = [
    {
        'path' : '/',
        'component': appComponent
    },
    {
        'path' : '/index',
        component: () => import('../components/index.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
