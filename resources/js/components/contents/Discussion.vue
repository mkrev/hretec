<template>
<article>

          <div>
           <router-link :to="{ name: 'discussion', params: { id: model.id } }" > 
           {{model.title}}
          </router-link>
        </div>

         <div>
          {{model.description}}
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
