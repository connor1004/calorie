<template>
  <div>
    <!-- Header -->
    <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
      <b-container class="container">
        <div class="header-body text-center mb-7">
          <b-row class="justify-content-center">
            <b-col xl="5" lg="6" md="8" class="px-5">
              <h1 class="text-white">Create an account</h1>
            </b-col>
          </b-row>
        </div>
      </b-container>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
             xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <b-container class="mt--8 pb-5">
      <!-- Table -->
      <b-row class="justify-content-center">
        <b-col lg="6" md="8" >
          <b-card no-body class="bg-secondary border-0">
            <b-card-body class="px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Sign up with credentials</small>
              </div>

              <b-alert show v-if="errorMessage" variant="danger">
                {{ errorMessage }}
              </b-alert>
              <b-alert show v-if="isSuccess" variant="success">
                Your account was registered successfully.
                Please <router-link to="/login" class="text-success">Login</router-link>.
              </b-alert>

              <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                <b-form role="form" @submit.prevent="handleSubmit(onSubmit)">
                  <base-input alternative
                              class="mb-3"
                              prepend-icon="ni ni-hat-3"
                              placeholder="Name"
                              name="Name"
                              :rules="{required: true}"
                              v-model="model.name">
                  </base-input>

                  <base-input alternative
                              class="mb-3"
                              prepend-icon="ni ni-email-83"
                              placeholder="Email"
                              name="Email"
                              :rules="{required: true, email: true}"
                              v-model="model.email">
                  </base-input>

                  <base-input alternative
                              class="mb-3"
                              prepend-icon="ni ni-lock-circle-open"
                              placeholder="password"
                              type="password"
                              name="Password"
                              :rules="{required: true, min: 6}"
                              v-model="model.password">
                  </base-input>
                  <!-- <div class="text-muted font-italic"><small>password strength: <span
                    class="text-success font-weight-700">strong</span></small></div> -->
                  <b-row class=" my-4">
                    <b-col cols="12">
                      <base-input :rules="{ required: { allowFalse: false } }" name=Privacy Policy>
                        <b-form-checkbox v-model="model.agree">
                          <span class="text-muted">I agree with the <a href="#!">Privacy Policy</a></span>
                        </b-form-checkbox>
                      </base-input>
                    </b-col>
                  </b-row>
                  <div class="text-center">
                    <b-button type="submit" variant="primary" class="mt-4">
                      {{ busy ? 'Creating acccount ...' : 'Create account' }}
                    </b-button>
                  </div>
                </b-form>
              </validation-observer>
            </b-card-body>
          </b-card>
          <b-row class="mt-3">
            <b-col cols="6">
              <!-- <router-link to="/dashboard" class="text-light"><small>Forgot password?</small></router-link> -->
            </b-col>
            <b-col cols="6" class="text-right">
              <router-link to="/login" class="text-light"><small>Already have an account? Login</small></router-link>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  name: 'register',
  data() {
    return {
      model: {
        name: '',
        email: '',
        password: '',
        agree: false
      },
      busy: false,
      errorMessage: '',
      isSuccess: false,
    }
  },
  methods: {
    ...mapActions({
      register: "auth/register",
    }),
    async onSubmit() {
      this.busy = true;
      this.errorMessage = '';
      let params = {
        name: this.model.name,
        email: this.model.email,
        password: this.model.password
      };
      const resp = await this.register(params);

      if (resp.status == 422) {
        const errors = resp.data.errors;
        const errorTexts = [];
        for (let field in errors) {
          errorTexts.push(...errors[field]);
        }

        this.errorMessage = errorTexts.join(' ');
      } else if (resp.status == 200) {
        this.isSuccess = true;
      }
      this.busy = false;
    }
  }

};
</script>
<style lang="scss" scoped>
</style>
