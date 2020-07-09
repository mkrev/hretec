<template>
  <article>
    <div>
      <router-link :to="{ name: 'article', params: { id: model.id } }">{{model.title}}</router-link>
    </div>

    <div>{{model.content}}</div>
    <div v-if="model.file">
      <img :src="model.picture_url" alt />
    </div>
  </article>
</template>

<script>
export default {
  props: {
    model: { type: Object, default: {} }
  },

  data: () => ({}),

  methods: {}
};
</script>
