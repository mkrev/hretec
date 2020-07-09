<template>
  <card :title="title">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')" />

      <!-- Title -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('Tytuł') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.title"
            :class="{ 'is-invalid': form.errors.has('title') }"
            class="form-control"
            type="text"
            name="title"
          />
          <has-error :form="form" field="title" />
        </div>
      </div>

      <!-- Content -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('Treść') }}</label>
        <div class="col-md-7">
          <textarea
            v-model="form.content"
            :class="{ 'is-invalid': form.errors.has('content') }"
            class="form-control"
            name="content"
            rows="3"
          ></textarea>
          <has-error :form="form" field="content" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('Zdjęcie') }}</label>
        <div class="col-md-6">
          <div class="input-group">
            <div class="custom-file">
              <input
                type="file"
                class="custom-file-input"
                id="file"
                name="file"
                :lang="locale"
                @change="fileSelected"
                aria-describedby="inputGroupFileAddon01"
              />
              <label
                class="custom-file-label"
                ref="customFileLabel"
                for="inputGroupFile01"
              >{{ $t('Wybierz plik') }}</label>
            </div>
            <button type="button" @click="removeFileSelected">{{ $t('Usuń') }}</button>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t(action) }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from "vform";
import { objectToFormData } from "object-to-formdata";
import { mapGetters } from "vuex";
import axios from "axios";

export default {
  middleware: "auth",

  data: () => ({
    action: "",
    title: "",
    form: new Form({ title: "", content: "", file: "" }),
    submitted: false
  }),

  computed: mapGetters({
    locale: "lang/locale"
  }),

  async created() {
    this.setTitle();
    const id = this.$route.params.id;

    if (id) {
      let { data } = await axios.get(`/api/edit/article/${id}`);
      this.form.fill(data);
    }
  },

  methods: {
    async create() {
      const url = this.isUpdate()
        ? `/api/update-or-create/article/${this.$route.params.id}`
        : "/api/update-or-create/article";
      const { data } = await this.form.post(url, {
        transformRequest: [
          function(data, headers) {
            return objectToFormData(data);
          }
        ]
      });
    },

    fileSelected(event) {
      const file = event.target.files[0];
      this.$refs.customFileLabel.innerText = file.name;
      this.form.file = file;
    },

    removeFileSelected(event) {
      this.$refs.customFileLabel.innerText = "";
      this.form.file = null;
    },

    setTitle() {
      const action = this.isUpdate() ? "Edytuj" : "Dodaj";
      this.action = this.$t(action);
      this.title = this.$t(action + " artykuł");
    },

    isUpdate() {
      return this.$route.params.id ? true : false;
    }
  }
};
</script>
