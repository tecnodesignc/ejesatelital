export function setAuthStatus (state,payload) {
  state.authStatus=payload
}
export function setUser(state,payload){
  state.user=payload
}
export function authSuccess (state,payload){
  state.user = payload.userData
  state.token = payload.userToken
  state.userId = payload.userData.id
  state.selectedRoleId=payload.userData.roles[0]
  state.authStatus = true
}

export function setRoleId(state,payload){
  state.selectedRoleId = payload
}

export function setImpersonate(state,payload = true){
  state.impersonating = payload
}

export function authLogout(state){
  state.token = null
  state.userId = null
  state.user = null
  state.authStatus = false
}

export function setPermissions(state, payload){
  state.permissions = payload
}

export function setSettings (state, payload){
  state.settings = payload
}

export function reset(state, payload){
  state.token = null
  state.userId = null
  state.user = null
  state.permissions = null
  state.settings = null
  state.selectedRoleId = false
  state.authStatus = false
  state.impersonating = false
}
