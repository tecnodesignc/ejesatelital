<template>
  <q-btn
    :label="contact?'':'Nuevo Contacto'"
    :color="contact?'positive':'primary'"
    :icon="contact?'edit':'add'"
    v-bind:auto-width="contact"
    :dense="contact?true:false"
    @click="dialogNF= true"
  />
  <q-dialog v-model="dialogNF">
    <q-layout view="Lhh lpR fff" container class="bg-white">
      <q-header class="bg-primary">
        <q-toolbar>
          <q-toolbar-title> {{ contact ? `Contacto: ${first_name}` : 'Cuenvo Contacto' }}</q-toolbar-title>
          <q-btn flat v-close-popup round dense icon="close"/>
        </q-toolbar>
      </q-header>
      <q-page-container>
        <q-page padding>
          <q-form class="needs-validation" ref="contactForm" @submit.prevent="registerContact">
            <div class="row">
              <div class="col-md-12 q-px-sm">
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
                        <location :city="city" :country="country" :province="province" @location="emitLocation"/>
                      </div>
                    </div>
                  </q-card-section>
                </q-card>
              </div>
            </div>
            <q-footer bordered class="bg-white">
              <div class="q-pa-md q-gutter-sm">
                <q-btn unelevated color="primary" type="submit"
                       :label="contact?'Actualizar':'Guardar'"/>
                <q-btn outline color="primary" v-close-popup label="Cancelar"/>
              </div>
            </q-footer>
          </q-form>
        </q-page>
      </q-page-container>
    </q-layout>
  </q-dialog>
</template>

<script>

import {computed, onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";

export default {
  name: 'SingleContact',
  props: {
    contact: {
      type: Number,
      default: 0
    },
    account: {
      type: Number,
      required: true
    }
  },

  setup(props, contex) {
    const contactForm = ref(null)
    const $q = useQuasar()
    const store = useStore();
    const id = ref(null)
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
    const country = ref([])
    const province = ref([])
    const city = ref([])
    const options = ref([])
    const success = ref(false)
    const dialogNF = ref(false)
    const registerContact = async () => {
      try {
        return new Promise(async (resolve, reject) => {
          console.error(contactForm.value)
          contactForm.value.validate().then(success => {
            if (success) {

              let params = {
                attributes: {
                  first_name: first_name.value,
                  last_name: last_name.value,
                  identification: identification.value,
                  email: email.value,
                  mobile: mobile.value,
                  account_id: props.account,
                  phone: phone.value,
                  street: street.value,
                  city_id: city_id.value,
                  province_id: province_id.value,
                  country_id: country_id.value,
                  options: options.value,
                }
              }
              api.post('/company/v1/contacts', params).then(response => {
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'Contacto Guardado Corectamente',
                  icon: 'report_problem'
                })
                contex.emit('upload', true)
                dialogNF.value = false
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
            }

          })
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar el Contacto', error)
      }
    }
    const updateContact = async () => {
      console.error('dsafsfdasfas')
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
            contex.emit('upload', true)
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
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    const getContact = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = props.contact
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
    const init = async () => {
      if (props.contact) {
        await getContact()
      }
      account_id.value = props.account.id
    }
    onMounted(async () => {
      await init()
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
      country,
      province,
      city,
      success,
      dialogNF,
      contactForm,
      registerContact,
      updateContact,
      emitLocation
    };
  },
};
</script>
<style lang="scss">
.dropzone {
  min-height: 230px;
  border: 2px dashed #ced4da;
  background: #fff;
  border-radius: 6px;

  .dz-message {
    font-size: 24px;
    width: 100%;
  }
}
</style>
