<template>
  <div class="container-fluid">
    <div class="page-content-wrapper">

      <div class="row">
        <div class="col-md-12">
          <q-card>
            <q-card-section>
              <new-folder/>
              <upload/>
<!--              <q-btn
                label="Nueva Carpeta"
                color="positive"
                icon="add"
              />
              <q-btn
                label="subir Archivo"
                color="primary"
              />-->
              <q-btn-group>
                <q-btn
                  color="warning"
                  label="mover"
                />
                <q-btn
                  color="negative"
                  label="Eliminar"
                />
              </q-btn-group>
            </q-card-section>

          </q-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">

import NewFolder from './NewFolder'
import Upload from './Upload'

import {ref} from "vue";

export default {
  name: 'NotificationDropdown',
  components:{
    NewFolder,
    Upload
  },
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
