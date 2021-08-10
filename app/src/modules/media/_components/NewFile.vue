<template>
  <q-btn
    label="Subir Archivos"
    color="primary"
    icon="add"
    @click="dialogNF= true"
  />
  <q-dialog v-model="dialogNF">
    <q-card style="width: 600px; height: auto">
      <q-uploader
        :factory="uploadFile"
        multiple
        auto-upload
        style="width: 100%;"
        accept=".jpg, image/*, .pdf "
        label="Batch upload"
        @rejected="onRejected"
      >
        <template v-slot:header="scope">
          <div class="row no-wrap items-center q-pa-sm q-gutter-xs">
            <q-btn v-if="scope.queuedFiles.length > 0" icon="clear_all" @click="scope.removeQueuedFiles" round dense
                   flat>
              <q-tooltip>Clear All</q-tooltip>
            </q-btn>
            <q-btn v-if="scope.uploadedFiles.length > 0" icon="done_all" @click="scope.removeUploadedFiles" round dense
                   flat>
              <q-tooltip>Remove Uploaded Files</q-tooltip>
            </q-btn>
            <q-spinner v-if="scope.isUploading" class="q-uploader__spinner"/>
            <div class="col">
              <div class="q-uploader__subtitle">Tamaño {{ scope.uploadSizeLabel }}</div>
            </div>
            <q-btn v-if="scope.canAddFiles" type="a" icon="add_box" round dense flat>
              <q-uploader-add-trigger/>
              <q-tooltip>Pick Files</q-tooltip>
            </q-btn>
            <q-btn type="a" icon="close" round dense flat v-close-popup>
              <q-tooltip>Cerrar Ventana</q-tooltip>
            </q-btn>
            <q-btn v-if="scope.canUpload" icon="cloud_upload" @click="scope.upload" round dense flat>
              <q-tooltip>Upload Files</q-tooltip>
            </q-btn>
            <q-btn v-if="scope.isUploading" icon="clear" @click="scope.abort" round dense flat>
              <q-tooltip>Abort Upload</q-tooltip>
            </q-btn>
          </div>
        </template>
        <template v-slot:list="scope">
          <div class="dropzone">
            <q-uploader-add-trigger/>
            <div class="row">
              <div class="col-12">
                <div class="q-gutter-sm row items-start" v-if="scope.files.length > 0">
                  <q-img v-for="file in scope.files" :key="file.name" class="q-ma-md"
                         :src='file.__img?file.__img.src:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAMAAADDpiTIAAADAFBMVEVHcEwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAFBhPIAAAAAAABQjvRIiPNEhvNDhfMAAAAGBwkAAAAAAABGh/MAAAAAAABOjPMAAQEAAAAAAABNi/MAAAAAAAAAAABJifMBAgQAAABLivMAAAAAAAAAAAAAAAAAAAAAAAAAAACkxPqfvvRbdJ+fv/ZMivNCfN0AAABDfuNAdtBDhPNBedc/dMtMi/NDgOifv/ZEgu5Bg/GkxPqfvvSfvvQxY7Y/f+lCfuNDhfQjR4NOi/BPjfNPjfOkw/lAgu86ddg5ctI/f+k8ed80asNMiOtGfdedvfOfv/WfvvRQjvSfv/Wfv/UnTpFAgew/gOoQIDwtW6cWLVRBg/FPjvQ9ed9Ni+9QjvRLheZAhPNOjPFEgupQjvSUtu5PjvQ0acAGCxQAAAExYLEiRX42bMZPjfQUKEpel/WiwvlFh/RKivTy8vJLi/REhvRDhvRNjPRIifRHiPRGiPROjfSmxfpMi/RChfRPjfRJifRDhfRMjPRGh/RJivRQjvREh/RPjvROjPRLivQ/dMxAhPRHifRBd9NBetpAdc9AdtJBeNVXkvRuoPRRjvT19PL//PJCfN4/c8rq7fLz8vLj6fL08/L69/I3fvT59vLL2vI/c8s/dc0/dc5CfeBAddBAdtFBeNT/+/JAedZBeddBedhDfeJBedlDfuKJsvT//fI5gPQzfPSuyPP/+vJDf+ZBe9tCe9w/c8lDf+StyvtEges1a8RnnfRtl96wzf+kxPplm/RDfuNAeddEguxCfd9Eg+5DfeFDgOhel/VDgelDf+VMjPdNi/Rfl/VFhPBDgOdDf+dKi/Wpx/tJh+9IheugwPlLjPZIifNHg+dKifGryfxKivNgmPVfmPVNjfg9ccf///I5bcaoxvuPs/B4qPdDfNqWuvdUkPVBeNNkkNpMi/NbiNVTh96DqupHecxLi/Pv8fJknPbV4fJQgNBpldwxe/S2zvNAedngO0ESAAAAeHRSTlMAFhE7HAgMAQIFPT8vKiM0+ThA9/j4+Q4DBBT4Bw35Bhga+AsgCvgJHvg2Jy0rJTMx92QEevj4Ofj4/Pj4+Ph0+Pf7bGiL3fX9UWeuzv/vvqHUx5dDFW+AcPN/fm/o40x8U/P9q5HrKf17wNhp4oklImZodPxC976uy9QkAAAQGUlEQVR42uzb61OU1x3A8cgg4EwmeUEil5AayxCn01dW22lTehnTySRcZuIMtLV9l3gZtZkkk0wbC26MC1pwEbRq8Ya92UYEBFq0tipoNhWr0gQVG3ZBLolAAYM62tzbXQtObBbYy3Poc87v+/0TOJ855zxnf9x1FxERERERERERERERERERERERERERUXDFzcvNyViSmbky3qR+/JN5LG1w5SzPzFq5dFG8y6RK31kwn6UNotyMzGfMWvpRAG8fnzs/NpYFnmT5l2ctchmZD4Bz7rdiITBhGVnxLpe5AE4iYMKWZS5yuUwG4PTtAXEIGKd5OVlPu0wH4Fzw/UQEBCp2XsZSl8t8AM4Fj85DQMD1X+QSAcCZ/R0EfGb5fesf7xICwJn9JQR8Zv1zlrrEAPAJ4CZ45/rHLVvpEgQAAf+7/rmZLlEAEHDn+sdlbDQ/xzufAuC7CSLgUwfAM+IAOLMfRcDY+icu2SgPgDP7uwgYXf9lSyUCcJ7kVdgPIC4xaflGkQCcJ+cjwLcBJOWuFAoAAbcOgFk5L0oF4Dz5A+EC/AfAHBFXwMAAnAu+J1qA/wCYlZslGIBz7g8lC4iNTZyRkrNonYjOXwgEwDlX8j3AvwHMyYgXDUCygFsbQNqSF2UDEDwl5v8EmB6TKR2A3Ckx3wmQkpaw4mnpAKROiflPgOmpUVnrxAMQOiXmPwHmPBj1OQAInRLzfwOkJSQDQOqEiP8KkAoAuQL8V4CYqGkAkCrAB8B3BQCA1Cmx0TvgQwAQOiU2egcEgNQpsf8+AyXPBoDQKbHRjwAASJ0RugUgKjkaAEIFACCwADFTYrFx/l8CACB2SswPICZqGgCkTokBYFwBMu4BABAuAAATCJDwHgCAiW6CAqbEADChAPOnxG4DWCujgjdCASBgSgwAkwgwfUoMAJMKMPsmCADhAgAgXAAAgrkJGiwAAMEIMHhKDABBCTB3SgwAQWXulBgAghRg6i9DABAuAABBCzBzSgwAwf8yZOSUGACCz8gpMQCEIsDAewAAhAsAQGgCjHsPAECIN0HTpsQAEKoAw6bEABD6b4NGCQBA6AKMmhIDQDgCDLoJAkC4AAAIFwCAMG+CpggAQJgCTJkSA0C4AgyZEgNAuBkyJTYG4POlMiqzDIAhM0IAEC4AAJEIMGBKDAAR/TKk/5QYACJK/ykxAEQoQPd7wG0ADhlZDUB7AQCIWIDe7wEAiPwmqPWUGAAsEKDzlBgALPltUF8B0gDkbe/4pwIB+k6JyQNwpd2pQoCuN0EACBcgDUDBuweVANBWgDgA64Z6nGoE6DklJg1A0fkdanYAXafEpAHwfQeq+AzQd0pMHoB3Dyo6A/ScEhMHwFE6dNypTIB+vwzJA7DqbWVngI4C5AHwnQHqtgD9psTkAXCscmer2wK0mxKTCEDpFqDblJhAAI717o52lQK0ugdIBJC3bkglAL0ESATgWPXGlR6lAjR6DxAJwLHmfaWHgE5TYjIBODbsUPgYoNWUmFAABQVDHSoB6DMlJhSAo+D8kNpTQJcpMakAHAV5Q2pPAU0mRMQCcBQV77jS3i5egFwADkf++zc6ehTuAid/pIEAyQAcncNXB7N71O0CHRoIEA3Aca725keDHT2qDLRrIEA2AIej5rWbV2/4DBz3KVDAoMP2U2LSAXSPDAw0fnj19RuDVzo6ev5qee12/3VYOoCNnpG+voGBvpsfXr9+/aPXre9qor0FjAH4RpHQ1nq39TU2+hEMDLymoIEkewsQD6Co07vJJ0BZ6bPsLQAARZ1dexr3KCt9+owkANi8rj5lAhrT01Jm2HkLAID/HtDV96qq0mPm+A4BANhcQIMyAekJqdP9WwAAbN21M42b1JQe9aBvCwCA3beAa8OKBKQnJ6T6bgG2PQMAMFp33R41AKZFxdj5DADA2B7gKVciIP0he58BABjrnHfkVSUAkhPSUgCgQZe9I5v2WV76bP8lAABaCOiqVgAgOjlKBwBfLqCCy11V+yotLj361i0QAJoIqASA6NY2VFZus7SvAUCris7sA4Dorg1XAkB03cOVVRYGAO0OAU/dNgDIFlCzDQCi826pqrYqAGhYp7f6F1YFAC1PAW8VAGTXtQ0AonM0VW2xJADo+iDUUA0A0deA7gorBNQAQF8Bw9XsAJI75xneUhNp5QDQWsBIxAIAoHGXvfUj5RH2dQBoLaCuBgCyBUS4/lt0AfCFPArUua7a8tpIAoDevdXZVAsAyXXmNdT+LYIAoL2A3pbauvADgP4CuivKASBbwLG6+nADgAkCPFsBIFzAH8MNAGZ8DXrqASA7b/3WsAKAKXXVA0B0/wpLwFEAGFNvUz07gOiLYHfDvwEg+0GoYevRUPsKAMypqHt/qAK2AsCsB6H9R4+FFgAME1BxFACSO+epOFYRSgAwbQ/whiYAAKZ9DBaFJgAAxm0BnV3sALIF5F0EgGwBva0VZ4INACY+CPU2VQBA9h7QAADpPwvsDy4AGPo12N0S1Pq3AMDUPPtbgumrABAt4AwAzM3b8ofJA4C59XpbGiYNACYL6GoxB0AZhV4QAgBgdJcuNpyaOF0APLyKwuitS60AEC7gyKmmiQKA6QI8racAIFsAO4BwAd7WptZxA4D5AHwCWo+MFwAECFjlHRfARQBIENB7gh1A+MfgiVYAyBbw5pF/BOybAJAi4GLAACBHwN8DBQAxBRYAADl53gwQAIQLAIBwAQAQ1VkAyK73LACkCzhxZwAQLgAA0lp/FgDCnwRPA0D4k+DpE6dv920ASBQAANmngOfsWAAQ+iR4WwAAZNbGDiC6vNsCACBUQFkbAIQ/CbYBQPiTYBsAhD8HtIkGsEbLLBbQ1qYNgA3WVuLe9UsN2+UusfKvcEkygAO/0rAD1gLYUCwZwE81zGoAG4oBIBvAhocBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAID/N4D71ltbvq4A8i3+Q9wnFsChXRp2CABWVbZTy8rWA8CiXtay9QAgABAACAAEAAIAAYAAQAAgABAACAAEADIPwMukJAAAAAAAAAAAAAAAWQBe0TIAWFXedi3LA4A1rXb3/1bD+t2rAWARAE3/MQQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABMAGD3bzRsNwCsAtD83q817L1mAFjUms1atoaZQAIAAYAAQAAgABAASAKAn5OSdAHwwBpS0gMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgLoBiPWcCiwFg0fqX7tCy0mIAWFKhu3+3hvW7CwFgDYBmPf8zqBkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABMNBDyOw1jIMSqVl/44Pca9sGF1QCwpvzDezXscD5DoSQTwCukJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADADAAle/80Re0tAYD9AJTsHDw4RQ3uLAGA7QBsdvcfmqL63ZsBEDmAYmvbPHX/GXSgeXOxfQMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMAmAO5/ydqmFsBL9u1+AAAAAAAAAACEAXD3/2WK6ncDwH4ACrd/8ucp6pPthQCwHYDiwo8PT1EfFxYDwHYACAAEAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGBKAJSQkgAAAAAAAAAAAAAAAAAA+wLIJyUBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAKAIwMzVpKSZAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAqAew8GekoscXagJgxeMslhIAKzQBsBgAalqsCYAnH2GtVPTIk5oAeGEmi6WimS9oAuCJp1gsFT31hAYAUqOSo+/mM0BFJQvvjk6OSrU1gKQUP4BnF7NaSu6Az/oBpCTZHsA9z3MLVHEHfP4eHQAkJM9+7t7HWC7re+ze52YnJ9gdQJofwBf/057Z9CYKRWG4CuLUDyxuoEYCRg0EUNm5dgGpG7W69bM/oDFNZjnL+d9zzr1i20mKTsskl+Y8P+G+z33PubD6TWTNr5WPAvTFFsACAeyeP51RYFkzm/o9GwSwRBbAsByzaLvDwYICy5rFYOjaRdOxDGEFuCkbtyBAQVbr0w0lli2baV2VCyDArSFs/igA+xKk1mvPFFm2PNeYAEpJaAH4M0A++sHPJWWWJcufgX+UxX4EvG6BsASE0y2llh3baYgrgNg74HkLZDNgtH+i3LLiaT+qnVYAkXfAmzIuAfgtEGZAqEV3lFw2TCItZBMA/wQYZXEFSD4F2S5UQEOKJpRdNvlLDSgANgGEXgH4DGDvAKwAT4roe1AWX4AiyWMFgG8AoScAnwG8AoawBWjSOn6gAL/GQ7yWNNgA+ArYFnsC8HeAwytgEHqadJjTGPha/c8PkuaFA14AjiX2BHhbAbAFhN5Yquxj2gU/zV28r0hjLzxvAKIXAAjAK6DV6eEQQAN2q5gehJ97/MWrHeaPA6DXaZ0KQGwBcA3EhwAfAtyAyi5abmgS/Gv3b5bRrsLz5wMAnwCG4BOAVQB+C4AhcDYAFKi+rOaP29mEpsE1vT+ZbR/nq5dq9U3+MADwG4DwBfBmCHADcBMEBZrNwzpazJfxHXGBeDlfROtDswnx4/53yj8fA+A8BBwTDHCZAQ1tzFoAJKhWm8RFqnhQePulsdZg+cMCWDSdPAyA8xBo903eAfUgHHneSQGYBcQ1VHj83igM6vz+m/gCyEUB/GWAiiUACrAaOFlAXEDC9DF+uP5q7vLna0BigKv6dVSgAQ6ABFwDIhUIX/MaGH/dV90k//vc5I8CMAMUvVXoYAmgAswBRCPSgTOC9Hn8R7lTaOkKyz8/AiQGOIrOSgAUQAdAAtBgNGoQHzJCIHxMH+Jn119XnJzlzw0wbq1S1ywyBXrH4RAcGARBjbhAEASY/vDYY/EXzW7Jgvmfq/zRAHwNWrwEWnYHHVBBAqgCIhU4In/I0u/YLX79LXz/5Sv/xAAoAdgEoAUK4IDsggXHo0qkAAfUc10Z0i/A7YfpD9c/j/knYwA2AVDARAdAArsDyEQqcEQ23v2ibkL8bYz/Rw7jT0qAKeB0FR0cAAmQApFGC8Mv6rrSdVj8+bz+7xWwmANQBEwDIhU4JFNh6Vs5jz9RAAcBc8Dp97uAQnwInk+/77D0T+Wf5/hfFTDuUQKrDZSIFPCELAwfL/83iP+kADgAEoAF9ygC8THsiAwMH9P/DvG/SoAWEFdR/lbhv7eAuIIbgiAIgiCI/8sfkSLq3opsXbMAAAAASUVORK5CYII="'
                         spinner-color="red"
                         style="height: 140px; max-width: 150px"
                  >
<!--                    <q-btn
                      class="gt-xs"
                      size="12px"
                      round
                      color="negative"
                      dense
                      style="top: 2px; left: 80%"
                      icon="delete"
                      @click="scope.removeFile(file)"
                    />-->
                    <div class="absolute-bottom text-center text-caption">
                      {{ file.name }}
                    </div>
                  </q-img>

                </div>
                <div v-else class="dz-message needsclick text-center text-blue-grey-3">
                  <h4>
                    <div class="q-mb-md">
                      <q-icon type="outlined" name="backup" size="xl"/>
                    </div>
                    Drop files here to upload
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </template>
      </q-uploader>
    </q-card>
  </q-dialog>
</template>

<script>

import {computed, ref} from "vue";
import {useQuasar} from 'quasar'
import {api} from "boot/axios";
import array from "src/plugins/array";
import {useStore} from "vuex";
import helper from "src/plugins/helpers";

export default {
  name: 'NewFile',

  props: {
    folder_id: {
      type: Number,
      default: 0
    }
  },

  setup(props, contex) {
    const $q = useQuasar()

    const store = useStore();
    const dragAndDropCapable = ref(false)
    const success = ref(false)
    const dialogNF = ref(false)
    const uploadFile = (files) => {
      return new Promise(async (resolve, reject) => {
        let formData = new FormData();
        console.warn(files[0])
        formData.append('file', files[0]);
        formData.append('folder_id', props.folder_id);
        console.log(formData);
        let params = {
          attributes: {
            file: formData.file,
            folder_id: props.folder_id,
          }
        }
        api.post('/media/v1/files', formData).then(response => {
          $q.loading.hide()
          contex.emit('upload',true)
          $q.notify({
            color: 'positive',
            position: 'bottom-right',
            message: 'Archivo Subido ',
          })
          success.value = true
          resolve(true)
        }).catch(error => {
          $q.notify({
            color: 'negative',
            position: 'bottom-right',
            message: 'Error al subir el archivo: ' + error.errors,
            icon: 'report_problem'
          })
          $q.loading.hide()
          reject(error)
        });
      })

    }

    /*const uploadFile = (files) => {

      console.log(files.value)
      return new Promise( (resolve) => {



        let params = {
          attributes: {
            folder_id: props.folder_id,
          }
        }
        const token =store.state.auth.token;

       resolve({
          url: process.env.API_URL+'/api/media/v1/files ',
          method: 'POST',
          headers: [
            { name: 'Authorization', value: token},
            { name: 'Content-Type', value: 'application/json;charset=UTF-8'}
          ],
          formFields:[params]
        });
      })

    }*/
    function onRejected(rejectedEntries) {
      $q.notify({
        type: 'negative',
        message: `${rejectedEntries.length} file(s) did not pass validation constraints`
      })
    }

    return {name, dialogNF, helper, uploadFile, onRejected};
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
