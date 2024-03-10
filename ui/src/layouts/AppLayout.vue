<template>
  <v-layout class="rounded rounded-md">
    <v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
      @click="rail = false"
    >
      <v-list-item
        prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
        title="John Leider"
        nav
      >
        <template v-slot:append>
          <v-btn
            variant="text"
            icon="mdi-chevron-left"
            @click.stop="rail = !rail"
          ></v-btn>
        </template>
      </v-list-item>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <v-list-item
          v-for="sideMenu in sideMenus"
          :key="sideMenu.value"
          :prepend-icon="sideMenu.icon"
          :title="sideMenu.title"
          :value="sideMenu.value"
          @click="$router.push({ name: sideMenu.route })"
          :active="$route.name == sideMenu.route"
        ></v-list-item>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn @click="logout" block variant="elevated" color="error">
            Logout
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar :elevation="2" rounded>
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      </template>

      <v-app-bar-title class="font-weight-bold"
        >Roles Permissions</v-app-bar-title
      >
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-layout>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const sideMenus = [
  {
    title: "Home",
    icon: "mdi-home-outline",
    value: "home",
    route: "home",
  },
  {
    title: "Permissions",
    icon: "mdi-book-open-page-variant-outline",
    value: "permissions",
    route: "permissions",
  },
  {
    title: "Roles",
    icon: "mdi-account-star-outline",
    value: "roles",
    route: "roles",
  },
  {
    title: "Users",
    icon: "mdi-account-group-outline",
    value: "users",
    route: "users",
  },
];

const drawer = ref(true);
const rail = ref(false);
const router = useRouter();

const logout = async () => {
  try {
    const response = await axios.post(
      import.meta.env.VITE_BASE_URL + "/api/auth/logout"
    );
    console.log(response.data.message);

    localStorage.removeItem("token");
    await router.push({ name: "auth.login" });
  } catch (error) {
    console.error(error);
  }
};
</script>
