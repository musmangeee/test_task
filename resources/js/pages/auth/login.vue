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
                    Welcome back! Log in to your account.
                  </h5>
                  <form
                    class="forms-sample"
                    @submit.prevent="login"
                    @keydown="form.onKeydown($event)"
                  >
                    <div class="form-group">
                      <label for="email">E-Mail Address</label>
                      <input
                        id="email"
                        type="email"
                        class="form-control"
                        name="email"
                        value=""
                        required
                        autocomplete="email"
                        autofocus
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email" />
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input
                        id="password"
                        type="password"
                        class="form-control"
                        name="password"
                        required
                        autocomplete="current-password"
                        v-model="form.password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                      />
                      <has-error :form="form" field="password" />
                    </div>
                    <div class="form-check form-check-flat form-check-primary">
                      <label class="form-check-label">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          name="remember"
                          id="remember"
                        />
                        Remember Me
                      </label>
                    </div>
                    <div class="mt-3">
                      <button
                        type="submit"
                        class="btn btn-primary mr-2 mb-2 mb-md-0 text-white"
                        :loading="form.busy"
                      >
                        Login
                      </button>
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
import Cookies from "js-cookie";
import LoginWithGithub from "~/components/LoginWithGithub";

export default {
  components: {
    LoginWithGithub,
  },
  layout: "basic",
  middleware: "guest",

  metaInfo() {
    return { title: this.$t("login") };
  },

  data: () => ({
    form: new Form({
      email: "",
      password: "",
    }),
    remember: false,
  }),

  methods: {
    async login() {
      // Submit the form.
      const { data } = await this.form.post("/api/login");

      // Save the token.
      this.$store.dispatch("auth/saveToken", {
        token: data.token,
        remember: this.remember,
      });

      // Fetch the user.
      await this.$store.dispatch("auth/fetchUser");

      // Redirect home.
      this.redirect();
    },

    redirect() {
      const intendedUrl = Cookies.get("intended_url");

      if (intendedUrl) {
        Cookies.remove("intended_url");
        this.$router.push({ path: intendedUrl });
      } else {
        this.$router.push({ name: "home" });
      }
    },
  },
};
</script>
