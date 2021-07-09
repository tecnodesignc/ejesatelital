<template>
  <q-img class="absolute-top user-sidebar text-center" src="~assets/user-img.png" style="height: 150px">
    <div class="absolute-bottom bg-transparent">
      <q-avatar size="56px" class="q-mb-sm">
        <img src="https://cdn.quasar.dev/img/boy-avatar.png">
      </q-avatar>
      <div class="text-weight-bold">Razvan Stoenescu</div>
      <div>@rstoenescu</div>
    </div>
  </q-img>
</template>

<script lang="ts">
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'UserSidebar',
  setup() {
    return {

    };
  },
});
</script>
