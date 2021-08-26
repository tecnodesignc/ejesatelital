<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Vehiculo</h4>
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
            <div class="col-md-9 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Datos</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Tipo de Vehìculo</p>
                      <q-select
                        outlined
                        dense
                        emit-value
                        map-options
                        v-model="type_vehicle"
                        name="type_vehicle"
                        use-input
                        :options="type_vehicle_option"
                        @filter="(val, update)=>update(()=>{type_vehicle_option = helper.filterOptions(val,type_vehicle_list,type_vehicle)})"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Placa</p>
                      <q-input
                        outlined
                        v-model="board"
                        stack-label
                        dense
                        mask="XXXXXXX"
                        name="board"
                        placeholder="Placa"
                        lazy-rules
                        @blur="verifyVehicle(board)"
                        :rules="[val => !!val || 'Campo requerido', val => alert || 'El vehiculo ya existe']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Modelo</p>
                      <q-select
                        outlined
                        dense
                        v-model="model"
                        name="model"
                        use-input
                        no-option="model"
                        :options="model_options"
                        @filter="(val, update)=>update(()=>{model_options = helper.filterOptions(val,model_list,model)})"
                        clearable
                      >
                        <template v-slot:no-option>
                          <q-item>
                            <q-item-section class="text-grey">
                              No results
                            </q-item-section>
                          </q-item>
                        </template>
                      </q-select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Marca</p>
                      <q-select
                        outlined
                        dense
                        v-model="brand_id"
                        emit-value
                        map-options
                        use-input
                        :options="brand_list"
                        @filter="getBrands"
                        placeholder="Marca del Vehìculo"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Fecha de Vencimiento SOAT</p>
                      <q-input outlined
                               stack-label
                               mask="####-##-##"
                               dense
                               v-model="insurance_expiration"
                               :rules="[val => !!val || 'Campo requerido']"
                               placeholder="SOAT"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                              <q-date v-model="insurance_expiration" mask="YYYY-MM-DD">
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
                      <p class="text-subtitle2">Fecha de Vencimiento Revisión Técnico Mecánica</p>
                      <q-input outlined
                               stack-label
                               mask="####-##-##"
                               dense
                               v-model="technomechanical_expiration"
                               :rules="[val => !!val || 'Campo requerido']"
                               placeholder="Revisión Técnico Mecánica"
                      >
                        <template v-slot:append>
                          <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                              <q-date v-model="technomechanical_expiration" mask="YYYY-MM-DD">
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
            </div>
            <div class="col-md-3 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Cuenta</p>
                      <q-select
                        outlined
                        dense
                        v-model="accounts"
                        emit-value
                        name="accounts"
                        map-options
                        multiple
                        use-input
                        :options="account_list"
                        @filter="getAccounts"
                      >
                        <template v-slot:selected-item="scope">
                          <q-chip
                            removable
                            dense
                            @remove="scope.removeAtIndex(scope.index)"
                            :tabindex="scope.tabindex"
                            color="secondary"
                            text-color="white"
                            class="q-ma-xs"
                          >
                            {{ scope.opt.label }}
                          </q-chip>
                        </template>
                      </q-select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Conductores</p>
                      <q-select
                        outlined
                        dense
                        v-model="drivers"
                        emit-value
                        name="drivers"
                        map-options
                        multiple
                        use-input
                        :options="driver_list"
                        @filter="getDrivers"
                      >
                        <template v-slot:selected-item="scope">
                          <q-chip
                            removable
                            dense
                            @remove="scope.removeAtIndex(scope.index)"
                            :tabindex="scope.tabindex"
                            color="secondary"
                            text-color="white"
                            class="q-ma-xs"
                          >
                            {{ scope.opt.label }}
                          </q-chip>
                        </template>
                      </q-select>
                    </div>
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
    const alert=ref(false)
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
    const verifyVehicle = (board) => {
        return new Promise(async (resolve, reject) => {
          $q.loading.show()
          let criteria = board
          let params = {
            include: ''
          }
          api.get('/vehicle/v1/vehicles/' + criteria, {params: params}).then(response => {
            alert.value = true
            $q.loading.hide()
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error en la consulta del Vehìculo ',
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
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
      verifyVehicle,
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
