<template>
  <div class="q-ma-lg">
    <p class="text-subtitle2">Cuenta Principal</p>
      <q-select
        outlined
        dense
        v-model="account_id"
        emit-value
        map-options
        :options="account_list"
        label="Selecionar Cuenta"
        @update:model-value="setAccount"
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
  name: 'SelectAccount',
  components: {},
  props: {},
  setup(props, contex) {
    const $q = useQuasar();
    const store = useStore();
    const account_list = ref([])
    const account_id = ref(null)
    const router = useRouter()
    const getAccount = async () => {
      $q.loading.show()
      await store.dispatch('account/SetAccounts')
      account_list.value = store.state.account.account_list
      account_id.value = store.state.account.account_id
      $q.loading.hide()
    }
    const setAccount = () => {
      return new Promise(async (resolve, reject) => {
        let account = account_list.value.find(item => item.id === account_id.value)
        await store.dispatch('account/AccountSelect', account)
        router.go()
      })
    }
    onMounted(async () => {
      await getAccount()
    });

    return {
      account_id,
      account_list,
      setAccount
    };
  },
};
</script>
<style lang="scss">
</style>
