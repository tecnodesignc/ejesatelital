import array from "src/plugins/array";

export function isAuthorized (state) {
  return state.authStatus
}

export function getPermissions(state) {
  return state.permissions;
};

export function getSettings(state){
  return state.settings;
};

export function fullName(state){
  let userData = state.userData
  return (userData && userData.fullName) ? userData.fullName : '';
};

export function userRolesSelect (state){
  let roles = state.roles
  return array.select(roles, {label: 'name', id: 'id'})
}

export function hasAccess(state, can) {
  let userPermissions = state.permissions
  if(!can || !userPermissions) return true
  //Validate permission
  if(userPermissions && Object.keys(userPermissions).length){
    let access = userPermissions[can]
    return access || false
  }else{
    return false
  }
}
