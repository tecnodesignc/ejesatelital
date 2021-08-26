<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Marcas</h4>
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
                  label="Nueva Marca"
                  color="positive"
                  icon="add"
                  :to="{name:'vehicle.brand.create'}"
                />
                <q-form class="needs-validation">
                </q-form>
                <div class="q-pa-md" v-if="success">
                  <q-table
                    :rows="rows"
                    :columns="columns"
                    row-key="id"
                    :loading="loading"
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

                        <q-td key="id" :props="props">
                          {{ props.row.id }}
                        </q-td>
                        <q-td key="name" :props="props">
                          {{ props.row.name }}
                        </q-td>
                        <q-td key="status" class="text-center" :props="props">
                          <q-badge rounded :color="props.row.status?'green':'red'"/>
                        </q-td>
                        <q-td key="created_at" :props="props">
                          {{ props.row.created_at }}
                        </q-td>
                        <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
                          <q-btn color="positive" icon="edit" dense
                                 :to="{name:'vehicle.brand.edit',params:{id:props.row.id}}"/>
                          <q-btn icon="delete" color="negative" dense @click="deleteBrand(props.row.id)"/>
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
  name: 'Index Brand',
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
        name: "Brand",
        to: 'vehicle.brand.index',
        active: true
      }
    ]
    const columns = [
      {
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
      field: row => row.status,
      format: val => `${val}`,
      sortable: true
    },
      {
        name: 'status',
        required: true,
        label: 'Estado',
        align: 'left',
        field: row => row.status,
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
    const getBrands = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            status: status.value,
            search: search.value,
          },
          include: '',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/vehicle/v1/brands', {params: params}).then(response => {
          rows.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          success.value=true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de  Marca',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const deleteBrand = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/vehicle/v1/brands/' + criteria).then(response => {
            $q.loading.hide()
            getBrands()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'La Marca a sido eliminada',
              icon: 'report_problem'
            })
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Eliminar La Marca ' + error.errors,
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
      getBrands()
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
      initialPagination,
      success,
      deleteBrand,
      onRequest
    };
  }
};
</script>

<style lang="scss">
</style>
