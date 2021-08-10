<template>
  <q-btn
    label="Nueva Carpeta"
    color="positive"
    icon="add"
    @click="dialogNF= true"
  />
  <q-dialog v-model="dialogNF">
    <q-card style="width: 600px">
      <form class="needs-validation" novalidate>
        <q-toolbar>
          <q-toolbar-title><span class="text-weight-bold">Nueva </span> Carpeta</q-toolbar-title>
          <q-btn flat round dense icon="close" v-close-popup/>
        </q-toolbar>

        <q-card-section>
          <div class="row">
            <div class="col-12 q-pt-sm">
              <p class="text-subtitle2">Nombre de Carpeta</p>
              <q-input
                outlined
                v-model="name"
                stack-label
                dense
                placeholder="Nombre de Carpeta"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
          </div>

          <div class="row" v-if="helper.hasAccess('company.account.index')">
            <div class="col-12 q-pt-sm">
              <p class="text-subtitle2">Asignar usuario</p>
              <q-select
                outlined
                dense
                v-model="user_id"
                multiple
                emit-value
                map-options
                :options="users_list"
              />
            </div>
          </div>

        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="cancelar" color="primary" v-close-popup/>
          <q-btn flat label="Crear Carpeta" color="primary" @click="newFolder"/>
        </q-card-actions>
      </form>
    </q-card>
  </q-dialog>
</template>

<script>

import {computed, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";

export default {
  name: 'NewFolder',

  props: {
    parent_id: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const $q = useQuasar()
    const store = useStore();
    const name = ref(null)
    const user_id = ref(null)
    const users_list = ref([])
    const dialogNF = ref(false)
    const newFolder = () => {
      return new Promise(async (resolve, reject) => {
        console.warn(props)
        let params = {
          attributes: {
            name: name.value,
            user_id: user_id.value?user_id.value:store.state.auth.userId,
            parent_id: props.parent_id,
          }
        }
        api.post('/media/v1/folders', params).then(response => {
          $q.loading.hide()
          $q.notify({
            color: 'positive',
            position: 'bottom-right',
            message: 'Carpeta Creada',
          })
          contex.emit('upload', true)
          dialogNF.value = false
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error al crear la carpeta: ' + error.errors,
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })

    }
    const getUser = (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        if (val.length < 2) return abort()
        let params = {
          params: {
            take: 20,
            filter: {search: val}
          }
        }
        api.get('/user/v1/users', params).then(response => {
          let options = array.select(response.data.data, {label: 'full_name', id: 'id'})
          users_list.value = options
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

    return {name, user_id, users_list, dialogNF, helper, getUser, newFolder};
  },
};
</script>
<style lang="scss">

</style>
