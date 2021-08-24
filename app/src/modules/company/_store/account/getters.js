import array from "src/plugins/array";


export function getAccounts (state){
  let account_list = state.account_list
  return array.tree(account_list, {label: 'name', id: 'id'})
}

