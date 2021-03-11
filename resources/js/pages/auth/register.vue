<template>
  <div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">
      <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
          <div class="card">
            <div class="row">
              <div class="col-md-4 pr-md-0">
                <div class="auth-left-wrapper"></div>
              </div>
              <div class="col-md-8 pl-md-0">
                <div class="auth-form-wrapper px-4 py-5">
                  <a href="#" class="noble-ui-logo d-block mb-2"
                    >Noble<span>UI</span></a
                  >
                  <h5 class="text-muted font-weight-normal mb-4">
                    Create a free account.
                  </h5>
                  <form
                    enctype="multipart/form-data"
                    class="forms-sample"
                    @submit.prevent="register"
                    @keydown="form.onKeydown($event)"
                  >
                    <div class="form-group">
                      <label for="exampleInputUsername1">{{
                        $t("name")
                      }}</label>
                      <input
                        v-model="form.name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                        class="form-control"
                        type="text"
                        name="name"
                      />
                      <has-error :form="form" field="name" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">{{ $t("email") }}</label>
                      <input
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        class="form-control"
                        type="email"
                        name="email"
                      />
                      <has-error :form="form" field="email" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">{{
                        $t("password")
                      }}</label>
                      <input
                        v-model="form.password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        class="form-control"
                        type="password"
                        name="password"
                      />
                      <has-error :form="form" field="password" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">{{
                        $t("confirm_password")
                      }}</label>
                      <input
                        v-model="form.password_confirmation"
                        :class="{
                          'is-invalid': form.errors.has(
                            'password_confirmation'
                          ),
                        }"
                        class="form-control"
                        type="password"
                        name="password_confirmation"
                      />
                      <has-error :form="form" field="password_confirmation" />
                    </div>
                    <div class="form-group">
                      <input
                        v-model="form.roles"
                        :class="{
                          'is-invalid': form.errors.has('roles'),
                        }"
                        class="form-control"
                        type="hidden"
                        name="roles[]"
                      />
                      <has-error :form="form" field="roles" />
                    </div>

                    <!--  -->
                    <!--  -->
                    <div class="form-group">
                      <label for="avatar">Avatar</label>
                      <input
                        type="file"
                        name="avatar"
                        class="form-control"
                        id="avatar"
                        @change="onFileChange($event)"
                      />
                    </div>

                    <div class="form-check form-check-flat form-check-primary">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" />
                        Remember me
                      </label>
                    </div>
                    <div class="mt-3">
                      <v-button :loading="form.busy">
                        {{ $t("register") }}
                      </v-button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
  layout: "basic",
  middleware: "guest",

  metaInfo() {
    return { title: this.$t("register") };
  },

  data: () => ({
    form: new Form({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      avatar: null,
      roles: [2],
    }),
    mustVerifyEmail: false,
  }),

  methods: {
    onFileChange(event) {
      this.form.avatar = event.target.files[0];
      console.log(this.form.avatar);
    },
    async register() {
      let formData = new FormData();
      formData.append("avatar", this.form.avatar);
      Object.keys(this.form).map((item, index) => {
        console.log(item, this.form[item], this.form);
        formData.append(item, this.form[item]);
      });

      await axios
        .post("/api/register", formData)
        .then((success) => {
          this.$router.push({ name: "login" });
          console.log(success);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
