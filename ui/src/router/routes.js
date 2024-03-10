const routes = [
  // AUTH ROUTES
  {
    path: "/auth",
    beforeEnter: (to, from, next) => {
      localStorage.getItem("token") ? next({ name: "home" }) : next();
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
    component: () => import("@/layouts/AppLayout.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("@/components/Home.vue"),
      },
      {
        path: "permissions",
        name: "permissions",
        component: () => import("@/components/permissions/Permissions.vue"),
      },
      {
        path: "roles",
        name: "roles",
        component: () => import("@/components/roles/Roles.vue"),
      },
      {
        path: "users",
        name: "users",
        component: () => import("@/components/users/Users.vue"),
      },
    ],
  },
];

export default routes;
