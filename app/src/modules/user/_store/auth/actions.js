import {api} from 'boot/axios';
import {Notify} from 'quasar'
import helper from "src/plugins/helpers";
import cache from "src/plugins/cache";
import {Loading} from 'quasar';
import axios from "axios";

export const authTryAutoLogin = ({commit, dispatch, state}) => {
  return new Promise(async (resolve, reject) => {
    try {
      let sessionData = await cache.get('LocalDataUser')
      //Validate session data
      if (!sessionData || (helper.timestamp(sessionData.expiresIn) <= helper.timestamp())) {
        dispatch('authLogout')//Logout
        return resolve(false)//Close if there isn't token
      } else {
        dispatch('authUpdate',sessionData)
        return resolve(true)//Close if there isn't token
      }
      //await dispatch('authUpdate')//Update user data
      //resolve(state.authStatus)//Resolve
    } catch (error) {
      console.error('[Auth Login] ', error)
      reject(false)
    }
  })
}

export function login({commit, dispatch, state}, data) {
  return new Promise(async (resolve, reject) => {
    Loading.show()
    //Request
    api.post('/user/v1/auth/login', data).then(async response => {
      await dispatch('authSuccess', response.data)
      Loading.hide()
      resolve(true)
    }).catch(error => {
      commit('setAuthStatus', false)
      Notify.create({
        color: 'negative',
        position: 'top',
        message: 'Usuario o Contraseña invalido',
        icon: 'report_problem'
      })
      Loading.hide()
      reject(error)
    })
  });
}

export function authSuccess({commit, dispatch, state}, data = {}) {
  return new Promise(async (resolve, reject) => {
    try {
      //Validate if is impersonating
      const impersonatorData = await cache.get('impersonatorData')
      commit('setImpersonate', (impersonatorData ? true : false))//Set status impersonate
      if (data) {
        commit('authSuccess', data)//commit userdata in store
        await dispatch('setPermissions')//Set Permissions
        await dispatch('setSettings')//Set settings
        //Set default headers to axios
        axios.defaults.headers.common['Authorization'] = data.userToken
        if (!await cache.get('LocalDataUser')) {
          await cache.set('LocalDataUser', data)//Save session data in storage
        }
        return resolve(true)//Resolve
      } else {
        console.info('[authSuccess]::logout')
        dispatch('authLogout')//Logout
        return reject(false)
      }
    } catch (e) {
      console.error('[Auth Success] ', e)
      reject(e)
    }
  })
}

export function authUpdate({commit,dispatch, state}, data) {
  return new Promise(async (resolve, reject) => {
    if (data) {
      commit('authSuccess', data)//commit userdata in store
      await dispatch('setPermissions')//Set Permissions
      await dispatch('setSettings')//Set settings
      //Set default headers to axios
      api.defaults.headers.common['Authorization'] = data.userToken

      return resolve(true)//Resolve
    } else {
      console.info('[authSuccess]::logout')
      dispatch('authLogout')//Logout
      return reject(false)
    }
  });
}

//Logout
export function authLogout({commit, dispatch, state}) {
  return new Promise(async (resolve, reject) => {
    try {
      if (state.authStatus)//Request to Logout in backend
        await api.get('/user/v1/auth/logout').catch(() => {
        })
      await dispatch('reset')//Reset Store
      await cache.restore()//Reset cache
      resolve(true)
    } catch (e) {
      console.error('[AUTH LOGOUT] ', e)
      reject(e)
    }
  })
}

//Set permission of user
export function setPermissions({dispatch, commit, state}) {
  return new Promise(async (resolve, reject) => {
    try {
      //const roleId = state.selectedRoleId//Get role selected
      const userPermissions = state.user.permissions//Get user permissions
      //Save in store permissions
      commit('setPermissions', userPermissions)
      resolve(true)//Resolve
    } catch (error) {
      console.error('[Auth Set Permissions] ', error)
      reject(error)
    }
  })
}

//Set settings of user
export function setSettings({dispatch, commit, state}) {
  return new Promise(async (resolve, reject) => {
    try {
      const roleId = state.selectedRoleId//Get role selected
      let settings = {}//All settings
      //Save in store the settins
      commit('setSettings', Object.values(settings))
      resolve(true)//Resolve
    } catch (e) {
      console.error('Auth Get Settings] ', e)
      reject(e)
    }
  })
}


