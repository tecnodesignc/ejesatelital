<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Cuenta</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <form class="needs-validation" novalidate>
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
                      <p class="text-subtitle2">Nombre</p>
                      <q-input
                        outlined
                        v-model="name"
                        stack-label
                        dense
                        placeholder="Nombre"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">NIT:</p>
                      <q-input
                        outlined
                        v-model="nit"
                        stack-label
                        dense
                        placeholder="Número de Identificación Tributaria"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Sitio de Cuenta</p>
                      <q-input
                        outlined
                        v-model="account_site"
                        stack-label
                        dense
                        placeholder="Nombre"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Dirección</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Telefono</p>
                      <q-input
                        outlined
                        v-model="phone"
                        stack-label
                        dense
                        placeholder="+57 312 5455444"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Dirección</p>
                      <q-input
                        outlined
                        v-model="street"
                        stack-label
                        dense
                        placeholder="+57 312 5455444"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
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
                        :options="city_list"
                        @filter="getCities"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <!-- Buttons -->
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Publicar</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="q-pa-md q-gutter-sm">
                    <q-btn unelevated color="primary" @click="register" label="Guardar"/>
                    <q-btn outline color="primary" :to="{name:'company.account-type.index'}" label="Cancelar"/>
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <div class="col-md-3 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Cuenta Padre</p>
                      <q-select
                        outlined
                        dense
                        v-model="parent_id"
                        emit-value
                        map-options
                        use-input
                        :options="account_list"
                        @filter="getAccount"
                        placeholder="Cuenta principal"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Tipo de Cuenta</p>
                      <q-select
                        outlined
                        dense
                        v-model="account_type_id"
                        emit-value
                        map-options
                        use-input
                        :options="account_type_list"
                        @filter="getAccountType"
                        placeholder="Tipo de Cuenta"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <q-toggle
                        name="is_activate"
                        v-model="active"
                        :true-value="true"
                        label="Activar Cuenta"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Imagen</p>
                     <single-media zone="logo" entity="Company\Entities\Account" @selectedImage="selectedImage"/>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Tipo de Cuenta</p>
                      <q-select
                        outlined
                        dense
                        v-model="account_type_id"
                        emit-value
                        map-options
                        use-input
                        :options="account_type_list"
                        @filter="getAccountType"
                        placeholder="Tipo de Cuenta"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <q-toggle
                        name="is_activate"
                        v-model="active"
                        :true-value="true"
                        label="Activar Cuenta"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </form>
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
import Permissions from "src/modules/user/_components/admin/Permissions";
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia";

export default {
  name: 'Create Account Type',
  components: {SingleMedia, Breadcrumb, Permissions},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Cuentas",
        to: 'company.account.index',
        active: true
      },
      {
        name: "Crear Cuenta",
        to: 'company.account.create',
        active: true
      }
    ]
    const name = ref(null)
    const nit = ref(null)
    const account_site = ref(null)
    const parent_id = ref(0)
    const active = ref(false)
    const account_type_id = ref(null)
    const medias_single=ref(null)
    const phone = ref(null)
    const street = ref(null)
    const city_id = ref(null)
    const province_id = ref(null)
    const country_id = ref(null)
    const options = ref([])
    const users = ref([])
    const account_list = ref([])
    const account_type_list = ref([])
    const users_list = ref([])
    const country_list = ref([])
    const province_list = ref([])
    const city_list = ref([])
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              options: []
            }
          }
          api.post('/company/v1/accounts', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Tipo de Empresa Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.account-type.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Tipo de Empresa: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar Tipo de Empresa', error)
      }
    }
    const getAccount = async (val, update, abort) => {
      if (val.length < 2) return abort()
      let params = {
        params: {
          take: 20,
          filter: {search: val}
        }
      }
      api.get('/company/v1/accounts', params).then(response => {
        update(() => {
          let options = array.select(response.data.data, {label: 'name', id: 'id'})
          account_list.value = options
        })
      }).catch(error => {
        $q.notify({
          color: 'negative',
          position: 'bottom-right',
          message: 'Error en la Consulta de Cuentas',
          icon: 'report_problem'
        })
        $q.loading.hide()
        reject(error)
      });
    }
    const getAccountType = async (val, update, abort) => {
      if (val.length < 2) return abort()
      let params = {
        params: {
          take: 20,
          filter: {search: val}
        }
      }
      api.get('/company/v1/account-types', params).then(response => {
        update(() => {
          let options = array.select(response.data.data, {label: 'name', id: 'id'})
          account_type_list.value = options
        })
      }).catch(error => {
        $q.notify({
          color: 'negative',
          position: 'bottom-right',
          message: 'Error en la Consulta de Tipos Cuentas',
          icon: 'report_problem'
        })
        $q.loading.hide()
        reject(error)
      });
    }
    const getUsers = async (val, update, abort) => {
      if (val.length < 2) return abort()
      let params = {
        params: {
          take: 20,
          filter: {search: val}
        }
      }
      api.get('/users/v1/users', params).then(response => {
        update(() => {
          let options = array.select(response.data.data, {label: 'full_name', id: 'id'})
          users_list.value = options
        })
      }).catch(error => {
        $q.notify({
          color: 'negative',
          position: 'bottom-right',
          message: 'Error en la Consulta de Usuarios',
          icon: 'report_problem'
        })
        $q.loading.hide()
        reject(error)
      });
    }
    const getCountries= async (val, update, abort) => {
      if (val.length < 2) return abort()
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
        $q.loading.hide()
      });
    }
    const getProvince= async (val, update, abort) => {
      let params = {
        params: {
          take: 100,
          filter: {country: country_id.value,search: val}
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
    }
    const getCities = async (val, update, abort) => {
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
    }

    const selectedImage = (selectedImage) => {
      medias_single.value=selectedImage
    }
    onMounted(() => {
      getCountries()
    });
    return {
      name,
      nit,
      account_site,
      parent_id,
      active,
      account_type_id,
      phone,
      street,
      city_id,
      medias_single,
      province_id,
      country_id,
      options,
      users,
      breadcrumb,
      success,
      account_list,
      account_type_list,
      users_list,
      country_list,
      province_list,
      city_list,
      register,
      getAccount,
      getAccountType,
      getUsers,
      getCountries,
      getProvince,
      getCities,
      selectedImage,
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
