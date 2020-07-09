<template>
  <v-client-table :columns="columns" v-model="data" :options="options">
    <router-link
      slot="uri"
      slot-scope="props"
      target="_blank"
      :to="{ name: 'article', params: { id: props.row.id } }"
    >
      <i class="fas fa-eye"></i>
    </router-link>
    <div slot="actions" slot-scope="{row}">
      <div>
        <router-link :to="{ name: 'edit.article', params: { id: row.id } }">
          <i class="fas fa-edit"></i>
        </router-link>
        <a href="#" @click.prevent="remove(row.id)">
          <i class="fas fa-trash"></i>
        </a>
      </div>
    </div>

    <!--<div slot="title" slot-scope="{row}">
      <span @click="isEditId=row.id" v-if="isEditId != row.id">{{row.title}}</span>
      <span v-else>
        <input type="text" v-model="row.title" />
        <button type="button" class="btn btn-info btn-xs" @click="update(row)">Submit</button>
        <button type="button" class="btn btn-default btn-xs" @click="isEditId=null">Cancel</button>
      </span>
    </div>-->
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
    let { data } = await axios.get(`/api/user/articles`);
    this.data = data;
  },

  methods: {
    async update(article) {},
    async remove(id) {
      let { data } = await axios.delete(`/api/article/${id}`);
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
