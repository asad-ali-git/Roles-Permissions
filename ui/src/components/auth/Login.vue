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

<script>
import Form from "vform";
import Loading from "../general/Loading.vue";
import { useToast } from "vue-toastification";
import config from "../../../config";

export default {
  setup() {
    const toast = useToast();
    return { toast };
  },

  components: {
    Loading,
  },

  data: () => ({
    form: new Form({
      email: "",
      password: "",
    }),
    loading: false,
  }),

  created() {
    console.log('apiBaseUrl :', config.apiBaseUrl);
  },
  methods: {
    async submit() {
      try {
        this.loading = true;
        const response = await this.form.post(
          "http://127.0.0.1:8000/api/auth/login"
        );

        if (!response?.data?.error && response?.status == 200) {
          localStorage.setItem("auth_key", response?.data?.auth_key);
          this.toast.success(response?.data?.message);
          this.$router.push({ name: "home" });
        }
      } catch (error) {
        if (error.response.status === 422) {
          const errorsMessage = error.response.data.errors;
          Object.keys(errorsMessage).forEach((key) => {
            if (typeof errorsMessage[key][0] == "string") {
              this.toast.error(errorsMessage[key][0]);
            }
          });
        } else {
          this.toast.error("API Error on server side");
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style></style>
