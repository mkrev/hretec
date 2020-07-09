<template>
  <div class="row justify-content-center">
    <div class="col-1 px-0 collapse width show sidebar" id>
      <div class="list-group border-0 text-center text-md-left">
        <router-link
          v-for="(tab,key) in tabs"
          :key="key"
          :to="{ name: tab.route }"
          class="list-group-item d-inline-block collapsed"
          data-toggle="collapse"
          aria-expanded="false"
        >
          <i :class="tab.icon"></i>
          <span class="d-none d-md-inline">{{ tab.name }}</span>
        </router-link>
      </div>
    </div>

    <div class="col-md-6">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "auth",

  computed: {
    tabs() {
      return [
        {
          icon: "user",
          name: this.$t("Artykuł"),
          route: "create.article"
        },
        {
          icon: "lock",
          name: this.$t("Film"),
          route: "create.video"
        },
        {
          icon: "user",
          name: this.$t("Dyskusje"),
          route: "create.discussion"
        },
        {
          icon: "user",
          name: this.$t("Sondaż"),
          route: "create.poll"
        }
      ];
    }
  }
};
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
