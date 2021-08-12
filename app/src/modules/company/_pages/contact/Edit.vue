<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Contacto: {{ name }}</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper" v-if="success">
        <form class="needs-validation" novalidate>
          <div class="row">
            <div class="col-md-9 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Datos</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Nombre</p>
                      <q-input
                        outlined
                        v-model="first_name"
                        stack-label
                        dense
                        placeholder="Nombre"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Apellido</p>
                      <q-input
                        outlined
                        v-model="last_name"
                        stack-label
                        dense
                        placeholder="Apellido"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Correo Electronico</p>
                      <q-input
                        outlined
                        v-model="email"
                        stack-label
                        type="email"
                        dense
                        placeholder="Correo Electronico"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Dirección</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Celular</p>
                      <q-input
                        outlined
                        v-model="mobile"
                        stack-label
                        dense
                        placeholder="+57 312 5455444"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Telefono</p>
                      <q-input
                        outlined
                        v-model="phone"
                        stack-label
                        dense
                        placeholder="+57 312 5455444"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
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
                  <location :city="city" :country="country" :province="province" @location="emitLocation"/>
                </q-card-section>
              </q-card>
            </div>
            <div class="col-md-3 q-px-sm">
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Cuenta</p>
                      <q-select
                        outlined
                        dense
                        v-model="account_id"
                        emit-value
                        map-options
                        use-input
                        :options="account_list"
                        @filter="getAccount"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
          <q-footer>
            <q-card class="q-mb-sm">
              <q-card-section>
                <div class="q-pa-md q-gutter-sm">
                  <q-btn unelevated color="primary" @click="update" label="Actualizar"/>
                  <q-btn outline color="primary" :to="{name:'company.contact.index'}" label="Cancelar"/>
                </div>
              </q-card-section>
            </q-card>
          </q-footer>

        </form>
        <!-- end row -->
      </div>
    </div>

  </q-page>
</template>

<script>

import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia";
import Location from "src/modules/location/_components/Location";

export default {
  name: 'Edit Contact',
  components: {Location, Breadcrumb, SingleMedia},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Contactos",
        to: 'company.contact.index',
        active: true
      },
      {
        name: "Editar Cuenta",
        to: 'company.contact.edit',
        active: true
      }
    ]
    const id = ref(null)
    const first_name = ref(null)
    const last_name = ref(null)
    const identification = ref(null)
    const email = ref(null)
    const phone = ref(false)
    const mobile = ref(null)
    const street = ref(null)
    const city_id = ref(null)
    const province_id = ref(null)
    const country_id = ref(null)
    const account_id = ref(null)
    const options = ref([])
    const users = ref([])
    const account_list = ref([])
    const country = ref([])
    const province = ref([])
    const city = ref([])
    const success = ref(false)
    const router = useRouter()
    const route = useRoute()
    const update = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = id.value
          let params = {
            attributes: {
              id: id.value,
              first_name: first_name.value,
              last_name: last_name.value,
              identification: identification.value,
              email: email.value,
              mobile: mobile.value,
              account_id: account_id.value,
              phone: phone.value,
              street: street.value,
              city_id: city_id.value,
              province_id: province_id.value,
              country_id: country_id.value,
              options: options.value,
            }
          }
          api.put('/company/v1/contacts/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Contacto Editado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.account.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar el Contacto: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar el Contacto', error)
      }
    }
    const getAccounts = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
        if (val.length < 2) return abort()
        let params = {
          params: {
            take: 20,
            filter: {search: val}
          }
        }
        api.get('/company/v1/accounts', {params: params}).then(response => {
          update(() => {
            account_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          })
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Cuentas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          abort(error)
          reject(error)
        });
      });
    }
    const getContact = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = route.params.id
        let params = {
          include: 'country,province,city,account'
        }
        api.get('/company/v1/contacts/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          first_name.value = data.first_name
          last_name.value = data.last_name
          identification.value = data.identification
          email.value = data.email
          mobile.value = data.mobile
          account_id.value = data.account_id
          phone.value = data.phone
          street.value = data.street
          city_id.value = data.city_id
          province_id.value = data.province_id
          country_id.value = data.country_id
          options.value = data.options
          city.value = data.city
          province.value = data.province
          country.value = data.country
          account_list.value = array.select([data.account], {label: 'name', id: 'id'})
          success.value = true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de la Cuenta ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    onMounted(async () => {
      await getContact()
    });
    return {
      first_name,
      last_name,
      identification,
      email,
      mobile,
      account_id,
      phone,
      street,
      city_id,
      province_id,
      country_id,
      options,
      users,
      breadcrumb,
      success,
      account_list,
      country,
      province,
      city,
      update,
      getAccounts,
      emitLocation
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
