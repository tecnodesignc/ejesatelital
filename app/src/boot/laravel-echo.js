import { boot } from 'quasar/wrappers'

import Echo from "laravel-echo";
import Pusher from "pusher-js"

const echo = new Echo({
  broadcaster: process.env.BROADCAST_DRIVER,
  key: process.env.PUSHER_APP_KEY,
  cluster: process.env.PUSHER_APP_CLUSTER,
  encrypted: process.env.PUSHER_APP_ENCRYPTED,
})

// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli/boot-files
export default boot(async ({ app, router} ) => {
  app.config.globalProperties.$echo = echo
})

export { echo }
