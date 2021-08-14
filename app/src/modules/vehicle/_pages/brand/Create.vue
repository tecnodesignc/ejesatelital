<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Marca</h4>
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
                        v-model="name"
                        stack-label
                        dense
                        name="name"
                        placeholder="Nombre"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <q-toggle
                        name="is_activate"
                        v-model="status"
                        :true-value="true"
                        label="Activar Marca"
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
                  <q-btn outline color="primary" :to="{name:'vehicle.brand.index'}" label="Cancelar"/>
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

export default {
  name: 'Create Contact',
  components: { Breadcrumb},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Vehiculos",
        to: 'vehicle.brand.index',
        active: true
      },
      {
        name: "Crear Marca",
        to: 'vehicle.brand.create',
        active: true
      }
    ]
    const name = ref(null)
    const status = ref(false)
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              status: status.value,
            }
          }
          api.post('/vehicle/v1/brands', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Marca Guardada Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'vehicle.brand.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar La Marca: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar La Marca', error)
      }
    }
    onMounted(async () => {
    });
    return {
     name,
      status,
      breadcrumb,
      success,
      register,
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
