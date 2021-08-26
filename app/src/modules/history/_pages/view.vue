<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Historial de Usuario {{ full_name }}</h4>
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
                  <div class="text-h6">Usuario</div>
                </q-card-section>
                <q-separator/>
              </div>
              <div class="col-md-12">
                <q-card-section>
                  <div class="row">
                    <div class="col-12 col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">Nombre del usuario: {{ full_name }}</p>
                    </div>
                    <div class="col-12  col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">Correo: {{ email }} </p>
                    </div>
                    <div class="col-12  col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">Ultimo inicio de Sesiòn: {{ last_login }} </p>
                    </div>
                  </div>
                </q-card-section>
                <q-card-section>
                  <div class="row">
                    <div class="col-12 col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">Actividad: {{ title }}</p>
                    </div>
                    <div class="col-12  col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">valor: {{ message }} </p>
                    </div>
                    <div class="col-12  col-sm-6 q-pt-sm">
                      <p class="text-subtitle2">Fecha: {{ time_ago }} </p>
                    </div>
                  </div>
                </q-card-section>
              </div>
            </q-card>
            <q-card class="q-mb-sm">
              <q-card-section>
                <div class="text-h6">Mapa</div>
              </q-card-section>
              <q-separator/>
              <q-card-section v-if="success">
                <div class="row">
                  <div class="col-12 q-pt-sm">
                    <google-map :lat="lat" :lng="lng"/>
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
      </div>
    </div>

  </q-page>
</template>

<script>

import {ref} from 'vue';
import {useRoute, useRouter} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import {computed, onMounted} from 'vue'
import array from "src/plugins/array";
import helper from "src/plugins/helpers";
import QuestionList from "src/modules/polls/_components/question/QuestionList";
import GoogleMap from "src/modules/location/_components/GoogleMap";

export default {
  name: 'CreatePoll',
  components: {GoogleMap, Breadcrumb, QuestionList},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Historial",
        to: 'history.view',
        active: true
      }
    ]
    const id = ref(null)
    const title = ref(null)
    const message = ref(null)
    const time_ago = ref(null)
    const full_name = ref(null)
    const email = ref(null)
    const last_login = ref(null)
    const lat = ref(null)
    const lng = ref(null)
    const success = ref(false)
    const router = useRouter()
    const route = useRoute()
    const getHistory = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = route.params.id
        let params = {
          include: 'user'
        }
        api.get('/history/v1/histories/' + criteria, {params: params}).then(response => {
          let data = response.data.data;
          id.value = data.id
          title.value = data.title
          message.value = data.message
          time_ago.value = data.time_ago
          full_name.value = data.user.full_name
          email.value = data.user.email
          last_login.value = data.user.last_login
          lat.value = data.lat
          lng.value = data.lng
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
      await getHistory()
    });
    return {
      id,
      title,
      message,
      time_ago,
      full_name,
      email,
      last_login,
      lat,
      lng,
      success,
      getHistory,
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
