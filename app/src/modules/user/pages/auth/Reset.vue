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
              Reiniciar la contraseña!
          </h5></div>
            <div class="col-12 text-subtitle1"><p>
              Cambie la contraseña
          </p></div>
          </div>
        </q-card-section>
        <q-card-section>
          <q-form
            @submit="reset"
            class=" row q-col-gutter-md "
          >
            <div class="col-12">
              <q-input
                filled
                type="password"
                v-model="form.password"
                label="Contraseña *"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Campo Obligatorio']"
              />
            </div>
            <div class="col-12">
              <q-input
                filled
                type="password"
                v-model="form.password_confirmation"
                label="Confrimar Contraseña *"
                lazy-rules
                :rules="[
                  val => val && val.length > 0 || 'Campo Obligatorio',
                   val => val =! form.password || 'La Contraseña no Coincide',
                 ]"
              />
            </div>

            <div class="col-12">
              <q-btn label="Cambiar Contraseña" type="submit" class="full-width" color="primary"/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script lang="ts">

import {ref } from 'vue';

export default {
  name: 'Recover',
  components: {},
  setup() {
    const email=ref(null)
    const password= ref(null)
    const  password_confirmation= ref(null)

    const  reset=()=>{
      return false
    }
    return {email, password,password_confirmation ,reset};
  }
};
</script>

<style>

</style>
