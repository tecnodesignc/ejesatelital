<template>
  <div class="q-ma-lg">
    <p class="text-subtitle2">Rol Principal</p>
      <q-select
        outlined
        dense
        v-model="role_id"
        emit-value
        map-options
        :options="roles_list"
        label="Selecionar Rol"
        @update:model-value="setRole"
        style="width: 100%"
      />
  </div>
</template>

<script>

import {onMounted, ref} from 'vue'
import {useQuasar} from "quasar";
import {useStore} from "vuex";
import {useRouter} from 'vue-router'


export default {
  name: 'SelectRole',
  components: {},
  props: {},
  setup(props, contex) {
    const $q = useQuasar();
    const store = useStore();
    const roles_list = ref([])
    const role_id = ref(null)
    const router = useRouter()
    const getRoles = async () => {
      $q.loading.show()
      roles_list.value = store.getters['auth/userRolesSelect']
      role_id.value = store.state.auth.role.id
      $q.loading.hide()
    }
    const setRole = () => {
      return new Promise(async (resolve, reject) => {
        let role= roles_list.value.find(item => item.id === role_id.value)
        await store.dispatch('auth/setRole', role)
        router.go()
      })
    }
    onMounted(async () => {
      await getRoles()
    });

    return {
      role_id,
      roles_list,
      setRole
    };
  },
};
</script>
<style lang="scss">
</style>
