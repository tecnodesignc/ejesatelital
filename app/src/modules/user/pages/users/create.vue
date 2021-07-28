<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Dashboard</h4>
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
                <h4 class="header-title">Crear Usuario</h4>
                <pre>{{permissions_list.length}}</pre>
                <form class="needs-validation" novalidate>
                  <q-tabs
                    v-model="tab"
                    dense
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
                          <p class="text-subtitle2">Correo Electronico</p>
                          <q-input
                            outlined
                            v-model="email"
                            stack-label
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
                            name="music_genre"
                            v-model="is_activated"
                            :true-value="true"
                            label="Pop"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Contraseña</p>
                          <q-input
                            outlined
                            v-model="email"
                            stack-label
                            dense
                            placeholder="Contraseña"
                            lazy-rules
                            :rules="[ val => val && val.length > 0 || 'Campo Obligatorio',
                                      val => val.length > 8 || 'Por favor use minimo 8 caracteres',]"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Confirmación de contraseña</p>
                          <q-input
                            outlined
                            v-model="email"
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
                            :options="roles_list"
                            placeholder="Roles"
                          />
                        </div>
                      </div>
                    </q-tab-panel>

                    <q-tab-panel name="pane-2">
                      <div class="text-h6">Permisos</div>
                      <div class="row">
                        <p class="pull-right">
                          <q-btn
                            flat
                            color="primary"
                            @click="changeStateForAll(1)"
                            label=" allow all">

                          </q-btn>
                          <q-btn
                            flat
                            color="primary"
                            @click="changeStateForAll(0)"
                            label="inherit all"
                          />
                          <q-btn
                            flat
                            color="primary"
                            @click="changeStateForAll(-1)"
                            label="deny all"
                          />
                        </p>

                        <div v-if="permissions_list.length" v-for="(value, name) in permissions_list" :key="name">
                          <pre>{{name}}</pre>
                          <h3>{{ name }}</h3>
                          <div v-for="(permissionActions, subPermissionTitle) in value" :key="subPermissionTitle">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-3"><h4 class="pull-left">{{ ucfirst(subPermissionTitle) }}</h4>
                                  </div>
                                  <div class="col-md-9">
                                    <p style="margin-top: 10px;">
                                      <q-btn
                                        flat
                                        color="primary"
                                                 @click="changeState(subPermissionTitle, permissionActions, 1)" label="allow all"/>
                                      <q-btn
                                        flat
                                        color="primary"
                                                 @click="changeState(subPermissionTitle, permissionActions, 0)" label="inherit all"/>

                                      <q-btn flat
                                             color="primary"
                                                 @click="changeState(subPermissionTitle, permissionActions, -1)" label="deny all"/>
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12" v-for="(label, permissionAction) in permissionActions"
                                   :key="permissionAction">
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="visible-sm-block visible-md-block visible-lg-block">
                                      <label class="control-label text-right"
                                             style="display: block">{{ label }}</label>
                                    </div>
                                    <div class="visible-xs-block">
                                      <label class="control-label">{{ label }}</label>
                                    </div>
                                  </div>
                                  <div class="col-md-9">
                                    <q-btn-toggle
                                      v-model="permissions[`${subPermissionTitle}.${permissionAction}`]"
                                      class="my-custom-toggle"
                                      no-caps
                                      rounded
                                      unelevated
                                      toggle-color="primary"
                                      color="white"
                                      text-color="primary"
                                      :options="[
                                          {label: 'allow', value: '1'},
                                          {label: 'inherit', value: '0'},
                                          {label: 'deny', value: '-1'}
                                      ]"
                                    />

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </q-tab-panel>
                  </q-tab-panels>
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
import {Loading, Notify} from "quasar";
import {computed, onMounted} from 'vue'
import axios from "axios";

export default {
  name: 'Create User',
  components: {Breadcrumb},
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
    const first_name = ref(null)
    const last_name = ref(null)
    const email = ref(null)
    const is_activated = ref(false)
    const roles = ref(null)
    const password = ref(null)
    const password_confirmation = ref(null)
    const permissions = ref(null)
    const permissions_list = ref([])
    const roles_list = ref(null)
    //const store = useStore();
    const router = useRouter()
    const tab = ref('pane-0')
    const getPermissionKey = async (subPermissionTitle, permissionAction) => {
      return `${subPermissionTitle}.${permissionAction}`;
    }
    const changeState = async (permissionPart, actions, state) => {
      _.forEach(actions, (translationKey, key) => {
        permissions.value[`${permissionPart}.${key}`] = state;
      });
    }
    const changeStateForAll = async (state) => {
      _.forEach(this.permissions, (index, permission) => {
        permissions.value[permission] = state;
      });
    }
    const getPermission = async () => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        api.get('/user/v1/permissions').then(response => {
          $q.loading.hide()
          permissions_list.value=response.data.permissions
          console.log(permissions_list.value)
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de permisos',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        })
      })
    }

    const register = async () => {
      try {
        const params = {
          attributes: {
            first_name: first_name.value,
            last_name: last_name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
            is_activated: is_activated.value,
            roles: roles.value,
            permissions: permissions.value

          }
        }
      } catch (error) {
        console.error('Register Login', error)
      }


    }
    const onReset = () => {
      first_name.value = null,
        last_name.value = null,
        email.value = null,
        is_activated.value = null
      password.value = null
    }

    onMounted(() => {
      getPermission()
    });

    return {
      first_name,
      last_name,
      email,
      is_activated,
      password,
      password_confirmation,
      roles,
      permissions,
      breadcrumb,
      tab,
      permissions_list,
      roles_list,
      register,
      changeStateForAll,
      changeState,
      onReset
    };
  }
};
</script>

<style>

</style>
