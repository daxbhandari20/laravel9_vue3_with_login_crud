import { createApp } from 'vue';
import './bootstrap';

import app from './layouts/App.vue'
import router from './router.js';
import store from './store/index.js';

createApp(app).use(router).use(store).mount('#app');
