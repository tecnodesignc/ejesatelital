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
              Bienvenido de nuevo!
            </h5></div>
            <div class="col-12 text-subtitle1"><p>
              Inicie sesión para continuar
            </p></div>
          </div>
        </q-card-section>
        <q-card-section>
          <q-form
            @submit="login"
            @reset="onReset"
            class=" row q-col-gutter-md "
          >
            <div class="col-12">
              <q-input
                filled
                v-model="email"
                label="Email *"
                hint="Correo Electronico"
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
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>


            <q-toggle v-model="recorder" label="Recordar Cuenta"/>

            <div class="col-12">
              <q-btn label="Log in" type="submit" class="full-width" color="primary"/>
              <q-btn label="¿Olvidaste tu contraseña?" icon="lock" type="reset" color="secondary" flat
                     class="full-width q-mt-lg text-center "/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
      <div class="q-mt-lg text-center text-white">
        ¿No tienes una cuenta?
        <q-btn label="Registrarse" color="white" flat/>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">

import {useStore} from 'vuex'

import {ref} from 'vue';
import { useRouter, useRoute } from 'vue-router'

export default {
  name: 'Login',
  components: {},
  setup() {
    console.log(process.env.CLIENT)
    const email = ref(null)
    const password = ref(null)
    const recorder = ref(true)
    const store = useStore();
    const router = useRouter()
    const route = useRoute()

    const login = () => {
      const params = {
        attributes: {
          email: email.value,
          password: password.value
        }
      }
      console.log()
      let login = store.dispatch('auth/login', params)
      if (login) {
        router.push({name:'app.home'})
      }

    }
    const onReset = () => {
      email.value = null,
        password.value = null
    }
    return {email, password, recorder, login, onReset};
  }
};
</script>

<style>

</style>
