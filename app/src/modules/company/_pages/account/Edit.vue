<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Cuenta: {{ name }}</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper" v-if="success">
        <q-form class="needs-validation">
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
                      <p class="text-subtitle2">Sitio Web</p>
                      <q-input
                        outlined
                        v-model="account_site"
                        stack-label
                        dense
                        placeholder="account_site"
                        lazy-rules
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
                        name="phone"
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
                        placeholder="Dirección"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <location :city="city" :country="country" :province="province" @location="emitLocation"/>
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
                        @filter="getAccounts"
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
                        name="account_type"
                        emit-value
                        map-options
                        :options="account_type_list"
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
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Adminstradores de la Cuenta</p>
                      <div class="row">
                        <div class="col-10">
                          <q-select
                            outlined
                            dense
                            v-model="users"
                            emit-value
                            name="users"
                            map-options
                            multiple
                            use-input
                            :options="users_list"
                            @filter="getUsers"
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
                        <div class="col-2">
                          <single-user/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Conductores</p>
                      <div class="row">
                        <div class="col-10">
                          <q-select
                            outlined
                            dense
                            v-model="drivers"
                            emit-value
                            name="users"
                            map-options
                            multiple
                            use-input
                            :options="drivers_list"
                            @filter="getDriver"
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
                        <div class="col-2">
                          <single-user/>
                        </div>
                      </div>

                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Imagen</p>
                      <single-media zone="logo" entity="Modules\Company\Entities\Account" :entity_id="id"
                                    @selectedImage="selectedImage"/>
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
                  <q-btn unelevated color="primary" @click="update" label="Actualizar"/>
                  <q-btn outline color="primary" :to="{name:'company.account.index'}" label="Cancelar"/>
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
import ContactList from "src/modules/company/_components/ContactList";
import SingleUser from "src/modules/user/_components/user/SingleUser";

export default {
  name: 'Editar Account Type',
  components: {SingleUser, ContactList, Location, Breadcrumb, SingleMedia},
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
        name: "Editar Cuenta",
        to: 'company.account.create',
        active: true
      }
    ]
    const id = ref(null)
    const name = ref(null)
    const nit = ref(null)
    const account_site = ref(null)
    const parent_id = ref(null)
    const active = ref(false)
    const account_type_id = ref(null)
    const medias_single = ref(null)
    const phone = ref(null)
    const street = ref(null)
    const city_id = ref(null)
    const province_id = ref(null)
    const country_id = ref(null)
    const options = ref([])
    const users = ref([])
    const drivers = ref([])
    const account_list = ref([])
    const account_type_list = ref([])
    const users_list = ref([])
    const drivers_list = ref([])
    const country = ref([])
    const province = ref([])
    const city = ref([])
    const success = ref(false)
    const router = useRouter()
    const route = useRoute()
    const update = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = id.value
          let media = medias_single.value
          let params = {
            attributes: {
              id: id.value,
              name: name.value,
              nit: nit.value,
              account_site: account_site.value,
              parent_id: parent_id.value ? parent_id.value : 0,
              active: active.value,
              account_type_id: account_type_id.value,
              users:users.value,
              phone: phone.value,
              street: street.value,
              city_id: city_id.value,
              province_id: province_id.value,
              country_id: country_id.value,
              options: options.value,
            }
          }

          if (media) params.attributes.medias_single = media
          api.put('/company/v1/accounts/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Empresa Editada Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.account.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar La Cuenta: ' + error.errors,
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
          resolve(true)
        }).catch(error => {
          console.error(error)
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Cuentas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const getAccount = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = route.params.id
        let params = {
          include: 'users,contacts,country,province,city'
        }
        api.get('/company/v1/accounts/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          name.value = data.name
          nit.value = data.nit
          account_site.value = data.account_site
          parent_id.value = data.parent_id
          active.value = data.status ? data.status : false
          account_type_id.value = data.account_type_id
          phone.value = data.phone
          street.value = data.street
          city_id.value = data.city_id
          province_id.value = data.province_id
          country_id.value = data.country_id
          options.value = data.options
          city.value = data.city
          province.value = data.province
          country.value = data.country
          users.value = data.users ? data.users.map(item => {
           let roles= item.roles_id
            if(roles.find(element => element = 3)){
              return item.id
            }
          }) : []
          users_list.value = array.select(data.users, {label: 'full_name', id: 'id'})
          drivers.value = data.users ? data.users.map(item => {
            let roles= item.roles_id
            if(roles.find(element => element = 3)){
              return item.id
            }
          }) : []
          drivers_list.value = array.select(data.users, {label: 'full_name', id: 'id'})
          success.value = true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de la Cuenta ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const getAccountType = () => {

      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {}
          }
        }
        api.get('/company/v1/account-types', params).then(response => {
          account_type_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Tipos Cuentas',
            icon: 'report_problem'
          })
          console.error(error)
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const getUsers = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
            take: 20,
            filter: {search: val,roleSlug:'customer'}
          }
        api.get('/user/v1/users', {params: params}).then(response => {
          update(() => {
            users_list.value = array.select(response.data.data, {label: 'full_name', id: 'id'})
          })
          resolve(true)
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
      });
    }
    const getDriver = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
            take: 20,
            filter: {search: val,roleSlug:'conductor'}
          }
        api.get('/user/v1/users', {params: params}).then(response => {
          update(() => {
            drivers_list.value = array.select(response.data.data, {label: 'full_name', id: 'id'})
          })
          resolve(true)
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
      });
    }
    const selectedImage = (selectedImage) => {
      medias_single.value = selectedImage
    }
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    onMounted(async () => {
     await getAccountType()
     await getAccount()
    });
    return {
      id,
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
      drivers,
      drivers_list,
      breadcrumb,
      success,
      account_list,
      account_type_list,
      users_list,
      country,
      province,
      city,
      update,
      getAccounts,
      getAccountType,
      getUsers,
      getDriver,
      selectedImage,
      emitLocation
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
