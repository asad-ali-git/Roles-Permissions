<template>
  <v-app>
    <v-layout class="rounded rounded-md">
      <default-bar />

      <default-view />
    </v-layout>
  </v-app>
</template>

<script setup>
import DefaultBar from "./AppBar.vue";
import DefaultView from "./View.vue";
</script>
