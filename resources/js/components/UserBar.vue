<template>
  <div v-if="user" class="nav-item dropdown">
    <a
      class="nav-link dropdown-toggle text-dark"
      href="#"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <img :src="user.photo" class="rounded-circle profile-photo mr-1" />
      {{ user.name }}
    </a>
    <div class="dropdown-menu userbar">
      <router-link
        v-for="(tab,key) in tabs"
        :key="key"
        :to="{ name: tab.route }"
        class="dropdown-item pl-3"
      >
        <i :class="tab.icon"></i>
        <span class="d-none d-md-inline-block w-100" @click="tab.func">{{ tab.name }}</span>
      </router-link>
      <!--<router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
        <fa icon="cog" fixed-width />
        {{ $t('settings') }}
      </router-link>

      <div class="dropdown-divider" />
      <router-link :to="{ name: 'creates.article' }" class="dropdown-item pl-3">
        <fa icon="cog" fixed-width />
        {{ $t('Utwórz') }}
      </router-link>-->

      <div class="dropdown-divider" />
      <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
        <fa icon="sign-out-alt" fixed-width />
        {{ $t('logout') }}
      </a>
    </div>
  </div>
</template>


<script>
export default {
  name: "UserBar",
  props: ['user'],
  computed: {
    tabs() {
      return [
        {
          icon: "fa fa-cog",
          name: this.$t("settings"),
          route: "settings.profile",
          func: this.hideSideBar
        },
        {
          icon: "fa fa-cog",
          name: this.$t("Utwórz"),
          route: "create.article",
          func: this.hideSideBar
        },
        {
          icon: "fa fa-cog",
          name: this.$t("Twoje materiały"),
          route: "list.article",
          func: this.hideSideBar
        },
      ];
    },
    /*user(){
        return this.$store.getters["auth/user"]
    }*/
  },
    methods: {
      async logout() {
        // Log out the user.
        await this.$store.dispatch("auth/logout");

        // Redirect to login.
        this.$router.push({ name: "login" });
      },
      hideSideBar(){
          this.$store.commit('elements_state/setVisibleSideBar', false)
      }
    }
};
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -0.375rem 0;
}
</style>


