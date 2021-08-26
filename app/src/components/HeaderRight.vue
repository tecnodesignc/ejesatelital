<template>
  <notification-dropdown/>
  <user-dropdown/>
</template>

<script>
//import { ref } from 'vue'

import UserDropdown from "src/modules/user/_components/UserDropdown.vue";
import NotificationDropdown from "src/modules/notification/_components/NotificationDropdown.vue";

export default {
  name: 'HeaderRight',
  components: {NotificationDropdown, UserDropdown},
  props: {}
}
</script>

<style lang="scss">
</style>
