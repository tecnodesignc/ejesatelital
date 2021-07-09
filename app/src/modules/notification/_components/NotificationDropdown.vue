<template>
  <div class="">
    <q-btn-dropdown dense content-style="box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%); border:none" flat icon="far fa-bell" class="notification-bell" no-caps color="secondary">
      <template v-slot:label>
        <q-badge color="red" floating>4</q-badge>
      </template>
      <q-list padding class="rounded-borders list-notification" style=" max-width: 350px">
        <q-toolbar class="row">
          <q-toolbar-title>Notificaciones</q-toolbar-title>
          <q-btn flat color="primary" class="view-more" label="Ver mas" />
        </q-toolbar>
        <q-scroll-area style="height: 230px; width: 320px;">
        <q-item clickable v-ripple>
          <q-item-section avatar top>
            <q-avatar size="md" icon="folder" color="primary" text-color="white" />
          </q-item-section>
          <q-item-section>
            <q-item-label overline lines="1">Photos</q-item-label>
            <q-item-label class="text-grey-6">Secondary line text. Lorem ipsum dolor sit amet, consectetur adipiscit elit.</q-item-label>
            <q-item-label caption><i class="far fa-clock"></i> February 22nd, 2019</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple>
          <q-item-section avatar top>
            <q-avatar size="md" icon="folder" color="primary" text-color="white" />
          </q-item-section>
          <q-item-section>
            <q-item-label overline lines="1">Photos</q-item-label>
            <q-item-label class="text-grey-6">Secondary line text. Lorem ipsum dolor sit amet, consectetur adipiscit elit.</q-item-label>
            <q-item-label caption> <i class="far fa-clock"></i> February 22nd, 2019</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple>
        <q-item-section avatar top>
          <q-avatar size="md" icon="folder" color="primary" text-color="white" />
        </q-item-section>
        <q-item-section>
          <q-item-label overline lines="1">Photos</q-item-label>
          <q-item-label class="text-grey-6">Secondary line text. Lorem ipsum dolor sit amet, consectetur adipiscit elit.</q-item-label>
          <q-item-label caption><i class="far fa-clock"></i> February 22nd, 2019</q-item-label>
        </q-item-section>
      </q-item>
        <q-item clickable v-ripple>
        <q-item-section avatar top>
          <q-avatar size="md" icon="folder" color="primary" text-color="white" />
        </q-item-section>
        <q-item-section>
          <q-item-label overline lines="1">Photos</q-item-label>
          <q-item-label>Secondary line text. Lorem ipsum dolor sit amet, consectetur adipiscit elit.</q-item-label>
          <q-item-label caption><i class="far fa-clock"></i> February 22nd, 2019</q-item-label>
        </q-item-section>
      </q-item>
        </q-scroll-area>
        <q-separator spaced />
        <q-btn flat icon="fas fa-arrow-circle-right" color="primary" class="full-width" label="Ver mas" />
      </q-list>
    </q-btn-dropdown>
  </div>
</template>

<script lang="ts">
//import {defineComponent} from 'vue';

import {ref} from "vue";

export default {
  name: 'NotificationDropdown',
  setup() {
    const notification = ref( null)
    return {};
  },
};
</script>
<style lang="scss">
.notification-bell{
  .q-btn-dropdown__arrow{
    display: none;
  }
}
.list-notification{
  .q-toolbar__title{
    font-weight: 500;
    line-height: 1.2;
    font-size: .875rem;
  }
  .view-more{
    font-size: 80%;
  }
}
</style>
