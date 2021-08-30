<template>
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
          <q-td key="user" :props="props">
            {{ props.row.user.full_name }}
          </q-td>
          <q-td key="title" :props="props">
            {{ props.row.title }}
          </q-td>
          <q-td key="message" :props="props">
            <q-chip size="sm" :color="colorChip(props.row.message)">
              {{ props.row.message_value }}
            </q-chip>
          </q-td>
          <q-td key="time_ago" :props="props">
            {{ props.row.time_ago }}
          </q-td>
          <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
            <q-btn color="positive" icon="visibility" dense
                   :to="{name:'history.view',params:{id:props.row.id}}"/>
          </q-td>
        </q-tr>
      </template>
    </q-table>
</template>

<script>

import {ref, onMounted, onBeforeUnmount} from 'vue'

import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";
import {echo} from "boot/laravel-echo";

export default {
  name: 'HistoryUser',
  props: {
    user_id: {
      type: Number,
      default: 0
    },
  },
  setup(props) {
    const $q = useQuasar();
    const store = useStore()
    const columns = [
      {
        name: 'id',
        required: true,
        label: 'Id',
        align: 'left',
        field: row => row.id,
        format: val => `${val}`,
        sortable: true
      },
      {
        name: 'user',
        required: true,
        label: 'Usuario',
        align: 'left',
        field: row => row.user.full_name,
        format: val => `${val}`,
        sortable: true
      },
      {
        name: 'title',
        required: true,
        label: 'Evento',
        align: 'left',
        field: row => row.title,
        format: val => `${val}`,
        sortable: true
      },
      {
        name: 'message',
        required: true,
        label: 'Valor',
        align: 'left',
      },
      {
        name: 'time_ago',
        required: true,
        label: 'Fecha',
        align: 'left',
        field: row => row.time_ago,
        format: val => `${val}`,
        sortable: true
      },
      {
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
    const search = ref(null)
    const loading = ref(true)
    const getHistory = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            filter: {
              user: props.user_id,
              search: search.value,
              order:order.value
            },
            include: 'user',
            page: initialPagination.value.page,
            take: initialPagination.value.rowsPerPage
          }
          api.get('/history/v1/histories', {params: params}).then(response => {
            rows.value = response.data.data
            initialPagination.value.rowsNumber = response.data.meta.page.total
            $q.loading.hide()
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error en la consulta del Historial: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en la consulta del Historial', error)
      }
    }
    function colorChip (message){
      let color ='primary'

      switch (message) {

        case "0":
          color='negative'
          break;
        case "1":
          color=  'positive'
          break;
        case "2":
          color=  'orange'
          break;
        default:
          break;

      }
      return  color
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
      getHistory()
      // ...and turn of loading indicator
      loading.value = false

    }
    const init = async () => {
      console.warn()
      echo.channel('histories').listen(`.histories.account.${store.state.account.account_id}.user.${props.user_id}`, message => {
        onRequest({
          pagination: initialPagination.value,
          filter: undefined
        })
      })
      onRequest({
        pagination: initialPagination.value,
        filter: undefined
      })
    }

    onMounted(() => {
      init()
    });
    return {
      columns,
      rows,
      loading,
      order,
      search,
      colorChip,
      onRequest
    }
  }
};
</script>
<style lang="scss">

</style>
