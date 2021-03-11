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
            <router-link :to="{ name: 'userList' }"> Users </router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create User
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
              @submit.prevent="userCreate"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="name"> Name</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  autocomplete="off"
                  placeholder="Name"
                  name="name"
                />
                <has-error :form="form" field="name" />
              </div>
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
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  id="password"
                  v-model="form.password"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                  type="password"
                  class="form-control"
                  autocomplete="off"
                  placeholder="Password"
                  name="password"
                />
                <has-error :form="form" field="password" />
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input
                  id="confirm-password"
                  v-model="form.password_confirmation"
                  :class="{
                    'is-invalid': form.errors.has('password_confirmation'),
                  }"
                  type="password"
                  class="form-control"
                  autocomplete="off"
                  placeholder="Password"
                  name="password_confirmation"
                />
              </div>
              <div class="form-group">
                <span v-for="role in roles" :key="role.id">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        name="roles[]"
                        v-model="form.roles"
                        value="" />
                      {{ role.name }}
                      <i class="input-frame"></i
                    ></label>
                  </div>
                </span>
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
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      roles: [],
    }),
    roles: [],
  }),
  created() {
    fetch("api/roles")
      .then((response) => response.json())
      .then((res) => {
        this.roles = res;
      });
  },
  methods: {
    async userCreate() {
      // Register the user.
      await this.form.post("/api/users");
      this.$router.push({ name: "userList" });
    },
  },
};
</script>
