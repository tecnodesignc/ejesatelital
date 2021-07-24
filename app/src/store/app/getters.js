import {Loading} from 'quasar'

export function refreshPage({state, commit, dispatch, getters}){
  return new Promise(async (resolve, reject) => {
    let currentRoute = state.currentRoute
    Loading.show()
    commit('loadPage', false)
    await cache.restore(cache.keys())//Reset cache
    await dispatch('auth/logout')//Update user data
    /*await dispatch('qsiteSettings/GET_SITE_SETTINGS', null, {root: true}).catch(error => {})//update settings sites*/
    /*dispatch('qsiteSettings/SET_SITE_COLORS', null, {root: true})//Load colors*/
    commit('loadPage', true)
    Loading.hide()
    resolve(true)
  })
}

//Reset values form Store
export function resetStore({state,commit, dispatch}){
  return new Promise((resolve, reject) => {
console.log(state)

      /*  let stores = config('app.resetStores') || []
        stores.forEach(name => commit(name, null, {root: true}))*/
    resolve(true)
  })
}
