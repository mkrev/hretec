<template>
<article>

          <div>
          <router-link :to="{ name: 'video', params: { id: model.id } }" > 
            {{model.title}}
          </router-link>
        </div>

         <div>
          {{model.description}}
        </div>

         <div v-if="model.file">
           <video width="320" height="240" controls>
            <source :src="model.movie_url" type="video/mp4">
          </video>
          </div>
  
</article>
</template>

<script>

export default {
     props: {
    model: { type: Object, default: {} },
  },

  data: () => ({
  }),

  methods: {
   
  }
};
</script>
