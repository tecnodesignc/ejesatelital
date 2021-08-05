<template>
  <q-img class="absolute-top user-sidebar text-center" src="~assets/user-img.png" style="height: 150px">
    <div class="absolute-bottom bg-transparent">
      <q-avatar size="56px" class="q-mb-sm">
        <img :src="userData.main_image">
      </q-avatar>
      <div class="text-weight-bold"> {{ userData.full_name }}</div>
      <div>{{ userData.email }}</div>
    </div>
  </q-img>
</template>

<script>
import {useStore} from 'vuex'
import { computed} from 'vue'
export default{
  name: 'UserSidebar',
  setup() {
    const store = useStore();
    const userData=computed(() =>store.state.auth.user)
    return {
      userData
    };
  },
};
</script>
