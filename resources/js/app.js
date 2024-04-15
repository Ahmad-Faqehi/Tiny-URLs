import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/scss/tailwind.scss'
import './assets/css/materialdesignicons.min.css'

createApp(App).use(router).mount('#app')
