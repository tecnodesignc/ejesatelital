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
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Morvin</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>

import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'PageIndex',
  components: {},
  setup() {
    return {

    };
  }
});
</script>
<style lang="scss">
.page-title-box{
  background: url(~assets/title-img.png);
  background-position: center;
  background-color: $primary;
  margin: 0 -24px 23px -24px;
  padding: 24px 24px 92px 24px;
  background-size: cover;
}
</style>
