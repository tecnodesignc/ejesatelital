import {boot} from 'quasar/wrappers'

export default boot(async ({router, store, Vue}) => {
  router.beforeEach(async (to, from, next) => {
    let redirectTo = false

    //===== Validate authentication
    if (to.meta.requireAuth) {
      // Validate auth
      let isAuthenticated = process.env.CLIENT ? store.state.auth.authStatus : true

      //try login If isn't authenticated
      if (!isAuthenticated) isAuthenticated = await store.dispatch('auth/authTryAutoLogin')

      //Validate route to redirect
      if (isAuthenticated) {
        //Update data of user
        //store.dispatch('auth/authUpdate')
        //Validate permission of route
        if (to.meta && to.meta.permission) {
          if (!store.getters['auth/hasAccess'](to.meta.permission)) redirectTo = {name: 'app.home'}
        }

        // if page is login redirect to home
        if (!redirectTo && to.name == 'auth.login') redirectTo = {name: 'app.home'}
      } else {//Redirect if is not authenticated
        if (to.name != 'auth.login') redirectTo = {name: 'auth.login'}
      }
    }

    store.commit('app/setCurrentRoute', (redirectTo || to))//Update current route

    //====== Define redirec route, and set language
    let defaultLangue = process.env.LOCALE

    if (redirectTo && (redirectTo.name != to.name)) {
      redirectTo.query = {lang: defaultLangue}
      if(from.name != redirectTo.name) return router.push(redirectTo)
    } else if (!to.query.lang) {
      redirectTo = {path: to.path, query: {...to.query, lang: defaultLangue}}
      if((redirectTo.path == '/') || (from.path != redirectTo.path)) return router.push(redirectTo)
    } else {
      return next()
    }
  })
})
