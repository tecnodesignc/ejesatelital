<template>
  <div class="">
    <q-btn-dropdown flat unelevated  no-caps color="secondary">
      <template v-slot:label>
        <div class="row items-center">
          <q-avatar rounded size="28px">
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo.svg"/>
          </q-avatar>
          <div class="text-center q-ml-sm">
            Custom Content
          </div>
        </div>
      </template>
      <q-list bordered padding class="rounded-borders text-secondary">
        <q-item clickable v-close-popup v-ripple>
          <q-item-section avatar>
            <q-icon name="user" />
          </q-item-section>
          <q-item-section>Perfil</q-item-section>
        </q-item>
        <q-item clickable v-close-popup v-ripple>
          <q-item-section avatar>
            <q-icon name="settings" />
          </q-item-section>
          <q-item-section>Configuracion</q-item-section>
        </q-item>
        <q-separator spaced />
        <q-item clickable v-close-popup v-ripple>
          <q-item-section avatar>
            <q-icon name="power" />
          </q-item-section>
          <q-item-section>Cerrar Sesión</q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
  </div>
</template>

<script lang="ts">
//import {defineComponent} from 'vue';

export default {
  name: 'UserDropdown',
  setup() {
    return {};
  },
};
</script>
