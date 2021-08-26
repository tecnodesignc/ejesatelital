<template>
  <div class="q-ma-md">
    <div class="row">
      <div class="col-12 col-md" v-for="(answer, i) in question.answers" :key="i">

        <q-btn-toggle
          v-if="answer.type_id==='8'"
          v-model="result[answer.id]"
          class="yesno-toggle"
          no-caps
          rounded
          unelevated
          toggle-color="primary"
          color="white"
          text-color="primary"
          @update:model-value="changValue(answer.id,result[answer.id])"
          :options="[
          {label: 'Si', value: 'Si'},
          {label: 'No', value: 'No'}
        ]"
        >
          <q-tooltip v-if="answer.caption" anchor="bottom middle" self="top middle" :offset="[10, 10]">
            {{answer.caption}}
          </q-tooltip>
        </q-btn-toggle>
        <q-input
          v-if="answer.type_id==='4'"
          outlined
          v-model="result[answer.id]"
          stack-label
          dense
          :placeholder="answer.title"
          @update:model-value="changValue(answer.id,result[answer.id])"
          style="width: 100%"
        ><q-tooltip v-if="answer.caption" anchor="bottom middle" self="top middle" :offset="[10, 10]">
          {{answer.caption}}
        </q-tooltip></q-input>

        <div class="q-gutter-sm" v-if="answer.type_id==='0'">
          <q-option-group
            v-model="result[answer.id]"
            :options="answer.options.fiels"
            color="primary"
            @update:model-value="changValue(answer.id,result[answer.id])"
          />
        </div>
        <div class="q-gutter-sm" v-if="answer.type_id==='1'">
          <q-option-group
            v-model="result[answer.id]"
            :options="options_rating_scale"
            color="primary"
          />
        </div>
        <div class="q-gutter-sm" v-if="answer.type_id==='2'">
          <q-option-group
            v-model="result[answer.id]"
            :options="options_likert_scales"
            color="primary"
          />
        </div>
        <div class="q-gutter-sm" v-if="answer.type_id==='3' && answer.options && answer.options.fields">
          <q-option-group
            v-model="result[answer.id]"
            :options="answer.options.fields"
            color="primary"
            type="checkbox"
          />
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {onMounted, ref} from 'vue'
import {useQuasar} from "quasar";
import {useStore} from "vuex";
import SingleMedia from "src/modules/media/_components/SingleMedia";

export default {
  name: 'RenderAnswers',
  components: {SingleMedia},
  props: {
    question: {
      type: Object,
      required: true
    }
  },
  setup(props, contex) {
    const $q = useQuasar();
    const result = ref([])
    const store = useStore();
    const medias_single = ref(null)
    const options_likert_scales=[
      {
        label: 'Muy en desacuerdo',
        value: 'Muy en desacuerdo'
      },
      {
        label: 'En desacuerdo',
        value: 'En desacuerdo'
      },
      {
        label: 'Neutral',
        value: 'Neutral'
      },
      {
        label: 'De Acuerdo',
        value: 'De Acuerdo'
      },
      {
        label: 'Muy de Acuerdo',
        value: 'Muy de Acuerdo'
      }
    ]
    const options_rating_scale=[
        {
          label: '1',
          value: 1
        },
        {
          label: "2",
          value: 2
        },
        {
          label: "3",
          value: 3
        },
      {
        label: "4",
        value: 4
      },
      {
        label: "5",
        value: 5
      }
    ]
    const changValue = (id,model) => {
      let respond = {
        question_id: props.question.id,
        answer_id: id,
        respond: model,
        account_id: store.state.account.account_id
      }
      contex.emit('result', respond)
    }
    const selectedImage = (selectedImage) => {
      medias_single.value = selectedImage
      contex.emit('result', {result:result.value, medias_single:medias_single.value})
    }
    onMounted(() => {});

    return {
      result,
      options_likert_scales,
      options_rating_scale,
      changValue
    };
  },
};
</script>
<style lang="scss">
.yesno-toggle{
  border: 1px solid $primary
}

</style>
