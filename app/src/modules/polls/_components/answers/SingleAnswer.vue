<template>
  <q-btn
    :label="answer?'':'Agregar Respuesta'"
    :color="answer?'positive':'primary'"
    :icon="answer?'edit':'add'"
    v-bind:auto-width="answer"
    :dense="answer?true:false"
    @click="openDialog"
  />
  <q-dialog v-model="dialogNF">
    <q-layout view="Lhh lpR fff" container class="bg-white">
      <q-header class="bg-primary">
        <q-toolbar>
          <q-toolbar-title> {{ answer ? `Respuesta: ${statement}` : 'Nueva Respuesta' }}</q-toolbar-title>
          <q-btn flat v-close-popup round dense icon="close"/>
        </q-toolbar>
      </q-header>
      <q-page-container>
        <q-page padding>
          <q-form class="needs-validation" ref="formAnswer">
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
                        <p class="text-subtitle2">Titulo</p>
                        <q-input
                          outlined
                          v-model="title"
                          stack-label
                          dense
                          placeholder="Titulo"
                          lazy-rules
                          :rules="[val => !!val || 'Campo requerido']"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Ayuda/Recomendaciones</p>
                        <q-input
                          outlined
                          v-model="caption"
                          stack-label
                          dense
                          placeholder="ayuda"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 q-pt-sm">
                        <p class="text-subtitle2">Tipo de Pregunta</p>
                        <q-select
                          outlined
                          dense
                          emit-value
                          map-options
                          v-model="type_id"
                          name="type_id"
                          use-input
                          :options="type_option"
                          @filter="(val, update)=>update(()=>{type_option = helper.filterOptions(val,type_list,type_id)})"
                        />
                      </div>
                    </div>
                  </q-card-section>
                </q-card>
                <q-card class="q-mb-sm">
                  <q-card-section>
                    <div class="text-h6">Imagen</div>
                  </q-card-section>
                  <q-separator/>
                  <q-card-section>

                  </q-card-section>
                </q-card>
              </div>
            </div>
            <q-footer>
              <q-card class="q-mb-sm">
                <div class="q-pa-md q-gutter-sm">
                  <q-btn v-if="answer" unelevated color="primary" @click="updateAnswer"
                         label="Actualizar" />
                  <q-btn v-else unelevated color="primary" @click="registerAnswer"
                         label="Guardar" />
                  <q-btn outline color="primary" v-close-popup label="Cancelar"/>
                </div>
              </q-card>
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
  name: 'SingleAnswer',
  props: {
    answer: {
      type: Number,
      default: 0
    },
    question: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const formAnswer = ref(null)
    const $q = useQuasar()
    const store = useStore();
    const id = ref(null)
    const title = ref(null)
    const caption = ref(null)
    const type_id = ref(null)
    const type_list = ref([])
    const type_option = ref([])
    const question_id = ref(null)
    const options = ref([])
    const success = ref(false)
    const dialogNF = ref(false)
    const registerAnswer = async () => {
      try {
        formAnswer.value.validate().then(async success => {
          if (success) {
            return new Promise(async (resolve, reject) => {
              let params = {
                attributes: {
                  title: title.value,
                  caption: caption.value,
                  type: type_id.value,
                  question_id: question_id.value,
                  options: options.value,
                }
              }
              console.warn(params)
              api.post('/polls/v1/answers', params).then(response => {
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'respuesta Guardada Corectamente',
                  icon: 'report_problem'
                })
                contex.emit('upload', true)
                dialogNF.value = false
              }).catch(error => {
                $q.notify({
                  color: 'negative',
                  position: 'bottom-right',
                  message: 'Error al guardar La Pregunta: ' + error.errors,
                  icon: 'report_problem'
                })
                $q.loading.hide()
                reject(error)
              });
            })
          }
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Pregunta', error)
      }
    }
    const updateAnswer = async () => {
      try {
        $q.loading.show()
        formAnswer.value.validate().then(async success => {
          if (success) {
            return new Promise(async (resolve, reject) => {
              let criteria = id.value
              let params = {
                attributes: {
                  id: id.value,
                  title: title.value,
                  caption: caption.value,
                  type: type_id.value,
                  question_id: question_id.value,
                  options: options.value,
                }
              }
              api.put('/polls/v1/answers/' + criteria, params).then(response => {
                $q.loading.hide()
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'Respuesta Editada Corectamente',
                  icon: 'report_problem'
                })
                contex.emit('upload', true)
                dialogNF.value = false
              }).catch(error => {
                $q.notify({
                  color: 'negative',
                  position: 'bottom-right',
                  message: 'Error al Actualizar La Respuesta: ' + error.errors,
                  icon: 'report_problem'
                })
                $q.loading.hide()
                reject(error)
              });
            })
          }
        })

      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Respuesta', error)
      }
    }
    const getAnswer = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = props.answer
        let params = {
          include: ''
        }
        api.get('/polls/v1/answers/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          title.value = data.title
          caption.value = data.caption?data.caption:null
          type_id.value = data.type_id
          question_id.value = data.question_id
          options.value = data.options
          success.value = true
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de la Pregunta ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const getType = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {}
          }
        }
        api.get('/polls/v1/question-types', {params: params}).then(response => {
          type_list.value = array.select(response.data.data, {label: 'name', id: 'id'})
          type_option.value = type_list.value
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Tipos de preguntas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      });
    }
    const openDialog = async () => {
      dialogNF.value = true
      if (props.answer) {
        await getAnswer()
      }
      await getType()
      question_id.value = props.question
    }
    onMounted(async () => {
    });
    return {
      id,
      title,
      caption,
      type_id,
      options,
      question_id,
      success,
      type_list,
      type_option,
      dialogNF,
      formAnswer,
      openDialog,
      registerAnswer,
      getType,
      updateAnswer,
      helper
    };
  },
};
</script>
<style lang="scss">
</style>
