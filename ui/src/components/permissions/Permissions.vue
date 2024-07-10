<template>
  <v-card class="ma-5" elevation="4" flat>
    <template v-slot:title>
      <v-toolbar flat>
        <v-toolbar-title>Permissions</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn variant="elevated" color="blue-grey"> New Permission </v-btn>
      </v-toolbar>
    </template>
    <template v-slot:text>
      <v-text-field
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        variant="outlined"
        hide-details
        single-line
      ></v-text-field>
    </template>

    <v-data-table
      :loading="tableLoading"
      :headers="headers"
      :items="permissions"
      :sort-by="[{ key: 'id', order: 'asc' }]"
    >
      <template v-slot:item.status="{ item }">
        <v-chip color="success" variant="elevated">
          {{ item.status }}
        </v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          icon="mdi-pencil"
          class="me-3"
          size="large"
          @click="editItem(item)"
        />
        <v-icon icon="mdi-delete" size="large" @click="deleteItem(item)" />
      </template>
      <template v-slot:no-data> No Records </template>
    </v-data-table>
  </v-card>
</template>

<script>
import Loading from "@/components/general/Loading.vue";
import { useToast } from "vue-toastification";
import axios from "../../axios.js";
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
  data: () => ({
    tableLoading: false,
    search: "",
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        title: "Name",
        align: "start",
        sortable: false,
        key: "name",
      },
      { title: "Description", key: "description" },
      { title: "Status", key: "status" },
      { title: "Actions", key: "actions", sortable: false },
    ],
    permissions: [],
    editedItem: {
      name: "",
      description: "",
    },
  }),

  created() {
    this.getPermissions();
  },

  methods: {
    async getPermissions() {
      try {
        if (await this.v$.$validate()) {
          this.tableLoading = true;
          const { data } = await axios.get("/permissions", this.form);
          this.permissions = data.data;
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
        this.tableLoading = false;
      }
    },

    editItem(permission) {
      this.editedItem = Object.assign({}, permission);
      this.dialog = true;
    },

    deleteItem(permission) {
      this.dialogDelete = true;
    },
  },
};
</script>
