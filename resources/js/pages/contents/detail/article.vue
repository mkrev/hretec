<template>
  <div>
    <section class="content-detail row">
      <div class="col-12">
        <Article :model="article" />

        <div v-if="article.user">{{$t('Autor: ')}} {{article.user.name}}</div>
        <Actions :model="article" type="article" />
      </div>
    </section>

    <Comments :user="user" :content="article" type="article" />
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Comments from "~/components/contents/Comments";
import Article from "~/components/contents/Article";
import Actions from "~/components/contents/parts/Actions";

export default {
  data: () => ({
    article: {}
  }),
  components: {
    Article,
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
    let { data } = await axios.get(`/api/article/${id}`);
    this.article = data;
  },

  methods: {}
};
</script>
