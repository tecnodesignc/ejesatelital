export function setAccount (state,payload) {
  state.account=payload
  state.account_id=payload.id
}

export function setAccounts (state,payload) {
  state.account_list=payload
}

export function reset(state, payload){
  state.account = null
  state.account_id = null
}
