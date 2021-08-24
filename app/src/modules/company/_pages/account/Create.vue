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
                  <location/>
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
                      <p class="text-subtitle2">Users</p>
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
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Imagen</p>
                      <single-media zone="logo" entity="Modules\Company\Entities\Account"
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
                  <q-btn unelevated color="primary" @click="register" label="Guardar"/>
                  <q-btn outline color="primary" :to="{name:'company.account-type.index'}" label="Cancelar"/>
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

import {onMounted, ref} from 'vue';
import {useRouter} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia";
import Location from "src/modules/location/_components/Location";
import ContactList from "src/modules/company/_components/ContactList";
import SingleUser from "src/modules/user/_components/user/SingleUser";

export default {
  name: 'Create Account Type',
  components: {SingleUser, ContactList, SingleMedia, Breadcrumb, Location},
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
    const account_list = ref([])
    const account_type_list = ref([])
    const users_list = ref([])
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              nit: nit.value,
              account_site: account_site.value,
              parent_id: parent_id.value ? parent_id.value : 0,
              active: active.value,
              account_type_id: account_type_id.value,
              users:users.value,
              medias_single: medias_single.value,
              phone: phone.value,
              street: street.value,
              city_id: city_id.value,
              province_id: province_id.value,
              country_id: country_id.value,
              options: options.value,
            }
          }
          api.post('/company/v1/accounts', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Empresa Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.account-type.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar La Empresa: ' + error.errors,
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
    const getAccountType = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {}
          }
        }
        api.get('/company/v1/account-types', params).then(response => {
          let options = array.select(response.data.data, {label: 'name', id: 'id'})
          account_type_list.value = options
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
          params: {
            take: 20,
            filter: {search: val,roleSlug:'customer'}
          }
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
    const selectedImage = (selectedImage) => {
      medias_single.value = selectedImage
    }
    onMounted(() => {
      getAccountType()
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
      register,
      getAccounts,
      getAccountType,
      getUsers,
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
