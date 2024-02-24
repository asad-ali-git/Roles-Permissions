/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from "@/plugins";

// Components
import App from "./App.vue";

// Composables
import { createApp } from "vue";
import axios from "axios";

axios.interceptors.request.use((config) => {
  const token = localStorage.getItem("auth_key");
  if (token) {
    config.headers.auth_key = token;
  }
  return config;
});

const app = createApp(App);

registerPlugins(app);

app.mount("#app");
