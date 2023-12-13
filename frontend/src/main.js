import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import "bootstrap"
import "bootstrap/dist/css/bootstrap.css"
import router from "./router.js"
// import axios from "axios"
import axiosInstance from './axios.js'
import sanctumAxios from './sanctumAxios.js'
import {createPinia} from "pinia"
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import Swal from "sweetalert2"
import CKEditor from "@ckeditor/ckeditor5-vue"

const pinia=createPinia()
pinia.use(piniaPluginPersistedstate)
const app=createApp(App)
app.config.globalProperties.$axios=axiosInstance
app.config.globalProperties.$sanctum=sanctumAxios
app.config.globalProperties.$swal=Swal
app.use(pinia)
app.use(router)
app.use(autoAnimatePlugin)
app.mount('#app')
