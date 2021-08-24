<template>
  <div class="row q-ma-md">
    <div class="col-md-12">
      <q-btn
        label="Nueva Respuesta"
        color="primary"
        icon="add"
        dense
        @click="saveQuestion"
        v-if="!question"
      />
      <single-answer :question="question" @upload="refreshList" v-else/>
      <div class="q-pa-md" v-if="success">
        <q-table style="max-width: 100%"
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
              <q-td key="title" :props="props">
                {{ props.row.title }}
              </q-td>
              <q-td key="caption" :props="props">
                {{ props.row.caption }}
              </q-td>
              <q-td key="created_at" :props="props">
                {{ props.row.created_at }}
              </q-td>
              <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
                <single-answer :answer="props.row.id" :question="question" @upload="refreshList"/>
                <q-btn icon="delete" color="negative" dense @click="deleteAnswer(props.row.id)"/>
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
import SingleAnswer from "src/modules/polls/_components/answers/SingleAnswer";

export default {
  name: 'AnswerList',
  components: {
    SingleAnswer,
  },
  props: {
    question: {
      type: Number,
      default: 0
    }
  },
  setup(props, contex) {
    const $q = useQuasar();
    const store = useStore();
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
        name: 'title',
        required: true,
        label: 'titulo',
        align: 'left',
        field: row => row.title,
        format: val => `${val}`,
        sortable: true
      }, {
        name: 'caption',
        required: true,
        label: 'Ayuda',
        align: 'left',
        field: row => row.caption,
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
    const getAnswer = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            search: search.value,
            question: props.question
          },
          include: '',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/polls/v1/answers', {params: params}).then(response => {
          rows.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          success.value = true
          $q.loading.hide()
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Respuestas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const deleteAnswer = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/polls/v1/Answers/' + criteria).then(response => {
            $q.loading.hide()
            getAnswer()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'La Respuesta a sido eliminada',
              icon: 'report_problem'
            })
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Eliminar La Respuesta ' + error.errors,
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
    const saveQuestion = () => {
      contex.emit('saveQuestion', true)
    }
    function refreshList(upload) {
      if (upload) {
        onRequest({
          pagination: initialPagination.value,
          filter: undefined
        })
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
      getAnswer()
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
      deleteAnswer,
      onRequest,
      refreshList,
      saveQuestion
    };
  },
};
</script>
<style lang="scss">
</style>
