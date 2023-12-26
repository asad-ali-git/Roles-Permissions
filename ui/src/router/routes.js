const routes = [
  // AUTH ROUTES
  {
    path: "/auth",
    children: [
      {
        path: "login",
        name: "login",
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
        name: "Home",
        component: () => import("@/views/Home.vue"),
      },
    ],
  },
];

export default routes;
