<template>
  <div class="row">
    <div class="col-md-12">
      <q-card>
        <q-card-section class="q-gutter-sm">
          <q-btn color="positive" icon="arrow_back" @click="getMedia(back)"/>
        </q-card-section>
        <q-card-section class="q-gutter-sm">
          <new-folder :parent_id="parent" @upload="refreshMedia"/>
          <new-file :folder_id="folder" @upload="refreshMedia"/>
          <!--              <q-btn-group>
                          <q-btn
                            color="warning"
                            label="mover"
                          />
                          <q-btn
                            color="negative"
                            label="Eliminar"
                          />
                        </q-btn-group>-->
        </q-card-section>
        <q-card-section>
          <div class="q-pa-md" v-if="success">
            <q-table
              :rows="media"
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
                  <q-td key="icon" :props="props">
                    <q-img class="q-ma-md" v-if="props.row.isImage"
                           :src="props.row.path"
                           spinner-color="red"
                           style="height: 80px; max-width: 80px"
                    />
                    <q-icon name="folder" v-else-if="props.row.isFolder" class="text-teal"
                            @click="getMedia(props.row.id)"
                            style="font-size: 4.4em;"/>
                    <q-icon name="description" v-else class="text-teal" style="font-size: 4.4em;"/>
                  </q-td>
                  <q-td key="filename" :props="props">
                    {{ props.row.filename }}
                  </q-td>
                  <q-td key="created_at" :props="props">
                    {{ props.row.created_at }}
                  </q-td>
                  <q-td key="actions" :props="props" auto-width class="text-center">
                    <q-btn color="positive" :label="props.row.isFolder?'Abir':'Selecionar'"
                           @click="props.row.isFolder?getMedia(props.row.id):select(props.row)"/>
                  </q-td>
                </q-tr>
              </template>
            </q-table>
          </div>
        </q-card-section>

      </q-card>
    </div>
  </div>
</template>

<script>

import NewFolder from './NewFolder'
import NewFile from './NewFile'
import {api} from "boot/axios";
import {onMounted, ref} from 'vue'
import {useQuasar} from "quasar";
import {useStore} from "vuex";
import Breadcrumb from "../../../components/Breadcrumb.vue";

export default {
  name: 'MediaList',
  components: {
    Breadcrumb,
    NewFolder,
    NewFile
  },
  setup(props, contex) {
    const $q = useQuasar();
    const store = useStore();
    const back = ref(null)
    const columns = [
      {
        name: 'icon',
        required: true,
        label: 'Id',
        align: 'left',
      }, {
        name: 'filename',
        required: true,
        label: 'Nombre',
        align: 'left',
        field: row => row.filename,
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
    const media = ref([])
    const search = ref(null)
    const folder = ref(0)
    const parent = ref(0)
    const loading = ref(true)
    const success = ref(false)
    const initialPagination = ref({
      sortBy: 'desc',
      descending: false,
      page: 1,
      rowsPerPage: 10,
      rowsNumber: false
    })
    const order = ref({
      field: 'created_at',
      way: 'desc'
    })
    const getMedia = (folderfield = 0) => {
      return new Promise(async (resolve, reject) => {
        loading.value = true
        back.value = folder.value
        let params = {
          setting: {
            locale: 'es',
            roleId: store.state.auth.selectedRoleId
          },
          filter: {
            folder: folderfield,
            order: {field: "created_at", way: "desc"},
            search: search.value,
          },
          include: [],
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }

        api.get('/media/v1/files', {params: params}).then(response => {
          media.value = response.data.data
          initialPagination.value.rowsNumber = response.data.meta.page.total
          loading.value = false
          folder.value = folderfield
          parent.value = folderfield
          success.value = true

        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Roles',
            icon: 'report_problem'
          })
          loading.value = false
          reject(error)
        });
      })
    }
    const select = (image) => {
      contex.emit('image', image)
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
      getMedia(folder.value)
      // ...and turn of loading indicator
      loading.value = false

    }
    onMounted(() => {
      onRequest({
        pagination: initialPagination.value,
        filter: undefined
      })
    });

    function refreshMedia(upload) {
      getMedia(folder.value)
    }

    return {
      media,
      folder,
      parent,
      columns,
      loading,
      initialPagination,
      back,
      search,
      success,
      getMedia,
      select,
      refreshMedia,
      onRequest
    };
  },
};
</script>
<style lang="scss">
</style>
