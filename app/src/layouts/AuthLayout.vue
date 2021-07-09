<template>
  <q-layout view="hHh lpR fFf">
    <q-page-container class="authentication-bg">
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">

import {ref} from 'vue'

export default {
  name: 'MainLayout',

  components: {},

  setup() {
    const leftDrawerOpen = ref(false)

    return {
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
}
</script>
<style lang="scss">
.authentication-bg{
  background-image: url(~assets/title-img.png);
  background-color: $primary;
  height: 100vh;
  background-size: cover;
  background-position: center;
}


</style>
