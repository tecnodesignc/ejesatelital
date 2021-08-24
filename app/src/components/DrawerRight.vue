<template>
  <div class="q-gutter-x-sm row">
    <div class="col-12">
      <select-account/>
    </div>
    <div class="col-12">
      <select-role/>
    </div>

  </div>
</template>

<script>
//import { ref } from 'vue'
import SelectAccount from "src/modules/company/_components/widget/SelectAccount";
import SelectRole from "src/modules/user/_components/user/SelectRole";
export default {
  name: 'DrawerRight',
  components: {SelectRole, SelectAccount},
  props: {}
}
</script>

<style lang="scss">
</style>
