import './bootstrap';
import { createApp } from 'vue';
import router from './router/index.js';


const app = createApp({});

import appComponent from './components/app.vue';
app.component('appComponent', appComponent);


app.use(router);
app.mount('#app');
