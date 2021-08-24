<template>
  <div class="q-ma-md">
    <q-toggle size="sm" v-model="result" true-value="Si" false-value="No" @update:model-value="changValue" />
  </div>
</template>

<script>
import {onMounted, ref} from 'vue'
import {useQuasar} from "quasar";

export default {
  name: 'YesNo',
  components: {},
  props: {
    answer:{
      type:Object,
      required
    }
  },
  setup(props, contex) {
    const $q = useQuasar();
    const result = ref(false)
    const changValue = () => {
      contex.emit('value', result.value)
    }
    onMounted(() => {
      contex.emit('value', result.value)
    });

    return {
      result,
      changValue
    };
  },
};
</script>
<style lang="scss">
</style>
