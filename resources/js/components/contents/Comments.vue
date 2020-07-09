<template>
  <section class="comment-tab">
    <section class="row add-comment">
      <form v-if="Object.keys(user).length" @submit.prevent="addComment">
        <div class="form-group">
          <label for="exampleInputEmail1">{{$t("Komentarze")}}</label>
          <input
            type="text"
            class="form-control"
            id="content"
            name="content"
            v-model="form.content"
            :placeholder="$t('Wprowadź komentarz')"
          />
        </div>
        <button type="submit" class="btn btn-primary">{{$t("Publikuj")}}</button>
      </form>
    </section>

    <section class="row comments">
      <ul v-if="content.comments" class="list-group col-12 col-lg-8">
        <li v-for="(comment,key) in content.comments" :key="key" class="list-group-item">
          <article class="row">
            <div class="col-xs-2 col-md-1">
              <img :src="comment.user.photo" class="rounded-circle" alt />
            </div>
            <div class="col-xs-10 col-md-11">
              <div v-if="comment.id == editCommentId">
                <form @submit.prevent="updateComment(comment)">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      id="content"
                      name="content"
                      v-model="comment.content"
                      :placeholder="$t('Wprowadź komentarz')"
                    />
                  </div>
                  <button type="submit" class="btn btn-primary">{{$t("Edytuj")}}</button>
                  <button @click="editCommentId=null" class="btn btn-primary">{{$t("Anuluj")}}</button>
                </form>
              </div>

              <div v-else>
                <div>
                  <div class="mic-info">
                    <a href="#">{{comment.user.name}}</a>
                    {{formatDate(comment.updated_at)}}
                  </div>
                </div>
                <div class="comment-text">{{comment.content}}</div>
                <div v-if="user" class="action">
                  <button @click="addLike(comment,1)" type="button" class="btn btn-xs">
                    <i class="fas fa-thumbs-up" :class="{ active: likeIsActive(comment,1) }"></i>
                    ({{comment.count_likes ? comment.count_likes : 0}})
                  </button>
                  <button @click="addLike(comment,0)" type="button" class="btn btn-xs">
                    <i class="fas fa-thumbs-down" :class="{ active: likeIsActive(comment,0) }"></i>
                    ({{comment.count_dislikes ? comment.count_dislikes : 0}})
                  </button>
                  <div class="d-inline-block" v-show="comment.user.id == user.id">
                    <button
                      @click="setEditComment(comment.id)"
                      type="button"
                      class="btn btn-xs"
                      title="Edit"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                    <button
                      @click="remove(comment.id)"
                      type="button"
                      class="btn btn-xs"
                      title="Delete"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </li>
      </ul>
    </section>
  </section>
</template>

<script>
import Form from "vform";
import axios from "axios";
import moment from "moment";
import Vue from "vue";

export default {
  name: "Comments",

  props: {
    user: { type: Object, default: {} },
    content: { type: Object, default: {} },
    type: { type: String, default: "" }
  },

  data: () => ({
    form: new Form({
      content: ""
    }),
    editCommentId: null
  }),

  computed: {
    likes() {
      let likes = this.user.likes;
      return likes ? likes : [];
    }
  },
  methods: {
    async addComment() {
      const { data } = await this.form.post(
        `/api/${this.type}/${this.content.id}/add-comment`
      );
      this.content.comments.push(data);
    },

    async updateComment(comment) {
      const { data } = await axios.patch(
        `/api/comment/update/${comment.id}`,
        comment
      );
      this.editCommentId = null;
      this.updateComments(comment, data);
    },

    async addLike(comment, isLike) {
      let { data } = await axios.post(`/api/comment/{${comment.id}}/add-like`, {
        is_like: isLike
      });
      this.user.likes = data.likes;
      this.updateComments(comment, data.model);
    },
    async remove(id) {
      let { data } = await axios.delete(`/api/comment/${id}`);
      let comments = this.content.comments;
      comments.splice(
        comments.findIndex(function(i) {
          return i.id === id;
        }),
        1
      );
    },

    formatDate(date) {
      return moment(date).format("YYYY-MM-DD");
    },

    likeIsActive(comment, is_like) {
      return this.likes.filter(
        el =>
          el.likeable_id == comment.id &&
          el.likeable_type == "App\\Models\\Contents\\Comment" &&
          el.is_like == is_like
      ).length;
    },

    setEditComment(id) {
      this.editCommentId = id;
    },

    updateComments(comment, data) {
      let comments = this.content.comments;
      comments.splice(
        comments.findIndex(function(i) {
          return i.id === comment.id;
        }),
        1,
        data
      );
    }
  }
};
</script>
