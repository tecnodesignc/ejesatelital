<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Editar Rol: {{name }}</h4>
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
                <q-form class="needs-validation">
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
                      <permissions @callPermissions="callPermissions" :is-role="true" :permissions-status="permissions"/>
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
                    <q-btn unelevated color="primary" @click="update" label="Guardar"/>
                    <q-btn :to="{name:'role.index'}" outline color="primary" label="Cancelar"/>
                  </div>
                </q-form>
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
  name: 'Editar Rol',
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
        name: "Editar Rol",
        to: 'role.create',
        active: true
      }
    ]
    const id = ref(null)
    const name = ref(null)
    const slug = ref(null)
    const permissions = ref([])
    const success = ref(false)
    //const store = useStore();
    const router = useRouter()
    const route = useRoute()
    const tab = ref('pane-0')
    const update = async () => {
      try {
        $q.loading.show()
        return new Promise(async (resolve, reject) => {
          let criteria =id.value
          let params = {
            attributes: {
              name: name.value,
              slug: slug.value,
              permissions: permissions.value,
            }
          }

          api.put('/user/v1/roles/' + criteria, params).then(response => {
            $q.loading.hide()
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Rol Editado Corectamente',
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
    const getRole = () => {
      $q.loading.show()
      let criteria = route.params.id
      return new Promise(async (resolve, reject) => {
        api.get('/user/v1/roles/' + criteria).then(response => {
          let roleData = response.data.data;
          id.value=roleData.id
          name.value=roleData.name
          slug.value = roleData.slug
          permissions.value = userData.permissions
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
      getRole()
    });
    return {
      id,
      name,
      slug,
      permissions,
      breadcrumb,
      tab,
      callPermissions,
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
