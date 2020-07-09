<template>
  <div class="row">
    <div class="col-md-6 m-auto">
      <card :title="$t('login')">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
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

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3" />
            <div class="col-md-7 d-flex">
              <checkbox v-model="remember" name="remember">{{ $t('remember_me') }}</checkbox>

              <router-link
                :to="{ name: 'password.request' }"
                class="small ml-auto my-auto"
              >{{ $t('forgot_password') }}</router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button class="btn-ournews" :loading="form.busy">{{ $t('login') }}</v-button>

              <!-- GitHub Login Button -->
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
import LoginWithGithub from "~/components/LoginWithGithub";
import { required, email, minLength } from "vuelidate/lib/validators";

export default {
  middleware: "guest",

  components: {
    LoginWithGithub
  },

  metaInfo() {
    return { title: this.$t("login") };
  },

  data: () => ({
    form: new Form({
      email: "",
      password: ""
    }),
    remember: false,
    submitted: false
  }),

  validations: {
    form: {
      email: { required, email },
      password: { required, minLength: minLength(6) }
    }
  },

  methods: {
    async login() {
      this.submitted = true;

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }

      // Submit the form.
      const { data } = await this.form.post("/api/login");

      // Save the token.
      this.$store.dispatch("auth/saveToken", {
        token: data.token,
        remember: this.remember
      });

      // Fetch the user.
      await this.$store.dispatch("auth/fetchUser");

      // Redirect home.
      this.$router.push({ name: "home" });
    }
  }
};
</script>
