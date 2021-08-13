<template>
  <div class="row q-ma-md">
    <div class="col-md-12">
          <single-contact :account="account" @upload="refreshList"/>
          <div class="q-pa-md" v-if="success">
            <q-table
              :rows="rows"
              :columns="columns"
              v-model:pagination="initialPagination"
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
                  <q-td key="first_name" :props="props">
                    {{ props.row.first_name }} {{ props.row.last_name }}
                  </q-td>
                  <q-td key="email" :props="props">
                    {{props.row.email}}
                  </q-td>
                  <q-td key="mobile" :props="props">
                    {{props.row.mobile}}
                  </q-td>
                  <q-td key="created_at" :props="props">
                    {{ props.row.created_at }}
                  </q-td>
                  <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
                    <single-contact :contact="props.row.id" :account="account" @upload="refreshList"/>
                    <q-btn icon="delete" color="negative" dense @click="deleteContact(props.row.id)"/>
                  </q-td>
                </q-tr>
              </template>
            </q-table>
          </div>
    </div>
  </div>
</template>

<script>

import {api} from "boot/axios";
import {onMounted, ref} from 'vue'
import {useQuasar} from "quasar";
import {useStore} from "vuex";
import Breadcrumb from "../../../components/Breadcrumb.vue";
import SingleContact from "src/modules/company/_components/SingleContact";

export default {
  name: 'ContactList',
  components: {
    SingleContact,
    Breadcrumb
  },
  props: {
    account: {
      type: Number,
      default: 0
    }
  },
  setup(props, contex) {
    const $q = useQuasar();
    const store = useStore();
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
      label: 'Nombre',
      align: 'left',
      field: row => row.first_name,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'email',
      required: true,
      label: 'Correo Electronico',
      align: 'left',
      field: row => row.email,
      format: val => `${val}`,
      sortable: true
    },{
      name: 'mobile',
      required: true,
      label: 'Telefono',
      align: 'left',
      field: row => row.mobile,
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
    const search = ref(null)
    const loading = ref(true)
    const success = ref(false)
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
    const getContact = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            status: status.value,
            search: search.value,
            account:props.account?props.account:null
          },
          include: '',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/company/v1/contacts', {params: params}).then(response => {
          rows.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          success.value=true
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
    const deleteContact = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/company/v1/contacts/' + criteria).then(response => {
            $q.loading.hide()
            getContact()
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
    function refreshList(upload) {
      if(upload){
        getContact()
      }
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
      getContact()
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
      loading,
      order,
      search,
      success,
      deleteContact,
      onRequest,
      refreshList
    };
  },
};
</script>
<style lang="scss">
</style>
