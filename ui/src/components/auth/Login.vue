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
            label="Email"
            :error-messages="
              v$.form.email.$errors.map((e) => formatErrorMsg(e))
            "
            @input="v$.form.email.$touch"
            @blur="v$.form.email.$touch"
          ></v-text-field>

          <v-text-field
            type="password"
            label="Password"
            v-model="form.password"
            :error-messages="
              v$.form.password.$errors.map((e) => formatErrorMsg(e))
            "
            @input="v$.form.password.$touch"
            @blur="v$.form.password.$touch"
          ></v-text-field>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn variant="elevated" type="submit" color="blue-grey">
            Login
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>

    <Loading v-if="loading" />
  </div>
</template>

<script>
import Loading from "@/components/general/Loading.vue";
import { useToast } from "vue-toastification";
import axios from "axios";
import { useVuelidate } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";

export default {
  setup() {
    return {
      toast: useToast(),
      v$: useVuelidate(),
    };
  },

  components: {
    Loading,
  },

  data: () => ({
    form: {
      email: "",
      password: "",
    },
    loading: false,
  }),

  validations() {
    return {
      form: {
        email: { required, email },
        password: { required },
      },
    };
  },

  methods: {
    async submit() {
      try {
        if (await this.v$.$validate()) {
          this.loading = true;
          const response = await axios.post(
            import.meta.env.VITE_BASE_URL + "/api/auth/login",
            this.form
          );

          if (!response?.data?.error && response?.status == 200) {
            localStorage.setItem("auth_key", response?.data?.auth_key);
            this.toast.success(response?.data?.message);
            this.$router.push({ name: "home" });
          }
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

    formatErrorMsg(error) {
      return error.$message.replace(
        "Value",
        error.$property.charAt(0).toUpperCase() + error.$property.slice(1)
      );
    },
  },
};
</script>

<style></style>
