<template>
  <div class="text-primary">
    <q-btn-dropdown flat unelevated  no-caps color="secondary">
      <template v-slot:label>
        <div class="row items-center">
          <q-avatar rounded size="28px">
            <img :src="userData.main_image"/>
          </q-avatar>
          <div class="text-center q-ml-sm">
            {{ userData.full_name }}
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
          <q-item-section @click="logut">Cerrar Sesión</q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
  </div>
</template>

<script lang="ts">

import {useStore} from 'vuex'
import { computed} from 'vue'
export default {
  name: 'UserDropdown',
  setup() {
    const store = useStore();
    const userData=computed(() =>store.state.auth.user)
    const logut=async () =>{
      await store.dispatch('auth/authLogout')
    }
    return {logut,userData};
  },
};
</script>
