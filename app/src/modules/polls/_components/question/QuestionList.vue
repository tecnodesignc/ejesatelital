<template>
  <div class="row q-ma-md">
    <div class="col-md-12">
      <q-btn
        label="Nueva pregunta"
        color="primary"
        icon="add"
        dense
        @click="savePoll"
        v-if="!poll"
      />
          <single-question :poll="poll" @upload="refreshList" v-else/>
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
                  <q-td key="statement" :props="props">
                    {{ props.row.statement }}
                  </q-td>
                  <q-td key="type" :props="props">
                    {{props.row.type}}
                  </q-td>
                  <q-td key="answers" :props="props">
                    {{props.row.answers.length}}
                  </q-td>
                  <q-td key="created_at" :props="props">
                    {{ props.row.created_at }}
                  </q-td>
                  <q-td key="actions" :props="props" auto-width class="q-gutter-sm text-center">
                    <single-question :question="props.row.id" :poll="poll" @upload="refreshList"/>
                    <q-btn icon="delete" color="negative" dense @click="deleteQuestion(props.row.id)"/>
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
import SingleQuestion from "src/modules/polls/_components/question/SingleQuestion";

export default {
  name: 'QuestionList',
  components: {
    SingleQuestion
  },
  props: {
    poll: {
      type: Number,
      required:true
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
      name: 'statement',
      required: true,
      label: 'Enunciado',
      align: 'left',
      field: row => row.statement,
      format: val => `${val}`,
      sortable: true
    }, {
      name: 'type',
      required: true,
      label: 'Typo de pregunta',
      align: 'left',
      field: row => row.email,
      format: val => `${val}`,
      sortable: true
    },{
      name: 'answers',
      required: true,
      label: 'Respuestas',
      align: 'left',
      field: row => row.answers.length,
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
    const getQuestions = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            search: search.value,
            poll:props.poll
          },
          include: 'answers',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/polls/v1/questions', {params: params}).then(response => {
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
    const deleteQuestion = async (id) => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        try {
          let criteria = id

          api.delete('/polls/v1/questions/' + criteria).then(response => {
            $q.loading.hide()
            getQuestion()
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'La Pregunta a sido eliminada',
              icon: 'report_problem'
            })
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Eliminar La pregunta ' + error.errors,
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
    const savePoll = () => {
      contex.emit('savePoll', true)
    }
    function refreshList(upload) {
      if(upload){
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
      getQuestions()
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
      deleteQuestion,
      onRequest,
      refreshList,
      savePoll
    };
  },
};
</script>
<style lang="scss">
</style>
