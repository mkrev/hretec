<template>
  <div>
    <section class="content-detail row">
      <div class="col-12">
        <Discussion :model="discussion" />

        <div v-if="discussion.user">{{$t('Autor: ')}} {{discussion.user.name}}</div>
        <Actions :model="discussion" type="discussion" />
      </div>
    </section>

    <Comments :user="user" :content="discussion" type="discussion" />
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Comments from "~/components/contents/Comments";
import Discussion from "~/components/contents/Discussion";
import Actions from "~/components/contents/parts/Actions";

export default {
  data: () => ({
    discussion: {}
  }),
  components: {
    Discussion,
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
    let { data } = await axios.get(`/api/discussion/${id}`);
    this.discussion = data;
  }
};
</script>
