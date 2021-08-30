<template>
  <q-toolbar-title v-if="$store.state.auth.role.id===3">
    <toggles-status/>
  </q-toolbar-title>
  <q-toolbar-title v-else>
<!--    <q-btn flat color="secondary" icon="email"/>
    <q-btn flat color="secondary" icon="mark_chat_unread"/>
    <q-btn flat color="secondary" icon="event"/>-->
  </q-toolbar-title>
</template>

<script>

import {ref} from "vue";
import TogglesStatus from "src/modules/history/_components/widgets/TogglesStatus";

export default {
  name: 'HeaderLeft',
  components: {TogglesStatus},
  props: {},
  setup(){
    const status= ref(1)
    const setStatus=()=>{

    }
    return {
      status,
      setStatus
    }
  }
}
</script>

<style lang="scss">

.status-toggle{
  border: 1px solid $primary
}

</style>
