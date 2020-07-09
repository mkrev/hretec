<template>
  <section class="content-list">
    <div class="row">
      <div v-for="(video,key) in videos" :key="key" class="col-12 col-lg-3">
        <Video :model="video" />
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Video from "~/components/contents/Video";

export default {
  data: () => ({
    videos: null
  }),
  components: {
    Video
  },
  async created() {
    let { data } = await axios.get("/api/videos");
    this.videos = data;
  },

  methods: {}
};
</script>
