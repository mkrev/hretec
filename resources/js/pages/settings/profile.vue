<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')" />

      <!-- Name -->
      <!--<div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
          <has-error :form="form" field="name" />
        </div>
      </div>-->

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.name"
            :class="{ 'is-invalid': form.errors.has('name') }"
            class="form-control"
            type="text"
            name="name"
            readonly
          />
          <has-error :form="form" field="name" />
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
        <div class="col-md-7">
          <input
            v-model="form.email"
            :class="{ 'is-invalid': form.errors.has('email') }"
            class="form-control"
            type="email"
            name="email"
          />
          <has-error :form="form" field="email" />
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
                id="photo"
                name="photo"
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
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from "vform";
import { objectToFormData } from 'object-to-formdata';
import { mapGetters } from "vuex";

export default {
 
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("settings") };
  },

  data: () => ({
    form: new Form({
      name: "",
      email: "",
      ideology_id: "",
      economy_id: "",
      party_id: "",
      photo: ""
    }),

    submitted: false
  }),

  computed: mapGetters({
    user: "auth/user",
    locale: "lang/locale",
  }),

  created() {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key];
    });
  },

  methods: {

    async update() {
      const { data } = await this.form.patch("/api/settings/profile", {
              // Transform form data to FormData
              transformRequest: [function (data, headers) {
                return objectToFormData(data)
              }]});

      this.$store.dispatch("auth/updateUser", { user: data });
    },
    fileSelected(event) {
      const file = event.target.files[0];
      this.$refs.customFileLabel.innerText = file.name;
      this.form.photo = file
     
    },
  }
};

</script>
