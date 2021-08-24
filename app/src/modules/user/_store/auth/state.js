export default function () {
  return {
    authStatus:false,
    user:[],
    impersonating : false,
    Token: null,
    userId: null,
    permissions: null,
    selectedRoleId : false,
    roles:[],
    role:null
  }
}
