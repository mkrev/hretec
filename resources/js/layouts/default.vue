<template>
  <div class="main-layout">
    <Header />

    <div class="test"></div>
    
    <div class="container-fluid"> 
      <div class="row">
        <div class="col-11 offset-1 content">
        <main>
            <child />
        </main>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '~/components/Header'

export default {
  name: 'MainLayout',

  components: {
    Header
  }
}
</script>
