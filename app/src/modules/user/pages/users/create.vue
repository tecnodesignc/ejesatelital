<template>
  <q-page class="page-content">
    <div class="page-title-box">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="page-title">
              <h4>Dashboard</h4>
              <breadcrumb :items="breadcrumb"/>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="page-content-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <q-card >
              <q-card-section>
                <h4 class="header-title">Bootstrap Validation - Normal</h4>
                <p class="card-title-desc">For custom Bootstrap form validation messages, you’ll need to add the <code>novalidate</code>
                  boolean attribute to your <code>&lt;form&gt;</code>.</p>

                <form class="needs-validation" novalidate>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="validationCustom01" class="form-label">First name</label>
                        <input type="text" class="form-control" id="validationCustom01"
                               placeholder="First name" value="Mark" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="validationCustom02"
                               placeholder="Last name" value="Otto" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="validationCustom03" class="form-label">State</label>
                        <select class="form-select" id="validationCustom03" required>
                          <option selected disabled value="">Choose...</option>
                          <option>...</option>
                        </select>
                        <div class="invalid-feedback">
                          Please select a valid state.
                        </div>

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="validationCustom04" class="form-label">City</label>
                        <input type="text" class="form-control" id="validationCustom04"
                               placeholder="City" required>
                        <div class="invalid-feedback">
                          Please provide a valid city.
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="validationCustom05" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="validationCustom05"
                               placeholder="Zip" required>
                        <div class="invalid-feedback">
                          Please provide a valid zip.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck"
                           required>
                    <label class="form-check-label" for="invalidCheck">
                      Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                      You must agree before submitting.
                    </div>
                  </div>
                  <div>
                    <button class="btn btn-primary" type="submit">Submit form</button>
                  </div>
                </form>
              </q-card-section>
            </q-card>
          </div>
        </div>
        <!-- end row -->
      </div>
    </div>

  </q-page>
</template>

<script>

import {ref} from 'vue';
import {useRouter, useRoute} from 'vue-router'
//import {useQuasar} from "quasar";
import Breadcrumb from 'src/components/Breadcrumb.vue'

export default {
  name: 'Create User',
  components: {Breadcrumb},
  setup() {
    const breadcrumb=[
      {
        name:"Dashboard",
        to:'app.home',
        active:false
      },
      {
        name:"user",
        to:'user.create',
        active:true
      }
    ]
    const first_name = ref(null)
    const last_name = ref(null)
    const email = ref(null)
    const password = ref(null)
    //const store = useStore();
    const router = useRouter()

    const register = async () => {
      try {
        const params = {
          attributes: {
            first_name: first_name.value,
            last_name: last_name.value,
            email: email.value,
            password: password.value
          }
        }
      } catch (error) {
        console.error('Register Login', error)
      }


    }
    const onReset = () => {
      first_name.value = null,
        last_name.value = null,
        email.value = null,
        password.value = null
    }
    return {email, password, breadcrumb, register, onReset};
  }
};
</script>

<style>

</style>
