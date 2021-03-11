<template>
  <div>
    <div
      class="d-flex justify-content-between align-items-center flex-wrap grid-margin"
    >
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'home' }"> Dashboard </router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'userList' }">Mail Users </router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Add User Mail
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Users Form</h6>
            <form
              class="forms-sample"
              @submit.prevent="sendMail"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                  autocomplete="off"
                  placeholder="Email"
                  name="email"
                />
                <has-error :form="form" field="email" />
              </div>

              <v-button class="btn btn-primary mr-2"> Submit </v-button>
              <router-link :to="{ name: 'userList' }" class="btn btn-light">
                Cancel
              </router-link>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";

export default {
  middleware: "auth",

  data: () => ({
    form: new Form({
      email: "",
    }),
  }),

  methods: {
    async sendMail() {
      // Register the user.
      await this.form.post("/api/send_mail");
      this.$router.push({ name: "mailUser" });
    },
  },
};
</script>
