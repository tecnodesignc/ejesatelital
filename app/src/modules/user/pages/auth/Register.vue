<template>
  <q-page class="row items-center justify-evenly">
    <div class="col-11 col-sm-9 col-md-4 col-lg-3">
      <q-card class="login-form q-px-lg">
        <q-card-section>
          <div class="row text-center">
            <div class="col-12 q-mt-md">
              <img src="~assets/logo.png" alt="Logo" height="22">
            </div>
            <div class="col-12 text-primary"><h5 class="q-mb-sm q-mt-lg">
              Registro!
            </h5></div>
            <div class="col-12 text-subtitle1"><p>
              Registrate en nuestro sistema
            </p></div>
          </div>
        </q-card-section>
        <q-card-section>
          <q-form
            @submit="register"
            @reset="onReset"
            class=" row q-col-gutter-md "
            ref="formRegister"
          >
            <div class="col-12">
              <q-input
                filled
                v-model="first_name"
                label="Nombre *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>
            <div class="col-12">
              <q-input
                filled
                v-model="last_name"
                label="Apellido *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>
            <div class="col-12">
              <q-input
                filled
                v-model="email"
                label="Correo Electrònico *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>
            <div class="col-12">
              <q-input
                filled
                type="password"
                v-model="password"
                label="Contraseña *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio',
                val => val.length > 8 || 'Por favor use minimo 8 caracteres',]"
              />
            </div>
            <div class="col-12">
              <q-input
                filled
                type="password"
                v-model="password_confirmation"
                label="Confrimar Contraseña *"
                lazy-rules
                :rules="[
                  val => val && val.length > 0 || 'Campo Obligatorio',
                   val => val === password || 'La Contraseña no Coincide',
                 ]"
              />
            </div>

            <q-toggle v-model="terms" label="Al registrarse, acepta los Términos y condiciones"/>

            <div class="col-12 q-mb-lg">
              <q-btn label="Registarme" type="submit" class="full-width" color="primary"/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
      <div class="q-mt-lg text-center text-white">
        Ya tienes una cuenta?
        <q-btn label="Inicia Sesión" color="white" flat/>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">


import {ref} from 'vue';
import {useQuasar} from "quasar";

export default {
  name: 'Register',
  components: {},
  setup() {
    const $q = useQuasar()
    const first_name = ref(null)
    const last_name = ref(null)
    const email = ref(null)
    const password = ref(null)
    const password_confirmation = ref(null)

    const terms = ref(false)

    const register = () => {
      if (terms.value = false) {
        $q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'warning',
          message: 'Terminos no aceptados'
        })
      }
    }

    return {first_name, last_name, email, password, password_confirmation, terms, register};
  }
};
</script>

<style>

</style>
