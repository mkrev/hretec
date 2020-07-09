<template>

  <div class="nav-item">
    <a
          class="nav-link text-dark"
          href="#"
          role="button"
          data-target="#sidebar"
          @click.prevent="changeVisibleSideBar(!visibleSideBar)"
        >
          <i class="fas fa-bars fa-2x"></i>
        </a>

  <div :class="['collapse width sidebar',{show: visibleSideBar}]" id="sidebar" ref="sidebar">
    <div class="list-group border-0 text-center text-md-left"> 
       <router-link v-for="(tab,key) in tabs" :key="key"  :to="{ name: tab.route }" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false">
         <i :class="tab.icon"></i>
          <span class="d-none d-md-inline">{{ tab.name }}</span>
      </router-link>
    </div>
  </div>
   </div>
</template>


<script>
export default {
  name: "SideBar",

  computed: {
    tabs() {
      return [
        {
          icon: "fas fa-newspaper",
          name: this.$t("Artykuły"),
          route: "articles"
        },
        {
          icon: "fas fa-film",
          name: this.$t("Filmy"),
          route: "videos"
        },
        {
          icon: "fas fa-handshake",
          name: this.$t("Dyskusje"),
          route: "discussions"
        },
        {
          icon: "fas fa-poll",
          name: this.$t("Sondaże"),
          route: "polls"
        }
      ];
    },
    visibleSideBar(){
      return this.$store.getters['elements_state/visibleSideBar']
    }
  },
     methods: {
      changeVisibleSideBar(state){
          this.$store.commit('elements_state/setVisibleSideBar', state)
      }
    }
};
</script>

<style>


</style>


