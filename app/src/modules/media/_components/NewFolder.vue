<template>

  <q-btn
    label="Nueva Carpeta"
    color="positive"
    icon="add"
    @click="newFolder"
  />

</template>

<script lang="ts">
//import {defineComponent} from 'vue';

import {ref} from "vue";
import { useQuasar } from 'quasar'
export default {
  name: 'NewFolder',
  setup() {
    const notification = ref(null)
    const $q = useQuasar()
    const folder=ref(null)
    function newFolder () {
      $q.dialog({
        title: 'Nueva Carpeta',
        message: 'Nombre de Carpeta',
        prompt: {
          model: folder,
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {

        return new Promise(async (resolve, reject) => {
          api.get('/media/v1/folders').then(response => {
            $q.loading.hide()
            permissions_list.value = response.data.permissions;
            let permissionsData = response.data.permissions
            let responsePermissions = {}
            //Format permissions with format to backend
            for (let moduleName in permissionsData) {
              for (let entityName in permissionsData[moduleName]) {
                for (let permissionName in permissionsData[moduleName][entityName]) {
                  //Get fullName of permission
                  let fullName = (entityName.toLowerCase() == 'dashboard') ?
                    (`${moduleName}.${permissionName}`).toLowerCase() :
                    (`${entityName}.${permissionName}`).toLowerCase()
                  let valuePermission = null
                  if (props.permissionsStatus.length) {
                    valuePermission = permissionsStatus.value[fullName]
                  }
                  //If allow inherit, only set item with different value 0(inherit)
                  if (valuePermission) {
                    responsePermissions[fullName] = valuePermission
                  } else {
                    responsePermissions[fullName] = props.isRole?-1:0
                  }
                }
              }
            }
            permissions.value = responsePermissions
            success.value = true
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error en la consulta de permisos',
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          })
        })

      }).onCancel(() => {

      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }
    return {};
  },
};
</script>
<style lang="scss">
.notification-bell {
  .q-btn-dropdown__arrow {
    display: none;
  }
}

.list-notification {
  .q-toolbar__title {
    font-weight: 500;
    line-height: 1.2;
    font-size: .875rem;
  }

  .view-more {
    font-size: 80%;
  }
}
</style>
