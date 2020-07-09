<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "auth"
};
</script>


