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
          <q-toolbar-title> {{ question ? `Pregunta: ${statement}` : 'Nueva Pregunta' }}</q-toolbar-title>
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
                        <p class="text-subtitle2">Enunciado</p>
                        <q-input
                          outlined
                          v-model="statement"
                          stack-label
                          dense
                          placeholder="Enunciado"
                          lazy-rules
                          :rules="[val => !!val || 'Campo requerido']"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Información Adicional</p>
                        <q-editor
                          ref="descriptionRef"
                          :definitions="{bold: {label: 'Bold', icon: null, tip: 'My bold tooltip'}}"
                          v-model="description"
                        />
                        <q-input
                          outlined
                          v-model="description"
                          stack-label
                          dense
                          placeholder="Información Adicional"
                          lazy-rules
                          :rules="[val => !!val || 'Campo requerido']"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Tipo de Pregunta</p>
                        <q-select
                          outlined
                          dense
                          v-model="type_id"
                          emit-value
                          map-options
                          use-input
                          :options="types_list"
                          @filter="getTypeQuestion"
                        />
                      </div>
                    </div>
                  </q-card-section>
                </q-card>
                <q-card class="q-mb-sm">
                  <q-card-section>
                    <div class="text-h6">Respuestas</div>
                  </q-card-section>
                  <q-separator/>
                  <q-card-section>
                    Componentes de respuestas
                  </q-card-section>
                </q-card>
              </div>
            </div>
            <q-footer>
              <div class="q-pa-md q-gutter-sm">
                <q-btn unelevated color="primary" type="submit"
                       :label="account?'Actualizar':'Guardar'"/>
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
import SingleMedia from "src/modules/media/_components/SingleMedia";

export default {
  name: 'SingleQuestion',
  props: {
    poll: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const contactForm = ref(null)
    const $q = useQuasar()
    const store = useStore();
    const id = ref(null)
    const statement = ref(null)
    const description = ref(null)
    const type_id = ref(null)
    const options = ref([])
    const users = ref([])
    const account_list = ref([])
    const account_type_list = ref([])
    const users_list = ref([])
    const country = ref([])
    const province = ref([])
    const city = ref([])
    const success = ref(false)
    const dialogNF = ref(false)
    const registerAccount = async () => {
      try {
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              nit: nit.value,
              account_site: account_site.value,
              parent_id: parent_id.value ? parent_id.value : 0,
              active: active.value,
              account_type_id: account_type_id.value,
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
              message: 'Empresa Guardada Corectamente',
              icon: 'report_problem'
            })
            contex.emit('upload', true)
            dialogNF.value = false
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar La Empresa: ' + error.errors,
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
    const updateAccount = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria = id.value
          if (media) params.attributes.medias_single = media

          let params = {
            attributes: {
              id: id.value,
              name: name.value,
              nit: nit.value,
              account_site: account_site.value,
              parent_id: parent_id.value ? parent_id.value : 0,
              active: active.value,
              account_type_id: account_type_id.value,
              phone: phone.value,
              street: street.value,
              city_id: city_id.value,
              province_id: province_id.value,
              country_id: country_id.value,
              options: options.value,
            }
          }
          api.put('/company/v1/accounts/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Empresa Editada Corectamente',
              icon: 'report_problem'
            })
            contex.emit('upload', true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar La Cuenta: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Cuenta', error)
      }
    }
    const emitLocation = (location) => {
      country_id.value = location.country_id
      province_id.value = location.province_id
      city_id.value = location.city_id
    }
    const getAccount = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = props.contact
        let params = {
          include: 'country,province,city,account'
        }
        api.get('/company/v1/acoounts/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          name.value = data.name
          nit.value = data.nit
          account_site.value = data.account_site
          parent_id.value = data.parent_id
          active.value = data.status ? data.status : false
          account_type_id.value = data.account_type_id
          phone.value = data.phone
          street.value = data.street
          city_id.value = data.city_id
          province_id.value = data.province_id
          country_id.value = data.country_id
          options.value = data.options
          city.value = data.city
          province.value = data.province
          country.value = data.country
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
        await getAccount()
      }
      account_id.value = props.account.id
    }
    onMounted(async () => {
      await init()
    });
    return {
      id,
      name,
      nit,
      account_site,
      parent_id,
      active,
      account_type_id,
      phone,
      street,
      city_id,
      medias_single,
      province_id,
      country_id,
      options,
      users,
      success,
      account_list,
      account_type_list,
      users_list,
      country,
      province,
      city,
      dialogNF,
      contactForm,
      registerAccount,
      updateAccount,
      getAccounts,
      getAccountType,
      getUsers,
      selectedImage,
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
