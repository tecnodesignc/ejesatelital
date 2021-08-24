import {api} from 'boot/axios';
import {Notify} from 'quasar'
import array from "src/plugins/array";
import cache from "src/plugins/cache";
import {useStore} from "vuex";

export const SetAccounts = ({commit, dispatch, state},reload=true) => {
  return new Promise(async (resolve, reject) => {
   try {
     const storeG = useStore();
     let accountsCache = await cache.get('AccountsList')
     if(!reload && accountsCache){
       let accountCache = await cache.get('Account')
       if (!accountCache) {
         await cache.set('Account', accountsCache[0])//Save session data in storage
       }
       commit('setAccount', await cache.get('Account'))//commit userdata in store
       resolve(true)
     }else {
       let params = {
         filter: {
           status: true,
           user: storeG.state.auth.userId
         },
         take: 100
       }
       api.get('/company/v1/accounts', {params: params}).then(async response => {
         commit('setAccounts', array.select(response.data.data, {label: 'name', id: 'id'}))
         await cache.set('AccountsList', response.data.data)
         let accountCache = await cache.get('Account')
         if (!accountCache) {
           await cache.set('Account', response.data.data[0])//Save session data in storage
         }
         commit('setAccount', await cache.get('Account'))//commit userdata in store
         resolve(true)
       }).catch(error => {
         Notify.create({
           color: 'negative',
           position: 'bottom-right',
           message: 'Error en la consulta de  Cuentas',
           icon: 'report_problem'
         })
         reject(error)
       });
     }
   }catch (e){
     reject(e)
   }

  })
}
export function AccountSelect({commit, dispatch, state}, data = {}) {
  return new Promise(async (resolve, reject) => {
    try {
      if (data) {
        commit('setAccount', data)//commit userdata in store
        await cache.set('Account', data)//Save session data in storage
        resolve(true)//Resolve
      }
    } catch (e) {
      console.error('[Account Select Error] ', e)
      reject(e)
    }
  })
}
