const routes = [
  // AUTH ROUTES
  {
    path: "/auth",
    beforeEnter: (to, from, next) => {
      localStorage.getItem("auth_key") ? next({ name: "home" }) : next();
    },
    children: [
      {
        path: "login",
        name: "auth.login",
        component: () => import("@/components/auth/Login.vue"),
      },
    ],
  },

  {
    path: "/",
    component: () => import("@/layouts/default/Default.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("@/views/Home.vue"),
      },
    ],
  },
];

export default routes;
