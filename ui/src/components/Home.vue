<template>
  <v-container>
    <v-row no-gutters>
      <v-col v-for="card in cards" :key="card.route" cols="12" md="4">
        <v-card
          class="ma-2 pa-2 d-flex justify-space-between align-center cursor-pointer"
          variant="tonal"
          @click="$router.push({ name: card.route })"
        >
          <template v-slot:title> {{ card.title }} </template>
          <v-icon :icon="card.icon" size="x-large"></v-icon>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
const cards = [
  {
    title: "Permissions",
    icon: "mdi-book-open-page-variant-outline",
    route: "permissions",
  },
  {
    title: "Roles",
    icon: "mdi-account-star-outline",
    route: "roles",
  },
  {
    title: "Users",
    icon: "mdi-account-group-outline",
    route: "users",
  },
];
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
