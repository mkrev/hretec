<template>
  <header class="menu nav">
    <nav class="navbar navbar-dark">
      <div class="d-flex flex-row align-items-center">
        <SideBar/>

        <router-link :to="{ name: 'home' }" class="navbar-brand">{{ appName }}</router-link>
      </div>

      <div class="form-inline">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="" />
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </div>

      <!--<LocaleDropdown />-->
      <div>
        <!-- Authenticated -->
        <UserBar :user="user" v-if="user" />
        <!-- Guest -->
        <template v-else>
          <router-link :to="{ name: 'login' }" class active-class="active">{{ $t('login') }}</router-link>
          <router-link :to="{ name: 'register' }" class active-class="active">{{ $t('register') }}</router-link>
        </template>
      </div>
    </nav>
  </header>
</template>

<script>
import { mapGetters } from "vuex";
import LocaleDropdown from "./LocaleDropdown";
import SideBar from "./SideBar";
import UserBar from "./UserBar";

export default {
  components: {
    LocaleDropdown,
    SideBar,
    UserBar
  },

  data: () => ({
    appName: window.config.appName,
    visibleSideBar: true
  }),

  computed: mapGetters({
    user: "auth/user"
  }),
 
};
</script>

