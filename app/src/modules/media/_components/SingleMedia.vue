<template>
  <q-card class="my-card"  v-if="!imagePath">
  <q-card-section>
    <q-btn
      label="Selecionar Imagen"
      color="positive"
      icon="insert_photo"
      @click="dialogNF= true"
    />
  </q-card-section>
  </q-card>
  <q-card class="my-card text-center q-py-lg" v-else >
    <q-img :src="imagePath.path" v-if="imagePath.isImage" style="max-width: 250px"/>
    <q-icon name="description" v-else class="text-teal" style="font-size: 8.4em;"/>

    <q-card-actions>
      <q-btn
        label="remover Imagen"
        color="negative"
        icon="close"
        @click="removeImage"
      />
    </q-card-actions>
  </q-card>
  <q-dialog v-model="dialogNF">

    <q-card style="width: 1200px; height: auto">
      <q-toolbar>
        <q-toolbar-title><span class="text-weight-bold">Galeria de</span> Imagenes</q-toolbar-title>
        <q-btn flat round dense icon="close" v-close-popup/>
      </q-toolbar>
      <q-card-section>
        <media-list @image="select"/>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>

import {computed, onMounted, ref} from "vue";
import {useQuasar} from 'quasar'
import MediaList from "src/modules/media/_components/MediaList";
import {api} from "boot/axios";


export default {
  name: 'SingleMedia',
  components: {
    MediaList
  },
  props: {
    zone: {
      type: String,
      required:true
    },
    entity: {
      type: String,
      required:true
    },
    entity_id: {
      type: Number,
      default: null
    }
  },
  setup(props, contex) {
    const $q = useQuasar()
    const dialogNF = ref(false)
    const imagePath = ref(false)
    const select = (image) => {
      imagePath.value = image
      let selectedImage= {}
      selectedImage[props.zone]=image.id
      contex.emit('selectedImage',selectedImage)
      dialogNF.value=false
    }
    const removeImage = (image) => {
      contex.emit('selectedImage', null)
      imagePath.value = null
    }

    const onRequest = () => {
      if(props.entity_id){
        return new Promise(async (resolve, reject) => {
          let criteria = props.entity_id
          let params={
            filter:{
              zone:props.zone,
              entity: props.entity,
              field:'entity_id'
            }

          }
          api.get('/media/v1/files/' + criteria,{params:params}).then(response => {
            imagePath.value= response.data.data
            resolve(true)
          }).catch(error => {
            $q.loading.hide()
            reject(error)
          });
        })
      }

    }

    onMounted((props) => {
      onRequest()
    });
    return {imagePath, dialogNF, select, removeImage};
  },
};
</script>
<style lang="scss">
.dropzone {
  min-height: 230px;
  border: 2px dashed #ced4da;
  background: #fff;
  border-radius: 6px;

  .dz-message {
    font-size: 24px;
    width: 100%;
  }
}
</style>
