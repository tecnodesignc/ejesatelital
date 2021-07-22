import axios from "axios";

export function authUser ({commit,state},data) {

  return new Promise(async (resolve, reject) => {
    //Request
    axios.post('user/v1/loging', data).then(response => {
      resolve(response.data || response)//Successful response
    }).catch(error => {
      reject(error)//Failed response
    })
  });
}
