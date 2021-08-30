<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Perfil</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <div class="row">
          <div class="col-12">
           <profile/>
            <history-user :user_id="$store.state.auth.userId" class="q-my-lg"/>
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
import HistoryUser from "src/modules/history/_components/widgets/HistoryUser";
import Profile from "src/modules/user/_components/profile/Profile";

export default {
  name: 'Create User',
  components: {Profile, HistoryUser, Breadcrumb, Permissions},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Perfil",
        to: 'profile.personal',
        active: true
      }
    ]
    const id = ref(null)
    const password = ref(null)
    const permissions = ref([])
    const password_confirmation = ref(null)
    const roles_list = ref([])
    const success = ref(false)
    const change_password=ref(false)
    //const store = useStore();
    const router = useRouter()
    const route = useRoute()
    const fields = ref([])
    const tab = ref('pane-0')
    const update = async () => {
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
              fields: {identification:identification.value}
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
          id.value = userData.id
          full_name.value = userData.full_name
          first_name.value = userData.first_name
          last_name.value = userData.last_name
          email.value = userData.email
          is_activated.value = userData.is_activated
          roles.value = userData.roles_id
          permissions.value = userData.permissions
          identification.value = userData.fields ? userData.fields.identification : ''
          fields.value = userData.fields
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
    });
    return {
      breadcrumb
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
