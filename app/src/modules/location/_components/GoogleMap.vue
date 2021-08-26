<template>
  <div class="row">
    <div class="col-12 q-pt-sm" v-if="success">
<!--      <GoogleMap
        :api-key="api"
        style="width: 100%; height: 500px"
        :center="center"
        lng="-75.230873"
        lat="4.4345801"
        :zoom="15"
      >
      </GoogleMap>-->
    </div>
  </div>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
/*import { GoogleMap, Marker } from 'vue3-google-map'*/

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
  components: { GoogleMap, Marker },
  setup(props, contex) {
    const $q = useQuasar()
    const center = ref(null)
    const success = ref(false)
    const api=ref(process.env.GOOGLE_APY_KEY)
    const init = () => {
      center.value={lat:  parseFloat(props.lat), lng:parseFloat(props.lng)}
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
