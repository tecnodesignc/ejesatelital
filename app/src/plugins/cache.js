import {LocalStorage} from 'quasar'

class localCache {
  get(index) {
    if (index) {
      return new Promise((resolve, reject) => {
        if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
        resolve (LocalStorage.getItem(index))
      })
    }
  }

  //Insert or update
  set(index, data) {
    if (index) {
      return new Promise(async (resolve, reject) => {
        try {
        if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
          await LocalStorage.set(index, data)
          resolve(true)
        } catch (e) {
          console.error('[LocalStorage Set Error] ', e)
          reject(e)
        }

      })
    }
  }

  //Remove an item from storage
  remove(index) {
    if (index) {
      return new Promise((resolve, reject) => {
        if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
        LocalStorage.remove(index)
        resolve(true)
      })
    }
  }

  //Return all keys fron storage
  keys() {
    return new Promise((resolve, reject) => {
      if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
      resolve(LocalStorage.getAll())
    })

  }

  //Remove all items from storage
  clear() {
    return new Promise((resolve, reject) => {
      if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
      LocalStorage.clear()
      resolve(true)

    })
  }

  //Restore cache, save any data
  restore(keys = []) {
    return new Promise((resolve, reject) => {
      try {
      if (!process.env.CLIENT) return resolve(undefined) //Validate if is side Server
      let keysData = {}
      //Funtion with loop async, to get value keys
      const getValuesKey = async () => {
        for (var key of keys) {
          keysData[key] = await this.get.item(key)
        }
      }
      //Call method to get keys
      getValuesKey().then(async () => {
        await this.clear()//Clear all cache
        //Restore cache
        for (var keyName in keysData) {
          let value = keysData[keyName]
          if ((value != null) && (value != undefined)) {
            this.set(keyName, keysData[keyName])
          }
        }
        resolve(true)//Resolve promise
      })
        resolve(true)//Resolve promise
      }catch (e) {
        reject(e)
      }

    })
  }

  //Return name to DB according to domain
  nameDB() {
    let hostname = window.location.host.split('.')
    let response = hostname

    //Set capitalize to all words
    hostname.forEach((word, index) => {
      if (index >= 1) {
        hostname[index] = word.charAt(0).toUpperCase() + word.slice(1)
      }
    })

    //Remove .com .org....
    if (hostname.length >= 2) response.pop()

    return `${response.join('')}DB`//Response
  }
}

const cache = new localCache()

export default cache

export {cache}
