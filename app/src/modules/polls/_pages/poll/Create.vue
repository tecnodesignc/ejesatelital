<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Encuesta</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <q-form class="needs-validation" @submit.prevent="register">
          <div class="row">
            <div class="col-md-12 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Datos</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row" v-if="true">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Cuenta</p>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Nombre de la Encuesta</p>
                      <q-input
                        outlined
                        v-model="title"
                        stack-label
                        dense
                        name="board"
                        placeholder="titulo"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Fecha de inicio</p>
                      <q-input outlined
                               stack-label
                               mask="####-##-##"
                               dense
                               v-model="start_date"
                               :rules="[val => !!val || 'Campo requerido']"
                               placeholder="Fecha de Inicio"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                              <q-date v-model="start_date" mask="YYYY-MM-DD">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="Close" color="primary" flat/>
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Fecha de finalizaciòn</p>
                      <q-input outlined
                               stack-label
                               mask="####-##-##"
                               dense
                               v-model="end_date"
                               :rules="[val => !!val || 'Campo requerido']"
                               placeholder="Fecha de finalizaciòn"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                              <q-date v-model="end_date" mask="YYYY-MM-DD">
                                <div class="row items-center justify-end">
                                  <q-btn v-close-popup label="Close" color="primary" flat/>
                                </div>
                              </q-date>
                            </q-popup-proxy>
                          </q-icon>
                        </template>
                      </q-input>
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Preguntas</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">

                  </div>

                </q-card-section>
              </q-card>
            </div>
          </div>
          <q-footer>
            <q-card class="q-mb-sm">
              <q-card-section>
                <div class="q-pa-md q-gutter-sm">
                  <q-btn unelevated color="primary" type="submit" label="Guardar"/>
                  <q-btn outline color="primary" :to="{name:'vehicle.vehicle.index'}" label="Cancelar"/>
                </div>
              </q-card-section>
            </q-card>
          </q-footer>

        </q-form>
        <!-- end row -->
      </div>
    </div>

  </q-page>
</template>

<script>

import {ref} from 'vue';
import {useRouter, useRoute} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import {computed, onMounted} from 'vue'
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia";
import Location from "src/modules/location/_components/Location";
import helper from "src/plugins/helpers";

export default {
  name: 'Create Contact',
  components: {SingleMedia, Breadcrumb, Location},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Vehìculos",
        to: 'vehicle.vehicle.index',
        active: true
      },
      {
        name: "Crear Vehìculos",
        to: 'vehicle.vehicle.create',
        active: true
      }
    ]
    const board = ref(null)
    const brand_id = ref(null)
    const model = ref(null)
    const type_vehicle = ref(null)
    const insurance_expiration = ref(null)
    const technomechanical_expiration = ref(null)
    const accounts = ref([])
    const drivers = ref([])
    const options = ref([])
    const account_list = ref([])
    const type_vehicle_list = ref([])
    const type_vehicle_option = ref([])
    const driver_list = ref([])
    const model_list = ref([])
    const brand_list = ref([])
    const success = ref(false)
    const router = useRouter()
    const model_options = ref(model_list.value)
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              board: board.value,
              brand_id: brand_id.value,
              model: model.value,
              type_vehicle: type_vehicle.value,
              insurance_expiration: insurance_expiration.value,
              technomechanical_expiration: technomechanical_expiration.value,
              accounts: accounts.value,
              drivers: drivers.value,
              options: options.value,

            }
          }
          api.post('/vehicle/v1/vehicles', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Vehiculo Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'vehicle.vehicle.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Vehiculo: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar el Vehiculo', error)
      }
    }
    const getAccounts = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {search: val}
          }
        }
        api.get('/company/v1/accounts', {params: params}).then(response => {
          update(() => {
            account_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          })
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Cuentas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          abort(error)
          reject(error)
        });
      });
    }
    const getDrivers = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {search: val}
          }
        }
        api.get('/user/v1/users', {params: params}).then(response => {
          update(() => {
            driver_list.value = array.select(response.data.data, {label: 'full_name', id: 'id'})
          })
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Cuentas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          abort(error)
          reject(error)
        });
      });
    }
    const getTypeVehicles = async () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {}
          }
        }
        api.get('/vehicle/v1/vehicle-type', {params: params}).then(response => {
          type_vehicle_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          type_vehicle_option.value = type_vehicle_list.value
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Tipos de Vehìculos',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const getBrands = async (val, update, abort) => {
      let params = {
        take: 20,
        filter: {
          search: val,
          status: true
        }
      }
      api.get('/vehicle/v1/brands', {params:params}).then(response => {
        update(() => {
          let options = array.select(response.data.data, {label: 'name', id: 'id'})
          brand_list.value = options
        })
      }).catch(error => {
        $q.notify({
          color: 'negative',
          position: 'bottom-right',
          message: 'Error en la Consulta de Marcas',
          icon: 'report_problem'
        })
        $q.loading.hide()
        reject(error)
      });
    }
    onMounted(async () => {
      model_list.value = helper.yearList(null, 1920)
      await getTypeVehicles()
    });
    return {
      board,
      brand_id,
      model,
      type_vehicle,
      insurance_expiration,
      technomechanical_expiration,
      accounts,
      drivers,
      driver_list,
      model_list,
      model_options,
      brand_list,
      options,
      breadcrumb,
      success,
      account_list,
      type_vehicle_list,
      type_vehicle_option,
      register,
      getAccounts,
      getDrivers,
      getBrands,
      helper
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
