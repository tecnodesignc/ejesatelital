<template>
  <div class="row">
    <p class="col-12 text-right">
      <q-btn
        flat
        color="primary"
        @click="changeStateForAll(1)"
        label=" allow all">

      </q-btn>
      <q-btn
        flat
        color="primary"
        @click="changeStateForAll(0)"
        label="inherit all"
      />
      <q-btn
        flat
        color="primary"
        @click="changeStateForAll(-1)"
        label="deny all"
      />
    </p>
    <div class="col-12" v-if="success" v-for="(value, name) in permissions_list" :key="name">
      <h6>{{ name }}</h6>
      <div v-for="(permissionActions, subPermissionTitle) in value" :key="subPermissionTitle">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3">
                <span class="text-subtitle1 text-weight-bold">{{ subPermissionTitle }}</span>
              </div>
              <div class="col-md-9">
                <p style="margin-top: 10px;">
                  <q-btn
                    flat
                    color="primary"
                    @click="changeState(subPermissionTitle, permissionActions, 1)"
                    label="allow all"/>
                  <q-btn
                    v-if="!isRole"
                    flat
                    color="primary"
                    @click="changeState(subPermissionTitle, permissionActions, 0)"
                    label="inherit all"/>

                  <q-btn flat
                         color="primary"
                         @click="changeState(subPermissionTitle, permissionActions, -1)"
                         label="deny all"/>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 q-my-xs" v-for="(label, permissionAction) in permissionActions"
               :key="permissionAction">
            <div class="row items-center">
              <div class="col-md-3">
                <label class="text-right text-weight-bold"
                       style="display: block">{{ label }}</label>
              </div>
              <div class="col-md-9 q-pl-md">
                <q-btn-toggle
                  v-if="!isRole"
                  v-model="permissions[`${subPermissionTitle}.${permissionAction}`]"
                  no-caps
                  rounded
                  class="permission-toggle"
                  unelevated
                  @click="triggerEvent"
                  toggle-color="primary"
                  color="white"
                  text-color="primary"
                  :options="[
                                          {label: 'allow', value: 1},
                                          {label: 'inherit', value: 0},
                                          {label: 'deny', value: -1}
                                      ]"
                />
                <q-btn-toggle
                  v-else
                  v-model="permissions[`${subPermissionTitle}.${permissionAction}`]"
                  no-caps
                  rounded
                  @click="triggerEvent"
                  class="permission-toggle"
                  unelevated
                  toggle-color="primary"
                  color="white"
                  text-color="primary"
                  :options="[
                                          {label: 'allow', value: 1},
                                          {label: 'deny', value: -1}
                                      ]"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref} from "vue";
import {api} from "boot/axios";
import {useQuasar} from "quasar";

export default {
  name: "Permissions",
  props: {
    permissionsStatus: {type: Object, default: {}},
    isRole: {
      type: Boolean,
      default: false,
    }
  },
  setup(props, contex) {
    const $q = useQuasar();
    const permissions = ref([])
    const permissions_list = ref([])
    const success = ref(false)
    const getPermissionKey = async (subPermissionTitle, permissionAction) => {
      return `${subPermissionTitle}.${permissionAction}`;
    }
    const changeState = async (permissionPart, actions, state) => {

      for (let action in actions) {
        let module = `${permissionPart}.${action}`;
        permissions.value[module] = state
      }
      contex.emit('callPermissions', permissions.value)
    }
    const changeStateForAll = async (state) => {
      for (let moduleName in permissions.value) {
        permissions.value[moduleName] = state
      }
      contex.emit('callPermissions', permissions.value)
    }
    const triggerEvent = ()=>{
      contex.emit('callPermissions', permissions.value)
    }
    const getPermission = async () => {
      $q.loading.show()
      return new Promise(async (resolve, reject) => {
        api.get('/user/v1/permissions').then(response => {
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
    }
    onMounted(() => {
      getPermission()
    });
    return {
      permissions,
      permissions_list,
      success,
      changeStateForAll,
      changeState,
      triggerEvent
    }
  }

}
</script>

<style lang="sass">

</style>
