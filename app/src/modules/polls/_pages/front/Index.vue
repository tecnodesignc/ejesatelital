<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Formularios Activos</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="page-content-wrapper">
        <div class="row">
          <div class="col-md-10">
            <q-card>
              <q-card-section>
                <q-list padding>
                  <q-item clickable :to="{name:'polls.questions.fill',params: {id:poll.id}}" v-ripple v-for="(poll, i) in polls" :key="i">
                    <q-item-section avatar>
                      <q-icon color="primary" name="check_circle_outline" />
                    </q-item-section>
                    <q-item-section>
                      {{poll.title}}
                    </q-item-section>
                  </q-item>
                </q-list>
                <div class="q-pa-lg flex flex-center">
                  <q-pagination
                    v-model="initialPagination.page"
                    :max="initialPagination.page"
                    @update:model-value="getPolls"
                  />
                </div>
              </q-card-section>
            </q-card>
          </div>
      </div>
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

export default {
  name: 'EditPoll',
  components: {Breadcrumb},
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
      }
    ]
    const polls = ref([])
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
    const getPolls = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
     await store.dispatch('account/SetAccounts',false)
        let params = {
          filter: {
            status: true,
            account: store.state.account.account_id,
          },
          include: 'account',
          page: initialPagination.value.page,
          take: initialPagination.value.rowsPerPage
        }
        api.get('/polls/v1/polls', {params: params}).then(response => {
         polls.value = response.data.data;
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
    onMounted(async () => {
      await getPolls()
    });
    return {
      breadcrumb,
      polls,
      getPolls,
      initialPagination,
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
