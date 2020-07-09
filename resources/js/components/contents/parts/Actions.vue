<template>
  <div class="action">
    <button @click="addLike(1)" type="button" class="btn btn-xs">
      <i class="fas fa-thumbs-up" :class="{ active: likeIsActive(1) }"></i>
      ({{currentModel.count_likes ? currentModel.count_likes : 0}})
    </button>
    <button @click="addLike(0)" type="button" class="btn btn-xs">
      <i class="fas fa-thumbs-down" :class="{ active: likeIsActive(0) }"></i>
      ({{currentModel.count_dislikes ? currentModel.count_dislikes : 0}})
    </button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    model: { type: Object },
    type: { type: String }
  },

  data: () => ({
    like: {},
    currentModel: {}
  }),

  async created() {
    this.currentModel = this.model;
    let { data } = await axios.get(
      `/api/user/${this.type}/${this.model.id}/get-likes`
    );
    this.like = data;
  },

  methods: {
    async addLike(isLike) {
      let { data } = await axios.post(
        `/api/${this.type}/${this.model.id}/add-like`,
        {
          is_like: isLike
        }
      );

      this.like = data.like;
      this.currentModel = data.model;
    },

    likeIsActive(is_like) {
      return this.like instanceof Object && this.like.is_like == is_like;
    }
  }
};
</script>
