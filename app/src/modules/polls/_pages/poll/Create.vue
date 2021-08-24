<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Foumulario</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <q-form class="needs-validation" ref="registerPoll" @submit.prevent="registerButton">
          <div class="row">
            <div class="col-md-12 q-px-sm">
              <q-card class="row q-mb-sm">
                <div class="col-12">
                  <q-card-section>
                    <div class="text-h6">Datos</div>
                  </q-card-section>
                  <q-separator/>
                </div>

                <div class="col-md-9">
                  <q-card-section>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Nombre del Formulario</p>
                        <q-input
                          outlined
                          v-model="title"
                          stack-label
                          dense
                          name="board"
                          placeholder="titulo"
                          lazy-rules
                          :rules="[val => !!val || 'Campo requerido']"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Informacion Adicional</p>
                        <q-editor
                          ref="descriptionRef"
                          :definitions="{bold: {label: 'Bold', icon: null, tip: 'My bold tooltip'}}"
                          v-model="description"
                          lazy-rules
                          :rules="[val => !!val || 'Campo requerido']"
                        />
                      </div>
                    </div>
                  </q-card-section>
                </div>
                <div class="col-md-3">
                  <q-card-section>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
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
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <q-toggle
                          name="is_activate"
                          v-model="active"
                          :true-value="true"
                          label="Activar cuestionario"
                        />
                      </div>
                    </div>
                  </q-card-section>
                </div>

              </q-card>
              <q-card class="q-mb-sm">
                <q-card-section>
                  <div class="text-h6">Preguntas</div>
                </q-card-section>
                <q-separator/>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <question-list :poll="id" @savePoll="emmitPollSave"/>
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
                  <q-btn outline color="primary" :to="{name:'polls.index'}" label="Cancelar"/>
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
import helper from "src/plugins/helpers";
import QuestionList from "src/modules/polls/_components/question/QuestionList";

export default {
  name: 'CreatePoll',
  components: {Breadcrumb, QuestionList},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Encuetas",
        to: 'polls.index',
        active: true
      },
      {
        name: "Crear Encuesta",
        to: 'polls.create',
        active: true
      }
    ]
    const registerPoll = ref(null)
    const id = ref(0)
    const title = ref(null)
    const slug = ref(null)
    const description = ref(" ")
    const account_id = ref(null)
    const active = ref(false)
    const options = ref(null)
    const account_list = ref([])
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              title: title.value,
              slug: slug.value,
              description: description.value,
              account_id: account_id.value,
              active: active.value,
              options: options.value,

            }
          }
          api.post('/polls/v1/polls', params).then(response => {
            $q.loading.hide()
            let data = response.data.data;
            id.value = data.id
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Encuesta Guardada Corectamente',
              icon: 'report_problem'
            })
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar La Encuesta: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Encuesta', error)
      }
    }
    const getAccounts = async (val, update, abort) => {
      return new Promise(async (resolve, reject) => {
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
    const emmitPollSave = async (savePoll) => {
      if (savePoll) {
        registerPoll.value.validate().then(async success => {
          if (success) {
            await register()
          }
        })

      }
    }
    const registerButton = async () => {
      if (await register()) router.push({name: 'polls.index'})
    }
    onMounted(async () => {
    });
    return {
      registerPoll,
      id,
      title,
      slug,
      description,
      account_id,
      active,
      options,
      breadcrumb,
      success,
      account_list,
      emmitPollSave,
      registerButton,
      getAccounts,
      helper
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
