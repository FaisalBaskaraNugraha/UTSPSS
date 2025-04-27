// src/main.js
import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // Import router
import './style.css' // Import CSS global

const app = createApp(App)

app.use(router) // Gunakan router

app.mount('#app')