<template>
  <q-card class="card-profile" >
    <q-item class="q-ma-lg q-pt-xl">
      <q-item-section avatar>
        <single-media :dense="true" zone="logo" entity="Modules\Company\Entities\Account" :entity_id="id"
                      @selectedImage="selectedImage" />
      </q-item-section>
      <q-item-section>
        <q-item-label style="font-size: 20px">{{ name }}</q-item-label>
        <q-item-label caption style="font-size: 14px">
          NIT: {{ nit }}
        </q-item-label>
      </q-item-section>
      <q-item-section>
        <div class="text-right">
          <q-btn color="positive"
                 @click="edit=!edit"
                 v-if="!edit"
                 class="q-mt-md"
                 label="Editar"
          />
        </div>
      </q-item-section>
    </q-item>

    <q-card-section>
      <div v-if="edit">
        <q-form class="needs-validation" ref="formAccount" @submit.prevent="updateAccount">
          <div class="row">
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Nombre</p>
              <q-input
                outlined
                v-model="name"
                stack-label
                dense
                placeholder="Nombre"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">NIT:</p>
              <q-input
                outlined
                v-model="nit"
                stack-label
                dense
                placeholder="Número de Identificación Tributaria"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <div class="col-12 q-pt-sm">
                <p class="text-subtitle2">Sitio Web</p>
                <q-input
                  outlined
                  v-model="account_site"
                  stack-label
                  dense
                  placeholder="account_site"
                  lazy-rules
                />
              </div>
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Cuenta Padre</p>
              <q-select
                outlined
                dense
                v-model="parent_id"
                emit-value
                map-options
                use-input
                :options="account_list"
                @filter="getAccounts"
                placeholder="Cuenta principal"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Tipo de Cuenta</p>
              <q-select
                outlined
                dense
                v-model="account_type_id"
                name="account_type"
                emit-value
                map-options
                :options="account_type_list"
                placeholder="Tipo de Cuenta"
              />
            </div>
            <div class="col-12 q-mb-lg q-px-lg">
              <q-separator/>
              <q-card-section>
                <div class="text-h6">Dirección</div>
              </q-card-section>
              <q-separator/>
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <div class="col-12 q-mb-lg q-px-lg">
                <p class="text-subtitle2">Telefono</p>
                <q-input
                  outlined
                  v-model="phone"
                  stack-label
                  name="phone"
                  dense
                  placeholder="+57 312 545 5444"
                  mask="+## ### ### ####"
                  lazy-rules
                  :rules="[val => !!val || 'Campo requerido']"
                />
              </div>
              <div class="col-12 q-mb-lg q-px-lg">
                <p class="text-subtitle2">Dirección</p>
                <q-input
                  outlined
                  v-model="street"
                  stack-label
                  dense
                  placeholder="Dirección"
                  lazy-rules
                  :rules="[val => !!val || 'Campo requerido']"
                />
              </div>
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <location :city="city" :country="country" :province="province"
                        @location="emitLocation"/>
            </div>
            <div class="col-12 q-gutter-md q-px-lg">
              <q-btn color="positive"
                     unelevated
                     type="submit"
                     class="q-mt-md"
                     label="Guardar"
              />
              <q-btn color="primary"
                     outline
                     @click="edit=!edit"
                     class="q-mt-md"
                     label="Cancelar"
              />
            </div>
          </div>
        </q-form>
      </div>
      <div class="row" v-else>

        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Sitio Web</p>
          <p class="text-subtitle">{{ account_site }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg" v-if="parent_id">
          <p class="text-subtitle2">Cuenta padre</p>
          <p class="text-subtitle">{{ parent.name }}</p>
        </div>
        <div class="col-12 q-mb-lg q-px-lg">
          <q-separator/>
          <q-card-section>
            <div class="text-h6">Dirección</div>
          </q-card-section>
          <q-separator/>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Telefono</p>
          <p class="text-subtitle">{{ phone }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Dirección</p>
          <p class="text-subtitle">{{ street }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Ciudad</p>
          <p class="text-subtitle">{{ city.name }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Provincia</p>
          <p class="text-subtitle">{{ province.name }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Pais</p>
          <p class="text-subtitle">{{ country.name }}</p>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import {useStore} from "vuex";
import Location from "src/modules/location/_components/Location";
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia"

export default {
  name: 'Account',
  components: {Location, SingleMedia},
  props: {},

  setup() {
    const $q = useQuasar()
    const store = useStore();
    const formAccount = ref(null)
    const id = ref(null)
    const name = ref(null)
    const nit = ref(null)
    const account_site = ref(null)
    const parent_id = ref(null)
    const parent = ref({})
    const active = ref(false)
    const account_type_id = ref(null)
    const account_type = ref(null)
    const medias_single = ref(null)
    const phone = ref(null)
    const street = ref(null)
    const city_id = ref(null)
    const province_id = ref(null)
    const country_id = ref(null)
    const options = ref([])
    const users = ref([])
    const drivers = ref([])
    const account_list = ref([])
    const account_type_list = ref([])
    const users_list = ref([])
    const drivers_list = ref([])
    const country = ref([])
    const province = ref([])
    const city = ref([])
    const image = ref(null)
    const success = ref(false)
    const edit = ref(false)
    const updateAccount = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = store.state.account.account_id
          let media = medias_single.value
          let params = {
            attributes: {
              id: id.value,
              name: name.value,
              nit: nit.value,
              account_site: account_site.value,
              parent_id: parent_id.value ? parent_id.value : 0,
              active: active.value,
              account_type_id: account_type_id.value,
              users: users.value,
              phone: phone.value,
              street: street.value,
              city_id: city_id.value,
              province_id: province_id.value,
              country_id: country_id.value,
              options: options.value,
            }
          }

          if (media) params.attributes.medias_single = media
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
          include: 'users,contacts,country,province,city,parent,type'
        }
        api.get('/company/v1/accounts/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          name.value = data.name
          nit.value = data.nit
          account_site.value = data.account_site
          if (data.parent_id) {
            parent_id.value = data.parent_id
            parent.value = data.parent.name
          }
          active.value = data.status ? data.status : false
          account_type_id.value = data.account_type_id
          account_type.value = data.account_type
          phone.value = data.phone
          street.value = data.street
          city_id.value = data.city_id
          province_id.value = data.province_id
          country_id.value = data.country_id
          options.value = data.options
          city.value = data.city
          province.value = data.province
          country.value = data.country
          if(data.logo)
          image.value=data.logo.path
          users.value = data.users ? data.users.map(item => {
            let roles = item.roles_id
            if (roles.find(element => element = 3)) {
              return item.id
            }
          }) : []
          users_list.value = array.select(data.users, {label: 'full_name', id: 'id'})
          drivers.value = data.users ? data.users.map(item => {
            let roles = item.roles_id
            if (roles.find(element => element = 3)) {
              return item.id
            }
          }) : []
          drivers_list.value = array.select(data.users, {label: 'full_name', id: 'id'})
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
    const getAccountType = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {}
          }
        }
        api.get('/company/v1/account-types', params).then(response => {
          account_type_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Tipos Cuentas',
            icon: 'report_problem'
          })
          console.error(error)
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const getUsers = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          take: 20,
          filter: {search: val, roleSlug: 'customer'}
        }
        api.get('/user/v1/users', {params: params}).then(response => {
          update(() => {
            users_list.value = array.select(response.data.data, {label: 'full_name', id: 'id'})
          })
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Usuarios',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const getDriver = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        let params = {
          take: 20,
          filter: {search: val, roleSlug: 'conductor'}
        }
        api.get('/user/v1/users', {params: params}).then(response => {
          update(() => {
            drivers_list.value = array.select(response.data.data, {label: 'full_name', id: 'id'})
          })
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Usuarios',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const selectedImage = (selectedImage) => {
      medias_single.value = selectedImage
    }
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    onMounted(async () => {
      await getAccountType()
      await getAccount()
    });
    return {
      id,
      name,
      nit,
      account_site,
      parent_id,
      parent,
      active,
      account_type_id,
      account_type,
      phone,
      street,
      city_id,
      medias_single,
      province_id,
      country_id,
      options,
      users,
      drivers,
      drivers_list,
      account_list,
      account_type_list,
      users_list,
      country,
      province,
      city,
      success,
      edit,
      image,
      formAccount,
      getAccountType,
      getUsers,
      getDriver,
      selectedImage,
      emitLocation,
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
