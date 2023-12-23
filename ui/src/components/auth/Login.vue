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

          <v-btn type="submit" color="green"> Login </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </div>
</template>

<script>
import Form from "vform";

export default {
  data: () => ({
    form: new Form({
      email: "",
      password: "",
    }),
  }),

  methods: {
    async submit() {
      console.log(this.form);
      return;
      const response = await this.form.post("/api/login");
    },
  },
};
</script>

<style></style>
