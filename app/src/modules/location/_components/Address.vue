<template>
 <div>

 </div>
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
