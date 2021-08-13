<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Cuentas</h4>
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
                  label="Nueva Cuenta"
                  color="positive"
                  icon="add"
                  :to="{name:'company.account.create'}"
                />
                <q-form class="needs-validation">
                </q-form>
                <div class="q-pa-md">
                  <q-table
                    :rows="rows"
                    :columns="columns"
                    row-key="id"
                    :loading="loading"
                    :filter="search"
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

                        <q-td key="id" :props="props">
                          {{ props.row.id }}
                        </q-td>
                        <q-td key="name" :props="props">
                          {{ props.row.name }}
                        </q-td>
                        <q-td key="nit" :props="props">
                          {{ props.row.nit }}
                        </q-td>
                        <q-td key="status" class="text-center" :props="props">
                          <q-badge rounded :color="props.row.status?'green':'red'"/>
                        </q-td>
                        <q-td key="created_at" :props="props">
                          {{ props.row.created_at }}
                        </q-td>
                        <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
                          <q-btn color="positive" icon="edit" dense
                                 :to="{name:'company.account.edit',params:{id:props.row.id}}"/>
                          <q-btn icon="delete" color="negative" dense @click="deleteAccount(props.row.id)"/>
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
        name: "Cuentas",
        to: 'company.account.index',
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
      name: 'name',
      required: true,
      label: 'Nombre',
      align: 'left',
      field: row => row.name,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'nit',
      required: true,
      label: 'NIT',
      align: 'left',
      field: row => row.nit,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'status',
      required: true,
      label: 'Estado',
      align: 'left',
      field: row => row.status,
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
    const rows = ref([])
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
    const search = ref(null)
    const loading = ref(true)
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const getAccount = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            status: status.value,
            search: search.value,
          },
          include: [],
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/company/v1/accounts', {params: params}).then(response => {
          rows.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          $q.loading.hide()
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de  Cuentas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const deleteAccount = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/company/v1/account/' + criteria).then(response => {
            $q.loading.hide()
            getAccountTypes()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'La Cuenta a sido eliminada',
              icon: 'report_problem'
            })
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Eliminar La Cuenta ' + error.errors,
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

    function onRequest(props) {
      const {page, rowsPerPage, sortBy, descending} = props.pagination
      const filter = props.filter
      loading.value = true
      // don't forget to update local pagination object
      initialPagination.value.page = page
      initialPagination.value.rowsPerPage = rowsPerPage
      initialPagination.value.sortBy = sortBy
      initialPagination.value.descending = descending
      getAccount()
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
      rows,
      breadcrumb,
      loading,
      order,
      status,
      search,
      deleteAccount,
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
