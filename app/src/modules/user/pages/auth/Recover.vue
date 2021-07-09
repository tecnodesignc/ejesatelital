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
              Restablecer la contraseña!
          </h5></div>
            <div class="col-12 text-subtitle1"><p>
              Cambie la contraseña
          </p></div>
          </div>
        </q-card-section>
        <q-card-section>
          <q-banner class="bg-primary text-white">
            Ingrese su correo electrónico y se le enviarán las instrucciones.
          </q-banner>
          <q-form
            @submit="recover"
            @reset="onReset"
            class=" row q-col-gutter-md "
          >
            <div class="col-12">
              <q-input
                filled
                v-model="form.email"
                label="Correo electrónico *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>

            <div class="col-12">
              <q-btn label="Recuperar Contraseña" type="submit" class="full-width" color="primary"/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
      <div class="q-mt-lg text-center text-white">
        ¿Recordaste tu contraseña?  <q-btn label="Iniciar Sesión" color="white" flat/>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">


import {ref } from 'vue';

export default {
  name: 'Recover',
  components: {},
  setup() {
    const    email= ref(null)

    const  recover=()=>{
      return false
    }
    const  onReset=()=>{
      email.value=null
    }
    return {email,recover,onReset};
  }
};
</script>

<style>

</style>
