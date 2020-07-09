<template>
  <div class="row">
    <div class="col-md-6 m-auto">
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">{{ $t('verify_email_address') }}</div>
      </card>
      <card v-else :title="$t('register')">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
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
                maxlength="20"
              />
              <div v-if="submitted && $v.form.name.$error" class="invalid-feedback d-block">
                <span v-if="!$v.form.name.required">{{$t('Nazwa użytkownika jest wymagana')}}</span>
                <span
                  v-if="!$v.form.name.alphaNum"
                >{{$t('Nazwa użytkownika może zawierać tylko litery i cyfry')}}</span>
                <span
                  v-if="!$v.form.name.maxLength"
                >{{$t('Nazwa użytkownika może mieć conajwyżej 20 znaków')}}</span>
              </div>
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
              <div v-if="submitted && $v.form.email.$error" class="invalid-feedback d-block">
                <span v-if="!$v.form.email.required">{{$t('Email jest wymagany')}}</span>
                <span v-if="!$v.form.email.email">{{$t('Email jest niewłaściwy')}}</span>
              </div>
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input
                v-model="form.password"
                :class="{ 'is-invalid': form.errors.has('password') }"
                class="form-control"
                type="password"
                name="password"
              />
              <div v-if="submitted && $v.form.password.$error" class="invalid-feedback d-block">
                <span v-if="!$v.form.password.required">{{$t('Hasło jest wymagane')}}</span>
                <span
                  v-if="!$v.form.password.minLength"
                >{{$t('Hasło musi mieć conajmniej 6 znaków')}}</span>
              </div>
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input
                v-model="form.password_confirmation"
                :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                class="form-control"
                type="password"
                name="password_confirmation"
              />
              <div
                v-if="submitted && $v.form.password_confirmation.$error"
                class="invalid-feedback"
              >
                <span v-if="!$v.form.password_confirmation.required">Confirm Password is required</span>
                <span v-else-if="!$v.form.password_confirmation.sameAsPassword">Passwords must match</span>
              </div>
              <has-error :form="form" field="password_confirmation" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('Światopogląd') }}</label>
            <div class="col-md-6">
              <select
                v-model="form.ideology_id"
                :class="{ 'is-invalid': form.errors.has('ideology_id') }"
                class="form-control"
                name="ideology_id"
              >
                <option></option>
                <option
                  v-for="(ideology,key) in politicalViews.ideologies"
                  :key="key"
                  :value="ideology.id"
                >{{ ideology.name }}</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('System ekonomiczny') }}</label>
            <div class="col-md-6">
              <select
                v-model="form.economy_id"
                :class="{ 'is-invalid': form.errors.has('ideology_id') }"
                class="form-control"
                name="economy_id"
              >
                <option></option>
                <option
                  v-for="(economy,key) in politicalViews.economies"
                  :key="key"
                  :value="economy.id"
                >{{ economy.name }}</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('Partia polityczna') }}</label>
            <div class="col-md-6">
              <select
                v-model="form.party_id"
                :class="{ 'is-invalid': form.errors.has('ideology_id') }"
                class="form-control"
                name="party_id"
              >
                <option></option>
                <option
                  v-for="(party,key) in politicalViews.parties"
                  :key="key"
                  :value="party.id"
                >{{ party.name }}</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button class="btn-ournews" :loading="form.busy">{{ $t('register') }}</v-button>

              <!-- GitHub Register Button -->
              <login-with-github />
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";
import LoginWithGithub from "~/components/LoginWithGithub";
import axios from "axios";
import {
  required,
  email,
  minLength,
  maxLength,
  sameAs,
  alphaNum
} from "vuelidate/lib/validators";

export default {
  middleware: ["guest", "political_views"],
  //middleware: ["guest"],

  components: {
    LoginWithGithub
  },

  metaInfo() {
    return { title: this.$t("register") };
  },

  data: () => ({
    form: new Form({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      ideology_id: "",
      economy_id: "",
      party_id: ""
    }),
    mustVerifyEmail: false,
    ideologies: "",
    economies: "",
    parties: "",
    submitted: false
  }),

  computed: mapGetters({
    politicalViews: "basic_data/politicalViews"
  }),

  validations: {
    form: {
      name: { required, maxLength: maxLength(20), alphaNum },
      email: { required, email },
      password: { required, minLength: minLength(6) },
      password_confirmation: { required, sameAsPassword: sameAs("password") }
    }
  },

  methods: {
    async register() {
      this.submitted = true;

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }

      // Register the user.
      const { data } = await this.form.post("/api/register");

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true;
      } else {
        // Log in the user.
        const {
          data: { token }
        } = await this.form.post("/api/login");

        // Save the token.
        this.$store.dispatch("auth/saveToken", { token });

        // Update the user.
        await this.$store.dispatch("auth/updateUser", { user: data });

        // Redirect home.
        this.$router.push({ name: "home" });
      }
    }
  }
};
</script>
