<template>
  <q-btn
    :color="user?'positive':'primary'"
    :icon="user?'edit':'add'"
    v-bind:auto-width="user"
    :dense="user?true:false"
    @click="openDialog"
  />
  <q-dialog v-model="dialogNF">
    <q-layout view="Lhh lpR fff" container class="bg-white" style="width: 1920px; max-width: 80vw;">
      <q-header class="bg-primary">
        <q-toolbar>
          <q-toolbar-title> {{ user ? `usuario: ${fullName}` : 'Nuevo Usuario' }}</q-toolbar-title>
          <q-btn flat v-close-popup round dense icon="close"/>
        </q-toolbar>
      </q-header>
      <q-page-container>
        <q-page padding>
          <q-form class="needs-validation" ref="formUser">
            <div class="row">
              <div class="col-md-12 q-px-sm">
                <q-card class="q-mb-sm">
                  <q-card-section>
                    <div class="text-h6">Datos</div>
                  </q-card-section>
                  <q-separator/>
                  <q-card-section>
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
                  </q-card-section>
                </q-card>
              </div>
            </div>
            <q-footer>
              <q-card class="q-mb-sm">
                <div class="q-pa-md q-gutter-sm">
                  <q-btn  color="primary" @click="registerUser" :label="user?'Actualizar':'Guardar'"/>
                  <q-btn outline color="primary" v-close-popup label="Cancelar"/>
                </div>
              </q-card>
            </q-footer>
          </q-form>
        </q-page>
      </q-page-container>
    </q-layout>
  </q-dialog>
</template>

<script>

import {computed, onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";
import AnswerList from "src/modules/polls/_components/answers/AnswerList";

export default {
  name: 'SingleUser',
  components: {},
  props: {
    user: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const contactForm = ref(null)
    const $q = useQuasar()
    const store = useStore();
    const formUser = ref(null)
    const id = ref(null)
    const first_name = ref(null)
    const last_name = ref(null)
    const identification = ref(null)
    const email = ref(null)
    const is_activated = ref(false)
    const roles = ref([])
    const password = ref(null)
    const permissions = ref([])
    const password_confirmation = ref(null)
    const success = ref(false)
    const dialogNF = ref(false)
    const registerUser = async () => {
      try {
        return new Promise(async (resolve, reject) => {
          formUser.value.validate().then(async success => {
            if (success) {
              let params = {
                attributes: {
                  first_name: first_name.value,
                  last_name: last_name.value,
                  email: email.value,
                  password: password.value,
                  password_confirmation: password_confirmation.value,
                  is_activated: is_activated.value,
                  roles: roles.value,
                  permissions: permissions.value,
                  fields: {
                    identification: identification.value
                  },
                }
              }
              api.post('/user/v1/users/create', params).then(response => {
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'Usuario Guardado Corectamente',
                  icon: 'report_problem'
                })

                contex.emit('userSave', response.data.data)
                dialogNF.value=false
              }).catch(error => {
                $q.notify({
                  color: 'negative',
                  position: 'bottom-right',
                  message: 'Error al guardar La Pregunta: ' + error.errors,
                  icon: 'report_problem'
                })
                $q.loading.hide()
                reject(error)
              });
            }
          })
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Pregunta', error)
      }

    }
    const updateUser = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = id.value
          let params = {
            attributes: {
              id: id.value,
              first_name: first_name.value,
              last_name: last_name.value,
              email: email.value,
              password: password.value,
              password_confirmation: password_confirmation.value,
              is_activated: is_activated.value,
              roles: roles.value,
              permissions: permissions.value,
              fields: {
                identification: identification.value
              },
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
            contex.emit('UserSave', params.attributes)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar EL Usuario: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar EL Usuario', error)
      }
    }
    const getUser = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = props.user
        let params = {
          include: 'roles'
        }
        api.get('/user/v1/users/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          first_name.value = data.first_name
          last_name.value = data.last_name
          email.value = data.email
          is_activated.value = data.is_activated
          roles.value = data.roles
          permissions.value = data.permissions
          success.value = true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta del Usuario ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const openDialog = async () => {
      if (props.question) {
        await getUser()
      }
      dialogNF.value = true
    }
    onMounted(async () => {
    });
    return {
      id,
      first_name,
      last_name,
      email,
      identification,
      is_activated,
      password,
      password_confirmation,
      roles,
      permissions,
      success,
      dialogNF,
      formUser,
      openDialog,
      registerUser,
      updateUser,
    };
  },
};
</script>
<style lang="scss">
</style>
