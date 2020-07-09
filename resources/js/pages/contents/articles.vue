<template>
  <section class="content-list">
    <div class="row">
      <div v-for="(article,key) in articles" :key="key" class="col-12 col-lg-3">
        <Article :model="article" />
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import Article from "~/components/contents/Article";

export default {
  data: () => ({
    articles: null
  }),
  components: {
    Article
  },
  async created() {
    let { data } = await axios.get("/api/articles");
    this.articles = data;
  },

  methods: {}
};
</script>
