import {api} from 'boot/axios';
import { Notify } from 'quasar'

export function login ({commit,state},data) {
  return new Promise(async (resolve, reject) => {
    //Request
    api.post('/user/v1/auth/login', data).then(response => {
      api.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.userToken
      commit('setUser', response.data)
      commit('setAuthStatus',true)
      resolve(true)
    }).catch(error => {
      commit('setAuthStatus',false)
      Notify.create({
        color: 'negative',
        position: 'top',
        message: 'Usuario o Contraseña invalido',
        icon: 'report_problem'
      })
      reject(false)//Failed response
    })
  });
}

export function authSuccess ({commit, dispatch, state}, data = false){
  return new Promise(async (resolve, reject) => {
    try {
      //Validate if is impersonating
      const impersonatorData = await cache.get.item('impersonatorData')
      commit('setImpersonate', (impersonatorData ? true : false))//Set status impersonate

      //Search sesion data in storage if not exist
      data = data || await cache.get.item('sessionData')

      if (data) {
        commit('AUTH_SUCCESS', data)//commit userdata in store
        await dispatch('SET_ROLE_DEPARTMENT')//Set role and department
        await dispatch('SET_PERMISSIONS')//Set Permissions
        await dispatch('SET_SETTINGS')//Set settings
        //Set default headers to axios
        axios.defaults.headers.common['Authorization'] = data.userToken

        await cache.set('sessionData', data)//Save session data in storage
        commit('SET_AUTHENTICATED')
        return resolve(true)//Resolve
      } else {
        console.info('[AUTH_SUCCESS]::LOGOUT')
        dispatch('AUTH_LOGOUT')//Logout
        return reject(false)
      }
    } catch (e) {
      console.error('[AUTH SUCCESS] ', e)
      reject(e)
    }
  })
}

export function authUpdate ({commit,state},data) {
  return new Promise(async (resolve, reject) => {
    //Request
    api.post('/user/v1/auth/login', data).then(response => {
      api.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.userToken
      commit('setUser', response.data)
      commit('setAuthStatus',true)
      resolve(true)
    }).catch(error => {
      commit('setAuthStatus',false)
      Notify.create({
        color: 'negative',
        position: 'top',
        message: 'Usuario o Contraseña invalido',
        icon: 'report_problem'
      })
      reject(false)//Failed response
    })
  });
}
