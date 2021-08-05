<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Tipos de Cuentas</h4>
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
                  label="Nuevo Tipo de Cuenta"
                  color="positive"
                  icon="add"
                  :to="{name:'company.account-type.create'}"
                />
                <form class="needs-validation" novalidate>
                </form>
                <div class="q-pa-md">
                  <q-table
                    :rows="rows"
                    :columns="columns"
                    row-key="id"
                    :loading="loadign"
                    :filter="search"
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
                                 :to="{name:'company.account-type.edit',params:{id:props.row.id}}"/>
                          <q-btn icon="delete" color="negative" dense @click="deleteAccountType(props.row.id)"/>
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
        name: "Tipos de cuentas",
        to: 'company.account-type.index',
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
    },{
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
    const initialPagination = {
      sortBy: 'desc',
      descending: false,
      page: 1,
      rowsPerPage: 20
    }
    const order = ref({
      field: 'created_at',
      way: 'desc'
    })
    const status = ref(null)
    const search = ref(null)
    const loadign = ref(true)
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const getAccountTypes = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          filters: {
            status: status.value,
            search: search.value,
          },
          page: initialPagination.page.value,
          take: initialPagination.rowsPerPage.value
        }
        api.get('/company/v1/account-types', params).then(response => {
          rows.value = response.data.data
          success.value = true
          loadign.value = false
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Tipos de Cuenta',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const deleteAccountType = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/company/v1/account-types/'+criteria).then(response => {
            $q.loading.hide()
            getAccountTypes()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Tipo de Empresa a sido eliminada',
              icon: 'report_problem'
            })
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Eliminar el Tipo de Empresa: ' + error.errors,
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
    onMounted(() => {
      getAccountTypes()
    });
    return {
      columns,
      rows,
      breadcrumb,
      loadign,
      order,
      status,
      search,
      deleteAccountType,
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
