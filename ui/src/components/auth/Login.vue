<template>
  <div class="d-flex align-center" style="height: 100vh">
    <v-card class="mx-auto" width="500">
      <v-form fast-fail @submit.prevent="submit">
        <v-toolbar flat>
          <v-btn icon="mdi-account"></v-btn>

          <v-toolbar-title class="font-weight-light"> Login </v-toolbar-title>
        </v-toolbar>

        <v-card-text>
          <v-text-field
            class="mb-3"
            v-model="form.email"
            label="E-mail"
            hide-details
            required
          ></v-text-field>

          <v-text-field
            type="password"
            label="Password"
            v-model="form.password"
            hide-details
            required
          ></v-text-field>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn type="submit" color="blue-grey"> Login </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>

    <Loading v-if="loading" />
  </div>
</template>

<script setup>
import Form from "vform";
import Loading from "../general/Loading.vue";
</script>

<script>
export default {
  data: () => ({
    form: new Form({
      email: "",
      password: "",
    }),
    loading: false,
  }),

  methods: {
    async submit() {
      try {
        this.loading = true;
        const response = await this.form.post(
          "http://127.0.0.1:8000/api/auth/login"
        );

        if (!response?.data?.error && response?.status == 200) {
          console.log(response?.data?.message);
          localStorage.setItem("auth_key", response?.data?.auth_key);
          this.$router.push({ name: "home" });
        }
        this.loading = false;
      } catch (error) {
        console.log("error :", error);
        this.loading = false;
      }
    },
  },
};
</script>

<style></style>
