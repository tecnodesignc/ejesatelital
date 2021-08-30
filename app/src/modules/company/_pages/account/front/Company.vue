<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Compañia</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">
        <div class="row">
          <div class="col-12">
            <account/>
            <customer-account/>
            <driver-account/>
          </div>
        </div>
        <!-- end row -->
      </div>
    </div>

  </q-page>
</template>

<script>

import {ref} from 'vue';
import {useRouter, useRoute} from 'vue-router'
import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'
import {api} from "boot/axios";
import {onMounted} from 'vue'
import array from "src/plugins/array";
import Account from "src/modules/company/_components/widget/Account";
import CustomerAccount from "src/modules/company/_components/widget/CustomerAccount";
import DriverAccount from "src/modules/company/_components/widget/DriverAccount";

export default {
  name: 'CompanyView',
  components: {Account, Breadcrumb, CustomerAccount, DriverAccount},
  setup() {
    const $q = useQuasar();
    const breadcrumb = [
      {
        name: "Dashboard",
        to: 'app.home',
        active: false
      },
      {
        name: "Cuenta de Organizaciòn",
        to: 'profile.personal',
        active: true
      }
    ]
    onMounted(() => {
    });
    return {
      breadcrumb
    };
  }
};
</script>

<style lang="scss">
.permission-toggle {
  border: 1px solid $primary
}
</style>
