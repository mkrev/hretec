<template>
  <div>
    <section class="content-detail row">
      <div class="col-12">
        <Video :model="video" />

        <div v-if="video.user">{{$t('Autor: ')}} {{video.user.name}}</div>

        <Actions :model="video" type="video" />
      </div>
    </section>

    <Comments :user="user" :content="video" type="video" />
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Comments from "~/components/contents/Comments";
import Video from "~/components/contents/Video";
import Actions from "~/components/contents/parts/Actions";

export default {
  data: () => ({
    video: {}
  }),
  components: {
    Video,
    Comments,
    Actions
  },
  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },
  async created() {
    const id = this.$route.params.id;
    let { data } = await axios.get(`/api/video/${id}`);
    this.video = data;
  }
};
</script>
