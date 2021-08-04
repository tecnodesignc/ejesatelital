<template>
  <q-layout view="lHh Lpr lFf">
    <q-header  class="bg-white q-py-lg">
      <q-toolbar>
        <q-btn
          flat
          dense
          color="secondary"
          icon="menu"
          aria-label="Menu"
          @click="drawer=!drawer"
        />
        <header-left/>
        <div><header-right/></div>
        <q-btn dense flat icon="fas fa-cog" color="secondary" @click="rightDrawerOpen=!rightDrawerOpen" />
      </q-toolbar>
    </q-header>
    <q-drawer
      v-model="drawer"
      show-if-above
      :width="260"
      :breakpoint="400"
    >
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; border-right: 1px solid #ddd">
        <sidebar/>
      </q-scroll-area>

      <user-sidebar/>
    </q-drawer>
    <q-drawer show-if-above v-model="rightDrawerOpen" behavior="mobile" side="right" bordered>
      <pre>{{rightDrawerOpen}}</pre>
    </q-drawer>
    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import Sidebar from 'components/Sidebar.vue'
import UserSidebar from 'src/modules/user/_components/UserSidebar.vue'
import HeaderLeft from "components/HeaderLeft.vue";
import HeaderRight from "components/HeaderRight.vue";

import {ref} from 'vue'


export default{
  name: 'MainLayout',

  components: {
    HeaderRight,
    HeaderLeft,
    Sidebar,
    UserSidebar
  },

  setup() {
    const drawer = ref(false)
    const rightDrawerOpen = ref(false)
    return {
      drawer,
      rightDrawerOpen,
    }
  }
}
</script>

<style lang="scss">
.user-sidebar {
  background-color: $primary;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  padding: 20px 0;
}
</style>
