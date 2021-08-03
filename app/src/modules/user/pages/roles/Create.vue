<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Roles</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <q-card>
              <q-card-section>
                <form class="needs-validation" novalidate>
                  <q-tabs
                    v-model="tab"
                    align="left"
                    class="bg-primary text-white shadow-2"
                    :breakpoint="0"
                  >
                    <q-tab name="pane-0" label="Datos"/>
                    <q-tab name="pane-1" label="Permisos"/>
                    <q-tab name="pane-2" label="Users"/>
                  </q-tabs>
                  <q-separator/>
                  <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="pane-0">
                      <div class="text-h6">Datos</div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">Nombre</p>
                          <q-input
                            outlined
                            v-model="name"
                            stack-label
                            dense
                            placeholder="Nombre del rol"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <p class="text-subtitle2">URL amigable</p>
                          <q-input
                            outlined
                            v-model="slug"
                            stack-label
                            dense
                            placeholder="URL amigable del rol"
                            lazy-rules
                            :rules="[val => !!val || 'Campo requerido']"
                          />
                        </div>
                      </div>
                    </q-tab-panel>
                    <q-tab-panel name="pane-1">
                      <div class="text-h6">Permisos</div>
                      <permissions @callPermissions="callPermissions" :is-role="true"/>
                    </q-tab-panel>
                    <q-tab-panel name="pane-2">
                      <div class="text-h6">Usuarios en este Rol</div>
                      <div class="row">
                        <div class="col-12 q-pt-sm">
                          <ul v-if="users.legth">
                            <li v-for="(user, i) in users" :key="i">
                              {{user.full_name}} - {{user.email}}
                            </li>
                          </ul>
                        </div>
                      </div>
                    </q-tab-panel>
                  </q-tab-panels>
                  <div class="q-pa-md q-gutter-sm">
                    <q-btn unelevated color="primary" @click="register" label="Guardar"/>
                    <q-btn outline color="primary" label="Cancelar"/>
                  </div>
                </form>
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

import {ref} from 'vue';
import {useRouter, useRoute} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import {computed, onMounted} from 'vue'
import Permissions from "src/modules/user/_components/admin/Permissions";
import array from "src/plugins/array";

export default {
  name: 'Crear Rol',
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
        name: "Roles",
        to: 'role.index',
        active: true
      },
      {
        name: "Crear rol",
        to: 'role.create',
        active: true
      }
    ]
    const name = ref(null)
    const slug = ref(null)
    const permissions = ref([])
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const tab = ref('pane-0')
    const register = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let params = {
            attributes: {
              name: name.value,
              slug: slug.value,
              permissions: permissions.value,
            }
          }

          api.post('/user/v1/roles', params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Usuario Guardado Corectamente',
              icon: 'report_problem'
            })
            router.push({name: 'role.index'})
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al guardar el Usuario: ' + error.errors,
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        console.error('Register Login', error)
      }
    }
    function callPermissions(getPermissions) {
      permissions.value = getPermissions

    }
    return {
      name,
      slug,
      permissions,
      breadcrumb,
      tab,
      callPermissions,
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
