<template>
  <v-client-table :columns="columns" v-model="data" :options="options">
    <router-link
      slot="uri"
      slot-scope="props"
      target="_blank"
      :to="{ name: 'video', params: { id: props.row.id } }"
    >
      <i class="fas fa-eye"></i>
    </router-link>
    <div slot="actions" slot-scope="{row}">
      <div>
        <router-link :to="{ name: 'edit.video', params: { id: row.id } }">
          <i class="fas fa-edit"></i>
        </router-link>
        <a href="#" @click.prevent="remove(row.id)">
          <i class="fas fa-trash"></i>
        </a>
      </div>
    </div>
  </v-client-table>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  middleware: "auth",

  data: () => ({
    isEditId: null,
    columns: ["title", "created_at", "uri", "actions"],
    data: [],
    options: {
      headings: {},
      editableColumns: ["name"],
      sortable: ["title", "created_at"],
      filterable: ["title", "created_at"]
    }
  }),

  async created() {
    this.options.headings = {
      title: this.$t("Tytuł"),
      created_at: this.$t("Data dodania"),
      uri: this.$t("Zobacz"),
      actions: this.$t("Akcje")
    };
    let { data } = await axios.get(`/api/user/videos`);
    this.data = data;
  },

  methods: {
    async update(video) {},
    async remove(id) {
      let { data } = await axios.delete(`/api/video/${id}`);
      if (data) {
        let rows = this.data;
        rows.splice(
          rows.findIndex(function(i) {
            return i.id === id;
          }),
          1
        );
      }
    }
  }
};
</script>
