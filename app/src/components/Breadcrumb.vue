<template>
  <ol class="breadcrumb m-0">
    <q-breadcrumbs active-color="white" >
      <q-breadcrumbs-el v-for="(item, i) in items" :key="i" :label="item.name" :to="{name:item.to}"/>
    </q-breadcrumbs>
  </ol>
</template>

<script>
//import { ref } from 'vue'

export default {
  name: 'Breadcrumb',
  props: {
    items:{}
  }
}
</script>

<style lang="scss">
.active{
  color: $primary!important;
  background-color: #f5f7fa!important;
}
</style>
