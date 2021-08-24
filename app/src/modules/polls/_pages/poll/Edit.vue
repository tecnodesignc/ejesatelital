<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Formularo: {{ title }}</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="page-content-wrapper" v-if="success">
        <q-form class="needs-validation" @submit.prevent="update">
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
                        <p class="text-subtitle2">Nombre de la Encuesta</p>
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
                              clearable
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
                          label="Activar Pregunta"
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
                      <question-list :poll="id"/>
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
                  <q-btn unelevated color="primary" type="submit" label="Actualizar"/>
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

import {onMounted, ref} from 'vue';
import {useRoute, useRouter} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import array from "src/plugins/array";
import helper from "src/plugins/helpers";
import QuestionList from "src/modules/polls/_components/question/QuestionList";

export default {
  name: 'EditPoll',
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
        name: "Editar Encuesta",
        to: 'polls.edit',
        active: true
      }
    ]
    const id = ref(null)
    const title = ref(null)
    const slug = ref(null)
    const description = ref(" ")
    const account_id = ref(null)
    const active = ref(false)
    const options = ref(null)
    const account_list = ref([])
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
              title: title.value,
              slug: slug.value,
              description: description.value,
              account_id: account_id.value,
              active: active.value,
              options: options.value,

            }
          }
          api.put('/polls/v1/polls/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Encuesta Editado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'polls.index'})
            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar La Encuesta: ' + error.errors,
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
    const getPoll = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = route.params.id
        let params = {
          include: 'account'
        }
        api.get('/polls/v1/polls/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          let type_vehicle_id = data.type_vehicle_id
          id.value = data.id
          title.value = data.title
          slug.value = data.slug
          description.value = data.description
          account_id.value = data.account_id
          active.value = data.status
          options.value = data.options
          if(data.account) account_list.value = array.select([data.account], {label: 'name', id: 'id'})
          success.value = true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta del Vehìculo ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    onMounted(async () => {
      await getPoll()
    });
    return {
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
      update,
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
