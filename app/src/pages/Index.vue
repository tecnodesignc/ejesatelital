<template>
  <q-page class="row">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4 style="
    margin-right: 77px;
">Dashboard</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
    </div>
  </q-page>
</template>

<script>

import {defineComponent, ref} from 'vue';
import Breadcrumb from 'src/components/Breadcrumb.vue'



export default {
  name: 'PageIndex',
  components: {Breadcrumb},
  setup() {
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      }
    ]
    const imageData = (selectedImage) => {
      alert(selectedImage);
    }
    return {
      breadcrumb,
      imageData
    };
  }
};
</script>
<style lang="scss">

</style>
