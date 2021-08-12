<template>
  <div class="row">
    <div class="col-12 q-pt-sm">
      <p class="text-subtitle2">Pais</p>
      <q-select
        outlined
        dense
        v-model="country_id"
        emit-value
        map-options
        use-input
        :options="country_list"
        @filter="getCountries"
        @update:model-value ="setLocation"
        clearable
      />
    </div>
  </div>
  <div class="row">
    <div class="col-12 q-pt-sm">
      <p class="text-subtitle2">Estado/Provincia</p>
      <q-select
        outlined
        dense
        v-model="province_id"
        emit-value
        map-options
        use-input
        clearable
        :options="province_list"
        @update:model-value ="setLocation"
        @filter="getProvince"
      />
    </div>
  </div>
  <div class="row">
    <div class="col-12 q-pt-sm">
      <p class="text-subtitle2">Ciudad</p>
      <q-select
        outlined
        dense
        v-model="city_id"
        emit-value
        map-options
        use-input
        clearable
        @update:model-value ="setLocation"
        :options="city_list"
        @filter="getCities"
      />
    </div>
  </div>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";

export default {
  name: 'Location',

  props: {
    city: {
      type: Object,
      default: {}
    },
    province: {
      type: Object,
      default: {}
    },
    country: {
      type: Object,
      default: {}
    }
  },

  setup(props, contex) {
    const $q = useQuasar()
    const store = useStore();
    const city_id = ref(props.city ? props.city.id : null)
    const province_id = ref(props.province ? props.province.id : null)
    const country_id = ref(props.country ? props.country.id : null)
    const country_list = ref([])
    const province_list = ref([])
    const city_list = ref([])
    const setLocation = ()=>{
      let locationData={city_id:city_id.value, province_id:province_id.value,country_id:country_id.value}
      contex.emit('location',locationData)
    }
    const getCountries = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {search: val}
          }
        }
        api.get('/location/v1/countries', params).then(response => {
          update(() => {
            let options = array.select(response.data.data, {label: 'name', id: 'id'})
            country_list.value = options
          })
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Paises',
            icon: 'report_problem'
          })
          console.error(error)
          $q.loading.hide()
        });
      });
    }
    const getProvince = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 100,
            filter: {country: country_id.value, search: val}
          }
        }
        api.get('/location/v1/provinces', params).then(response => {
          update(() => {
            let options = array.select(response.data.data, {label: 'name', id: 'id'})
            province_list.value = options
          })
        }).catch(error => {
          console.error(error)
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Provincia',
            icon: 'report_problem'
          })
          $q.loading.hide()
        });
      });
    }
    const getCities = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {province: province_id.value, search: val}
          }
        }
        api.get('/location/v1/cities', params).then(response => {
          update(() => {
            let options = array.select(response.data.data, {label: 'name', id: 'id'})
            city_list.value = options
          })
        }).catch(error => {

          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Ciudades',
            icon: 'report_problem'
          })
          $q.loading.hide()
          console.error(error)
        });
      });
    }

    const init = async () => {
      if (props.country)
        country_list.value = array.select([props.country], {label: 'name', id: 'id'})
      else
       await getCountries();

      if (props.province)
        province_list.value = array.select([props.province], {label: 'name', id: 'id'})
      else await getProvince()
      if (props.city)
        city_list.value = array.select([props.city], {label: 'name', id: 'id'})
      else
        await getCities()
    }
    onMounted(async () => {
      await init()
    });
    return {
      city_id,
      province_id,
      country_id,
      country_list,
      province_list,
      city_list,
      getCountries,
      getProvince,
      getCities,
      setLocation
    };
  },
};
</script>
<style lang="scss">

</style>
