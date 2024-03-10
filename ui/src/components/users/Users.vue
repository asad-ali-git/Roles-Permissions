<template>
  <h1 class="ml-5 mt-5">Users</h1>
</template>

<script>
import Loading from "@/components/general/Loading.vue";
import { useToast } from "vue-toastification";
import axios from "axios";
import { useVuelidate } from "@vuelidate/core";

export default {
  components: {
    Loading,
  },
  setup() {
    return {
      toast: useToast(),
      v$: useVuelidate(),
    };
  },
  data: () => {
    return {};
  },
  async created() {
    this.getUsers();
  },
  methods: {
    async getUsers() {
      try {
        if (await this.v$.$validate()) {
          this.loading = true;
          const response = await axios.get(
            import.meta.env.VITE_BASE_URL + "/api/users",
            this.form
          );
          console.log("response :", response);
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
