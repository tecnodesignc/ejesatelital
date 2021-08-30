<template>
  <div class="row">
    <div class="col-12 q-pt-sm" v-if="success">
    </div>
  </div>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'

export default {
  name: 'GoogleMap',
  props: {
    lat: {
      type: Text,
      required:true
    },
    lng: {
      type: Text,
      required:true
    }
  },
  components: {},
  setup(props, contex) {
    const $q = useQuasar()
    const center = { lat: 40.689247, lng: -74.044502 }
    const success = ref(false)
    const api=ref(process.env.GOOGLE_APY_KEY)
    const init = () => {
     // center.value={lat:  parseFloat(props.lat), lng:parseFloat(props.lng)}
      success.value=true
    }
    onMounted(async () => {
      await init()
    });
    return {
      center,
      api,
      success
    };
  },
};
</script>
<style lang="scss">

</style>
