<template>
  <section class="content-list">
    <div class="row">
      <div v-for="(discussion,key) in discussions" :key="key" class="col-12 col-lg-3">
        <Discussion :model="discussion" />
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Discussion from "~/components/contents/Discussion";

export default {
  data: () => ({
    discussions: null
  }),
  components: {
    Discussion
  },
  async created() {
    let { data } = await axios.get("/api/discussions");
    this.discussions = data;
  },

  methods: {}
};
</script>
