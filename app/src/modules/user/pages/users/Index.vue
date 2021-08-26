<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Usuarios</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">

        <div class="row">
          <div class="col-md-12">
            <q-card>
              <q-card-section>
                <q-btn
                  label="Nuevo Usuario"
                  color="positive"
                  icon="add"
                  :to="{name:'user.create'}"
                />
                <q-form class="needs-validation">
                </q-form>
                <div class="q-pa-md">
                  <q-table
                    :rows="user_data"
                    :columns="columns"
                    row-key="id"
                    :loading="loadign"
                    :filter="search"
                    v-model:pagination="initialPagination"
                    @request="onRequest"
                    binary-state-sort
                  >
                    <template v-slot:top-right>
                      <q-input borderless dense debounce="300" v-model="search" placeholder="Buscar">
                        <template v-slot:append>
                          <q-icon name="search"/>
                        </template>
                      </q-input>
                    </template>
                    <template v-slot:body="props">
                      <q-tr :props="props">
                        <q-td
                          v-for="col in props.cols"
                          :key="col.name"
                          :props="props"
                        >
                          {{ col.value }}
                        </q-td>
                        <q-td auto-width class="q-gutter-sm text-center">
                          <q-btn color="positive" icon="edit" dense
                                 :to="{name:'user.edit',params:{id:props.row.id}}"/>
                          <q-btn icon="delete" color="negative" dense @click="deleteUser(props.row.id)"/>
                        </q-td>
                      </q-tr>
                    </template>
                  </q-table>
                </div>
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
        name: "Usuarios",
        to: 'user.index',
        active: true
      }
    ]
    const columns = [{
      name: 'id',
      required: true,
      label: 'Id',
      align: 'left',
      field: row => row.id,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'first_name',
      required: true,
      label: 'Nombres',
      align: 'left',
      field: row => row.first_name,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'last_name',
      required: true,
      label: 'Apellidos',
      align: 'left',
      field: row => row.last_name,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'last_name',
      required: true,
      label: 'Apellidos',
      align: 'left',
      field: row => row.last_name,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'email',
      required: true,
      label: 'Correo E.',
      align: 'left',
      field: row => row.email,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'created_at',
      required: true,
      label: 'Creado el',
      align: 'left',
      field: row => row.created_at,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'actions',
      label: 'Acciones',
      required: true,
      align: 'left',
    },
    ]
    const user_data = ref([])
    const initialPagination = ref({
      sortBy: 'desc',
      descending: false,
      page: 1,
      rowsPerPage: 20,
      rowsNumber: false
    })
    const order = ref({
      field: 'created_at',
      way: 'desc'
    })
    const status = ref(null)
    const role_id = ref(null)
    const search = ref(null)

    const roles_list = ref([])
    const loading = ref(true)
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const onReset = () => {
      first_name.value = null,
        last_name.value = null,
        email.value = null,
        is_activated.value = null,
        password.value = null
    }
    const getUsers = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          filters: {
            status: status.value,
            roleId: role_id.value,
            search: search.value,
          },
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/user/v1/users', params).then(response => {
          user_data.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          success.value = true
          $q.loading.hide()
          resolve(true)
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
    const deleteUser = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/user/v1/users/'+criteria).then(response => {
            $q.loading.hide()
            getUsers()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Usuario a sido eliminado',
              icon: 'report_problem'
            })
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
        } catch (error) {
          $q.loading.hide()
          console.error(error)
        }
      })
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

    function onRequest(props) {
      const {page, rowsPerPage, sortBy, descending} = props.pagination
      const filter = props.filter
      loading.value = true
      // don't forget to update local pagination object
      initialPagination.value.page = page
      initialPagination.value.rowsPerPage = rowsPerPage
      initialPagination.value.sortBy = sortBy
      initialPagination.value.descending = descending
      getVehicles()
      // ...and turn of loading indicator
      loading.value = false

    }
    onMounted(() => {
      onRequest({
        pagination: initialPagination.value,
        filter: undefined
      })
    });
    return {
      columns,
      user_data,
      roles_list,
      breadcrumb,
      loading,
      order,
      status,
      role_id,
      search,
      deleteUser,
      onRequest
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
