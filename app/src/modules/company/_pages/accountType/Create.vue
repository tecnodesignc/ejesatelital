<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Crear Tipo de Cuenta</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <q-form class="needs-validation">
          <div class="row">
            <div class="col-md-9 q-px-sm">
              <q-card>
                <q-card-section>
                  <div class="text-h6">Datos</div>
                </q-card-section>
                <q-separator />
                <q-card-section>
                  <div class="row">
                    <div class="col-12 q-pt-sm">
                      <p class="text-subtitle2">Nombre</p>
                      <q-input
                        outlined
                        v-model="name"
                        stack-label
                        dense
                        placeholder="Nombre"
                        lazy-rules
                        :rules="[val => !!val || 'Campo requerido']"
                      />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
            <div class="col-md-3 q-px-sm">
              <q-card>
                <q-card-section>
                  <div class="text-h6">Publicar</div>
                </q-card-section>
                <q-separator />
                <q-card-section>
                  <div class="q-pa-md q-gutter-sm">
                    <q-btn unelevated color="primary" @click="register" label="Guardar"/>
                    <q-btn outline color="primary" :to="{name:'company.account-type.index'}" label="Cancelar"/>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
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
import Permissions from "src/modules/user/_components/admin/Permissions";
import array from "src/plugins/array";

export default {
  name: 'Create Account Type',
  components: {Breadcrumb, Permissions},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Tipo de Cuentas",
        to: 'company.account-type.index',
        active: true
      },
      {
        name: "Crear Tipo de Cuenta",
        to: 'company.account-type.create',
        active: true
      }
    ]
    const name = ref(null)
    const success = ref(false)
    const router = useRouter()
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              options:[]
            }
          }
          api.post('/company/v1/account-types', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Tipo de Empresa Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'company.account-type.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Tipo de Empresa: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Error en guardar Tipo de Empresa', error)
      }
    }
    return {
      name,
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
