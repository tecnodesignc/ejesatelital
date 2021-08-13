<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Tipo de Cuenta: {{name }}</h4>
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
                    <q-btn unelevated color="primary" @click="update" label="Guardar"/>
                    <q-btn outline :to="{name:'company.account-type.index'}" color="primary" label="Cancelar"/>
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
  name: 'Editar Account Type',
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
        name: "Tipo de Cuenta",
        to: 'company.account-type.index',
        active: true
      },
      {
        name: "Crear Tipo de Cuenta",
        to: 'company.account-type.create',
        active: true
      }
    ]
    const id = ref(null)
    const name = ref(null)
    const options= ref(null)
    const success = ref(false)
    const router = useRouter()
    const route = useRoute()
    const update = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria =id.value
          let params = {
            attributes: {
              id:id.value,
              name: name.value,
              options:[]
            }
          }
          api.put('/company/v1/account-types/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Tipo de Empresa Editado Corectamente',
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
    const getAccountType = () => {
      $q.loading.show()
      let criteria = route.params.id
      return new Promise(async (resolve, reject) => {
        api.get('/company/v1/account-types/' + criteria).then(response => {
          let data = response.data.data;
          id.value=data.id
          name.value=data.name
          options.value=data.options
          $q.loading.hide()
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta de Rol ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    onMounted(() => {
      getAccountType()
    });
    return {
      id,
      name,
      breadcrumb,
      success,
      update,
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
