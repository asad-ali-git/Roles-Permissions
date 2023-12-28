// Composables
import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  to.name !== "auth.login" && !localStorage.getItem("auth_key")
    ? next({ name: "auth.login" })
    : next();
});

export default router;
