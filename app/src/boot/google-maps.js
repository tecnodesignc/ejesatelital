import { boot } from 'quasar/wrappers'

import VueGoogleMaps from '@fawmi/vue-google-maps'




const googleMaps = new VueGoogleMaps({
  load: {
    key: process.env.GOOGLE_APY_KEY
  }
})

// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli/boot-files
export default boot(async ({ app, router } ) => {
  app.config.globalProperties.$googleMaps=googleMaps
})

export { googleMaps }
