<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Usuario: {{ full_name }}</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <q-card>
              <q-card-section>
                <form class="needs-validation" novalidate>
                  <q-tabs
                    v-model="tab"
                    align="left"
                    class="bg-primary text-white shadow-2"
                    :breakpoint="0"
                  >
                    <q-tab name="pane-0" label="Datos"/>
                    <q-tab name="pane-1" label="Roles"/>
                    <q-tab name="pane-2" label="Permisos"/>
                  </q-tabs>
                  <q-separator/>
                  <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="pane-0">
                      <div class="text-h6">Datos</div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Nombres</p>
                          <q-input
                            outlined
                            v-model="first_name"
                            stack-label
                            dense
                            placeholder="Nombres"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Apellidos</p>
                          <q-input
                            outlined
                            v-model="last_name"
                            stack-label
                            dense
                            placeholder="Apellidos"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Identificación</p>
                          <q-input
                            outlined
                            v-model="identification"
                            stack-label
                            dense
                            placeholder="Identificación"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Correo Electronico</p>
                          <q-input
                            outlined
                            v-model="email"
                            stack-label
                            type="email"
                            dense
                            placeholder="Correo Electronico"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <q-toggle
                            name="is_activate"
                            v-model="is_activated"
                            :true-value="true"
                            label="Activar Usuario"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Contraseña</p>
                          <q-input
                            outlined
                            v-model="password"
                            type="password"
                            stack-label
                            dense
                            placeholder="Contraseña"
                            lazy-rules
                            :rules="[ val => val && val.length > 0 || 'Campo Obligatorio',
                                      val => val.length > 7 || 'Por favor use minimo 8 caracteres',]"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Confirmación de contraseña</p>
                          <q-input
                            outlined
                            type="password"
                            v-model="password_confirmation"
                            stack-label
                            dense
                            placeholder="Confirmación de contraseña"
                            lazy-rules
                            :rules="[val => val && val.length > 0 || 'Campo Obligatorio',
                                      val => val === password || 'La Contraseña no Coincide']"
                          />
                        </div>
                      </div>
                    </q-tab-panel>
                    <q-tab-panel name="pane-1">
                      <div class="text-h6">Roles</div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <q-select
                            outlined
                            dense
                            v-model="roles"
                            multiple
                            emit-value
                            map-options
                            :options="roles_list"
                            placeholder="Roles"
                          />
                        </div>
                      </div>
                    </q-tab-panel>

                    <q-tab-panel name="pane-2">
                      <div class="text-h6">Permisos</div>
                      <permissions @callPermissions="callPermissions"/>
                    </q-tab-panel>
                  </q-tab-panels>
                  <div class="q-pa-md q-gutter-sm">
                    <q-btn unelevated color="primary" @click="update" label="Guardar"/>
                    <q-btn outline color="primary" label="Cancelar"/>
                  </div>
                </form>
              </q-card-section>
            </q-card>
          </div>
        </div>
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

export default {
  name: 'Create User',
  components: {Breadcrumb, Permissions},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "user",
        to: 'user.create',
        active: true
      }
    ]
    const id = ref(null)
    const full_name = ref(null)
    const first_name = ref(null)
    const last_name = ref(null)
    const identification = ref(null)
    const email = ref(null)
    const is_activated = ref(false)
    const roles = ref([])
    const password = ref(null)
    const permissions = ref([])
    const password_confirmation = ref(null)
    const roles_list = ref([])
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const route = useRoute()
    const fields= ref([])


    const tab = ref('pane-0')
    const update = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria =id.value

          fields.value.identification=identification.value

          let params = {
            attributes: {
              id:id.value,
              first_name: first_name.value,
              last_name: last_name.value,
              email: email.value,
              password: password.value,
              password_confirmation: password_confirmation.value,
              is_activated: is_activated.value,
              roles: roles.value,
              permissions: permissions.value,
              fields:fields.value
            }
          }

          api.put('/user/v1/users/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Usuario Editado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'user.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Usuario: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Register Login', error)
      }
    }
    const onReset = () => {
      first_name.value = null,
        last_name.value = null,
        email.value = null,
        is_activated.value = null,
        password.value = null
    }

    function callPermissions(getPermissions) {
      permissions.value = getPermissions

    }

    const getRoles = () => {
      return new Promise(async (resolve, reject) => {
        api.get('/user/v1/roles').then(response => {
          roles_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Roles',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const getUser = () => {
      $q.loading.show()
      let criteria = route.params.id
      return new Promise(async (resolve, reject) => {
        api.get('/user/v1/users/' + criteria).then(response => {
          let userData = response.data.data;
          id.value=userData.id
          full_name.value=userData.full_name
          first_name.value = userData.first_name
          last_name.value = userData.last_name
          email.value = userData.email
          is_activated.value = userData.is_activated
          roles.value = userData.roles_id
          permissions.value = userData.permissions
          identification.value = userData.fields.identification
          fields.value=userData.fields

          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Usuario ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    onMounted(() => {
      getUser()
      getRoles()
    });
    return {
      first_name,
      last_name,
      full_name,
      email,
      identification,
      is_activated,
      password,
      password_confirmation,
      roles,
      breadcrumb,
      permissions,
      tab,
      roles_list,
      success,
      callPermissions,
      update,
      onReset
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
