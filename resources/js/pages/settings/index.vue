<template>
  <div class="row justify-content-center">
    <!--<div class="sidebar">
      <card :title="$t('settings')" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>
    </div>-->

    <div class="sidebar">
        <div class="d-flex justify-content-center align-items-center p-4"><span class="settings-title">{{$t('settings')}}</span></div>
        <div class="list-group border-0 text-center text-md-left"> 
            <router-link v-for="tab in tabs" :key="tab.route" :to="{ name: tab.route }" class="list-group-item d-inline-block collapsed">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
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
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
