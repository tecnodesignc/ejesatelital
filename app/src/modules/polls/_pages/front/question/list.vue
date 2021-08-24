<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>{{title}}</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="page-content-wrapper">
        <div class="row">
          <div class="col-md-12 q-px-sm">
            <q-card class="row q-mb-sm">
              <div class="col-12">
                <q-card-section>
                  <div class="text-h6">{{ title }}</div>
                </q-card-section>
                <q-separator/>
              </div>

              <div class="col-md-11">
                <q-card-section>
                  <q-list padding>
                    <q-item v-for="(question, i) in questions" :key="i">
                      <q-item-section avatar>
                        <q-icon color="primary" name="help_outline" />
                      </q-item-section>
                      <q-item-section>
                        {{question.statement}}
                        <q-tooltip v-if="question.description" anchor="bottom middle" self="top middle" :offset="[10, 10]">
                          {{question.description}}
                        </q-tooltip>
                      </q-item-section>
                      <q-item-section top >
                        <render-answers :question="question" @result="emitAnswer"/>
                      </q-item-section>
                    </q-item>
                  </q-list>
                </q-card-section>
              </div>
              </q-card>
            </div>
          </div>
          <q-footer>
            <q-card class="q-mb-sm">
              <q-card-section>
                <div class="q-pa-md q-gutter-sm">
                  <q-btn unelevated color="primary" @click="" label="Enviar"/>
                  <q-btn outline color="primary" :to="{name:'polls.fill'}" label="Cancelar"/>
                </div>
              </q-card-section>
            </q-card>
          </q-footer>
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
import {useStore} from "vuex";
import RenderAnswers from "src/modules/polls/_components/answers/fields/RenderAnswers";

export default {
  name: 'EditPoll',
  components: {RenderAnswers, Breadcrumb},
  setup() {
    const $q = useQuasar();
    const store = useStore();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Formularios",
        to: 'polls.fill',
        active: true
      },
      {
        name: "Preguntas",
        to: 'polls.fill',
        active: true
      }
    ]
    const questions = ref([])
    const title=ref(null)
    const active=ref(null)
    const answers=ref([])
    const success = ref(false)
    const router = useRouter()
    const initialPagination = ref({
      page: 1,
      rowsPerPage:12,
      totalPage:1
    })
    const order = ref({
      field: 'created_at',
      way: 'desc'
    })
    const route = useRoute()
    const getPoll = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = route.params.id
        let params = {
          include: ''
        }
        api.get('/polls/v1/polls/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          if(!data.status || (data.account_id && data.account_id !== store.state.account.account_id)) router.push({name:'polls.fill'})
          title.value = data.title
          active.value = data.status
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
          router.push('polls.fill')
          $q.loading.hide()
          reject(error)
        });
      })
    }
    const getQuestions = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let params = {
          filter: {
            status: true,
            poll: route.params.id,
          },
          include: 'answers',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/polls/v1/questions', {params: params}).then(response => {
         questions.value = response.data.data;
          initialPagination.value.totalPage = response.data.meta.page.total
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
    function emitAnswer(result) {
      if(answers.value.length){
        let objIndex = answers.value.findIndex((obj => obj.answer_id == result.answer_id));
        if(objIndex===-1)answers.value.push(result)
        else
          answers.value[objIndex]=result
      }else{
        answers.value.push(result)
      }
    }

    onMounted(async () => {
      await store.dispatch('account/SetAccounts',false)
      await getPoll()
      await getQuestions()
    });
    return {
      breadcrumb,
      title,
      questions,
      initialPagination,
      answers,
      emitAnswer,
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
