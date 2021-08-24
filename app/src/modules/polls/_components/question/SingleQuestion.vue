<template>
  <q-btn
    :label="question?'':'Nueva pregunta'"
    :color="question?'positive':'primary'"
    :icon="question?'edit':'add'"
    v-bind:auto-width="question"
    :dense="question?true:false"
    @click="openDialog"
  />
  <q-dialog v-model="dialogNF">
    <q-layout view="Lhh lpR fff" container class="bg-white" style="width: 1920px; max-width: 80vw;">
      <q-header class="bg-primary">
        <q-toolbar>
          <q-toolbar-title> {{ question ? `Pregunta: ${statement}` : 'Nueva Pregunta' }}</q-toolbar-title>
          <q-btn flat v-close-popup round dense icon="close"/>
        </q-toolbar>
      </q-header>
      <q-page-container>
        <q-page padding>
          <q-form class="needs-validation" ref="formQuestion">
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
                    <answer-list :question="id?id:0" @saveQuestion="emmitQuestionSave"/>
                  </q-card-section>
                </q-card>
              </div>
            </div>
            <q-footer>
              <q-card class="q-mb-sm">
                <div class="q-pa-md q-gutter-sm">
                  <q-btn v-if="question" unelevated color="primary" @click="updateQuestion"
                         label="Actualizar" />
                  <q-btn v-else unelevated color="primary" @click="registerButton"
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
import AnswerList from "src/modules/polls/_components/answers/AnswerList";

export default {
  name: 'SingleQuestion',
  components: {AnswerList},
  props: {
    question: {
      type: Number,
      default: 0
    },
    poll: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const contactForm = ref(null)
    const $q = useQuasar()
    const store = useStore();
    const formQuestion=ref(null)
    const id = ref(null)
    const statement = ref(null)
    const description = ref(null)
    const poll_id = ref(null)
    const options = ref([])
    const success = ref(false)
    const dialogNF = ref(false)
    const registerQuestion = async () => {
      try {
        formQuestion.value.validate().then(async success => {
          if (success) {
            return new Promise(async (resolve, reject) => {
              let params = {
                attributes: {
                  statement: statement.value,
                  description: description.value,
                  poll_id: poll_id.value,
                  options: options.value,
                }
              }
              api.post('/polls/v1/questions', params).then(response => {
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'Pregunta Guardada Corectamente',
                  icon: 'report_problem'
                })
                let data= response.data.data
                id.value = data.id
                contex.emit('upload', true)
                dialogNF.value=false
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
    const updateQuestion = async () => {
      try {
        $q.loading.show()

        formQuestion.value.validate().then(async success => {
          if (success) {
            return new Promise(async (resolve, reject) => {
              let criteria = id.value
              let params = {
                attributes: {
                  id: id.value,
                  statement: statement.value,
                  description: description.value,
                  poll_id: poll_id.value,
                  options: options.value,
                }
              }
              api.put('/polls/v1/questions/' + criteria, params).then(response => {
                $q.loading.hide()
                $q.notify({
                  color: 'positive',
                  position: 'bottom-right',
                  message: 'Pregunta Editada Corectamente',
                  icon: 'report_problem'
                })
                contex.emit('upload', true)
                dialogNF.value=false
              }).catch(error => {
                $q.notify({
                  color: 'negative',
                  position: 'bottom-right',
                  message: 'Error al Actualizar La Pregunta: ' + error.errors,
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
    const getQuestion = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = props.question
        let params = {
          include: 'answers,poll'
        }
        api.get('/polls/v1/questions/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          statement.value = data.statement
          description.value = data.description
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
    const emmitQuestionSave = async (saveQuestion) => {
      if (saveQuestion)
       formQuestion.value.validate().then(async success => {
          if (success) {
            await registerQuestion()
          }
        })
    }
    const getAnswers = () => {
      return new Promise(async (resolve, reject) => {
        let params = {
          params: {
            take: 20,
            filter: {question:id.value}
          }
        }
        api.get('/polls/v1/answers', {params: params}).then(response => {
          answers_list.value = response.data.data
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la Consulta de Tipos de preguntas',
            icon: 'report_problem'
          })
          $q.loading.hide()
          abort(error)
          reject(error)
        });
      });
    }
    const openDialog = async () => {
      if (props.question) {
        await getQuestion()
      }
      poll_id.value = props.poll
      dialogNF.value=true
    }
    const registerButton = async () => {
      if (await registerQuestion()) dialogNF.value=false
    }
    onMounted(async () => {
    });
    return {
      id,
      statement,
      description,
      options,
      poll_id,
      success,
      dialogNF,
      formQuestion,
      openDialog,
      registerButton,
      updateQuestion,
      emmitQuestionSave,
      helper
    };
  },
};
</script>
<style lang="scss">
</style>
