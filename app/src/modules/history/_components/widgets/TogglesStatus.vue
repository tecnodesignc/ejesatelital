<template>
  <q-btn-toggle
    v-model="status"
    class="status-toggle"
    no-caps
    rounded
    unelevated
    toggle-color="primary"
    color="white"
    text-color="primary"
    :options="[
          {slot: 'libre', value: 1},
          {slot: 'ocupado', value: 2},
          {slot: 'nodisponible', value: 0}
        ]"
    @update:model-value="changeStatus"
  >
    <template v-slot:libre>
      <div class="row items-center no-wrap">
        <div class="text-center"  v-if="$q.screen.gt.xs">
          Libre
        </div>
        <q-icon v-else name="how_to_reg">
          <q-tooltip>Libre</q-tooltip>
        </q-icon>
      </div>
    </template>

    <template v-slot:ocupado>
      <div class="row items-center no-wrap">
        <div class="text-center" v-if="$q.screen.gt.xs">
          Ocupado
        </div>
        <q-icon v-else  name="person_remove">
          <q-tooltip>Ocupado</q-tooltip>
        </q-icon>

      </div>
    </template>

    <template v-slot:nodisponible>
      <div class="row items-center no-wrap">
        <div class="text-center" v-if="$q.screen.gt.xs">
          No Disponible
        </div>
        <q-icon v-else name="person_off">
          <q-tooltip> No Disponible</q-tooltip></q-icon>
      </div>
    </template>
  </q-btn-toggle>
</template>

<script>

import {ref, onMounted, onBeforeUnmount} from 'vue'

import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";

export default {
  name: 'TogglesStatus',

  setup() {
    const $q = useQuasar();
    const status = ref(1)
    const store=useStore()
    const position = ref(1)
    const changeStatus= async ()=> {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          navigator.geolocation.getCurrentPosition(function(coordinates) {
            position.value= {lat:coordinates.coords.latitude, lng:coordinates.coords.longitude};
          });

          let params = {
            attributes: {
              title: 'Cambio de estado',
              message:status.value,
              account_id:store.state.account.account_id,
              lat: position.value.lat,
              lng: position.value.lng,
              type:1
            }
          }
          api.post('/history/v1/histories', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Se a modificado su estado',
              icon: 'report_problem'
            })
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Modificar el estado: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error al Modificar el estado', error)
      }
    }
    return {
      status,
      changeStatus
    }
  }
};
</script>
<style lang="scss">

</style>
