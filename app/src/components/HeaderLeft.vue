<template>
  <div v-if="$store.state.auth.selectedRoleId===3">
    <q-btn-toggle
      v-model="model"
      class="my-custom-toggle"
      no-caps
      rounded
      unelevated
      toggle-color="primary"
      color="white"
      text-color="primary"
      :options="[
          {label: 'Option 1', value: 'one'},
          {label: 'Option 2', value: 'two'}
        ]"
    />
  </div>
  <q-toolbar-title v-else>
    <q-btn flat color="secondary" icon="email"/>
    <q-btn flat color="secondary" icon="mark_chat_unread"/>
    <q-btn flat color="secondary" icon="event"/>
  </q-toolbar-title>
</template>

<script lang="ts">
//import { ref } from 'vue'

export default {
  name: 'HeaderLeft',
  props: {}
}
</script>

<style lang="scss">
</style>
