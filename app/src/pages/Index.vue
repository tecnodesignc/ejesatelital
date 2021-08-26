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
      <history-user :user_id="1"/>
    </div>
  </q-page>
</template>

<script>

import {defineComponent, ref} from 'vue';
import Breadcrumb from 'src/components/Breadcrumb.vue'
import HistoryUser from "src/modules/history/_components/widgets/HistoryUser";

export default {
  name: 'PageIndex',
  components: {HistoryUser, Breadcrumb},
  setup() {
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      }
    ]
    const data=ref(null)
    const imageData = (update) => {
      console.warn(update)
      data.value=update
    }
    return {
      breadcrumb,
      imageData,
      data,
    };
  }
};
</script>
<style lang="scss">

</style>
