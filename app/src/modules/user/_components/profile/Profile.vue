<template>
  <q-card class="card-profile">
    <q-item class="q-ma-lg q-pt-xl">
      <q-item-section avatar>
        <q-avatar size="60px">
          <img :src="image" :alt="full_name">
        </q-avatar>
      </q-item-section>
      <q-item-section>
        <q-item-label style="font-size: 20px">{{ full_name }}</q-item-label>
        <q-item-label caption style="font-size: 14px">
          {{ email }}
        </q-item-label>
      </q-item-section>
      <q-item-section>
        <div class="text-right">
          <q-btn color="positive"
                 @click="edit=!edit"
                 v-if="!edit"
                 class="q-mt-md"
                 label="Editar"
          />
        </div>
      </q-item-section>
    </q-item>
    <q-card-section>
      <div v-if="edit">
        <q-form class="needs-validation" @submit.prevent="updateProfile">
          <div class="row">
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Nombre*</p>
              <q-input
                outlined
                v-model="first_name"
                stack-label
                dense
                placeholder="Nombres"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Appelido*</p>
              <q-input
                outlined
                v-model="last_name"
                stack-label
                dense
                placeholder="Apellido"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Identificacion*</p>
              <q-input
                outlined
                v-model="identification"
                stack-label
                dense
                placeholder="1100000000"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Correo Electronico*</p>
              <q-input
                outlined
                v-model="email"
                stack-label
                dense
                type="email"
                placeholder="Correo Electronico"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
              <p class="text-subtitle2">Telefono</p>
              <q-input
                outlined
                v-model="phone"
                stack-label
                dense
                placeholder="+57 321 456 8454"
                mask="+## ### ### ####"
                lazy-rules
                :rules="[val => !!val || 'Campo requerido']"
              />
            </div>
            <div class="col-12 q-gutter-md q-px-lg">
              <q-btn color="positive"
                     unelevated
                     type="submit"
                     class="q-mt-md"
                     label="Guardar"
              />
              <q-btn color="primary"
                     outline
                     @click="edit=!edit"
                     class="q-mt-md"
                     label="Cancelar"
              />
            </div>
          </div>
        </q-form>
      </div>
      <div class="row" v-else>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Nombre Completo</p>
          <p class="text-subtitle">{{ full_name }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Email</p>
          <p class="text-subtitle">{{ email }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Identificacion</p>
          <p class="text-subtitle">{{ identification }}</p>
        </div>
        <div class="col-12 col-sm-6 q-mb-lg q-px-lg">
          <p class="text-subtitle2">Telefono</p>
          <p class="text-subtitle">{{ phone }}</p>
        </div>
      </div>

    </q-card-section>
  </q-card>
</template>

<script>

import {onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import {useStore} from "vuex";

export default {
  name: 'Profile',
  components: {},
  props: {},

  setup() {
    const $q = useQuasar()
    const store = useStore();
    const formProfile = ref(null)
    const id = ref(null)
    const first_name = ref(null)
    const last_name = ref(null)
    const full_name = ref(null)
    const identification = ref(null)
    const image = ref(null)
    const email = ref(null)
    const country = ref(null)
    const phone = ref(null)
    const success = ref(false)
    const edit = ref(false)
    const updateProfile = async () => {
      try {
        return new Promise(async (resolve, reject) => {
          let criteria = store.state.auth.userId
          let params = {
            attributes: {
              id: id.value,
              first_name: first_name.value,
              last_name: last_name.value,
              email: email.value,
              fields: {
                identification: identification.value,
                phone: phone.value
              },
            }
          }
          api.put('/user/v1/users/' + criteria, params).then(async () => {
            $q.notify({
              color: 'positive',
              position: 'bottom-right',
              message: 'Perfil Actualizado Corectamente',
              icon: 'report_problem'
            })

            let user = store.state.auth.user
            let data = Object.assign({}, user, await getUser())

            console.warn(data)

          await store.dispatch('auth/profileUpdate',data)
            edit.value = false

            resolve(true)
          }).catch(error => {
            $q.notify({
              color: 'negative',
              position: 'bottom-right',
              message: 'Error al Actualizar El Perfil',
              icon: 'report_problem'
            })
            $q.loading.hide()
            reject(error)
          });
        })
      } catch (error) {
        $q.loading.hide()
        reject(error)
      }
    }
    const getUser = () => {
      return new Promise(async (resolve, reject) => {
        $q.loading.show()
        let criteria = store.state.auth.userId
        api.get('/user/v1/users/' + criteria).then(response => {
          let data = response.data.data;
          id.value = data.id
          first_name.value = data.first_name
          last_name.value = data.last_name
          full_name.value = data.full_name
          email.value = data.email
          image.value = data.main_image
          identification.value = data.fields.identification
          country.value = data.fields.country ? data.fields.country : null
          phone.value = data.fields.phone ? data.fields.phone : null
          $q.loading.hide()
          resolve(data)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error en la consulta del Usuario ',
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })
    }
    onMounted(async () => {
      await getUser()
    });
    return {
      id,
      image,
      full_name,
      first_name,
      last_name,
      email,
      identification,
      country,
      phone,
      formProfile,
      edit,
      success,
      updateProfile,
    };
  },
};
</script>
<style lang="scss">
.card-profile {
  width: 100%;
  max-width: 100%;

  .text-subtitle {
    font-size: 16px;
  }

  .text-subtitle2 {
    font-size: 12px;
  }

  p {
    margin: 0;
  }
}
</style>
