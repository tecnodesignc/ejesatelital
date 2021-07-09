<template>
  <q-list padding>
    <q-item clickable v-ripple to="/" active-class="active" exact>
      <q-item-section avatar>
        <q-icon name="inbox" />
      </q-item-section>
      <q-item-section>
        Dashboard
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script lang="ts">
//import { ref } from 'vue'

export default {
  name: 'Sidebar',
  props: {
    title: {
      type: String,
      required: true
    },

    caption: {
      type: String,
      default: ''
    },

    link: {
      type: String,
      default: '#'
    },

    icon: {
      type: String,
      default: ''
    }
  }
}
</script>

<style lang="scss">
.active{
  color: $primary!important;
  background-color: #f5f7fa!important;
}
</style>
