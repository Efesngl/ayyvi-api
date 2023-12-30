import { createApp } from "vue";
import "./style.css";
import "bootstrap";
import "bootstrap/dist/css/bootstrap.css";
import App from "./App.vue";
import router from "./router.js";
import a from "./axios.js";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import { autoAnimatePlugin } from "@formkit/auto-animate/vue";
import Swal from "sweetalert2";

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
const app = createApp(App);
app.config.globalProperties.$axios = a;
app.config.globalProperties.apiURL="http://localhost:8000"
app.config.globalProperties.$swal = Swal;
app.use(pinia);
app.use(router);
app.use(autoAnimatePlugin);
app.mount("#app");
