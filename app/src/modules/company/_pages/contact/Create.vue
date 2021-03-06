<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Contacto</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <q-form class="needs-validation" @submit.prevent="register">
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
                        name="first_name"
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
                        name="last_name"
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
                        name="email"
                        type="email"
                        dense
                        placeholder="Correo Electronico"
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
                        name="mobile"
                        dense
                        placeholder="57 312 5455444"
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
                        name="phone"
                        placeholder="+57 1 5455444"
                        lazy-rules
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
                        name="address"
                        placeholder="Dirección"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <location @location="emitLocation"/>
                    </div>
                  </div>
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
                        name="account_id"
                        map-options
                        use-input
                        :options="account_list"
                        @filter="getAccounts"
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
                  <q-btn unelevated color="primary" type="submit" label="Guardar"/>
                  <q-btn outline color="primary" :to="{name:'company.contact.index'}" label="Cancelar"/>
                </div>
              </q-card-section>
            </q-card>
          </q-footer>

        </q-form>
        <!-- end row -->
      </div>
    </div>

  </q-page>
</template>

<script>

import {ref} from 'vue';
import {useRouter, useRoute} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import {computed, onMounted} from 'vue'
import array from "src/plugins/array";
import SingleMedia from "src/modules/media/_components/SingleMedia";
import Location from "src/modules/location/_components/Location";

export default {
  name: 'Create Contact',
  components: {SingleMedia, Breadcrumb, Location},
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
        name: "Crear Contacto",
        to: 'company.contact.create',
        active: true
      }
    ]
    const first_name = ref(null)
    const last_name = ref(null)
    const identification = ref(null)
    const email = ref(null)
    const phone = ref(null)
    const mobile = ref(null)
    const street = ref(null)
    const city_id = ref(null)
    const province_id = ref(null)
    const country_id = ref(null)
    const account_id = ref(null)
    const options = ref([])
    const users = ref([])
    const account_list = ref([])
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
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
          api.post('/company/v1/contacts', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Contacto Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.contact.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Contacto: ' + error.errors,
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
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    onMounted(async () => {
      await getAccounts()
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
      register,
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
