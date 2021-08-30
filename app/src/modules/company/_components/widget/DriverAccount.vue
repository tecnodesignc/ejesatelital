<template>
  <q-card class="card-customer-account q-mb-sm">
    <q-item class="q-ma-lg q-pt-xl">
      <q-item-section>
        <q-item-label style="font-size: 20px">Conductores</q-item-label>
      </q-item-section>
      <q-item-section>
        <div class="text-right">
          <single-user @UserSave="emitUser"/>
        </div>
      </q-item-section>
    </q-item>
    <q-card-section>
      <q-table
        :rows="drivers"
        :columns="columns"
        row-key="id"
        :loading="loadign"
        v-model:pagination="initialPagination"
        binary-state-sort
      >
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td
              v-for="col in props.cols"
              :key="col.name"
              :props="props"
            >
              {{ col.value }}
            </q-td>
            <q-td auto-width class="q-gutter-sm text-center">
              <q-btn color="positive" icon="edit" dense
                     :to="{name:'user.edit',params:{id:props.row.id}}"/>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </q-card-section>

  </q-card>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import {useStore} from "vuex";
import array from "src/plugins/array";
import SingleUser from "src/modules/user/_components/user/SingleUser.vue"

export default {
  name: 'DriversAccount',
  components: {SingleUser},
  props: {},

  setup() {
    const $q = useQuasar()
    const store = useStore();
    const account = ref({})
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
        name: 'first_name',
        required: true,
        label: 'Nombres',
        align: 'left',
        field: row => row.first_name,
        format: val => `${val}`,
        sortable: true
      }, {
        name: 'last_name',
        required: true,
        label: 'Apellidos',
        align: 'left',
        field: row => row.last_name,
        format: val => `${val}`,
        sortable: true
      }, {
        name: 'last_name',
        required: true,
        label: 'Apellidos',
        align: 'left',
        field: row => row.last_name,
        format: val => `${val}`,
        sortable: true
      }, {
        name: 'email',
        required: true,
        label: 'Correo E.',
        align: 'left',
        field: row => row.email,
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
    const users_list=ref([])
    const drivers = ref([])
    const loading = true
    const success = ref(false)
    const edit = ref(false)
    const updateAccount = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = store.state.account.account_id
          account.value.users = users_list
          let params = {
            attributes: account.value
          }
          api.put('/company/v1/accounts/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Empresa Actualizada Corectamente',
              icon: 'report_problem'
            })
            edit.value = false
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar a Cuenta',
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        reject(error)
      }
    }
    const getAccount = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        await store.dispatch('account/SetAccounts', false)
        let criteria = store.state.account.account_id
        let params = {
          include: 'users'
        }
        api.get('/company/v1/accounts/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          users_list.value = data.users
          let user = []
          data.users ? data.users.forEach(item => {
            let roles = item.roles_id
            if (roles.includes(3)) {
              user.push(item)
            }
          }) : []
          drivers.value = user
          success.value = true
          $q.loading.hide()
          resolve(data)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta del Usuario ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const emitUser = async (userSave) => {
      drivers.value.push(userSave)
      users_list.value.concat(drivers)
     await updateAccount()

    }
    onMounted(async () => {
      await getAccount()
    });
    return {
      drivers,
      columns,
      success,
      emitUser,
      updateAccount,
    };
  },
};
</script>
<style lang="scss">
.card-profile {
  width: 100%;
  max-width: 100%;

  .text-subtitle {
    font-size: 16px;
  }

  .text-subtitle2 {
    font-size: 12px;
  }

  p {
    margin: 0;
  }
}
</style>
