<template>
  <div>
    <div
      class="d-flex justify-content-between align-items-center flex-wrap grid-margin"
    >
      <nav class="page-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'home' }">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link :to="{ name: 'userList' }">Users</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Update User
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">User Update Form</h6>
            <form
              @submit.prevent="update"
              class="forms-sample"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="name"> Name</label>
                <input
                  v-model="form.name"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  type="text"
                  class="form-control"
                  id="name"
                  autocomplete="off"
                  placeholder="Name"
                  name="name"
                  value=""
                />
                <has-error :form="form" field="name" />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  v-model="form.email"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                  type="email"
                  class="form-control"
                  id="email"
                  autocomplete="off"
                  placeholder="Email"
                  name="email"
                  value=""
                />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  autocomplete="off"
                  placeholder="Password"
                  name="password"
                />
                <has-error :form="form" field="email" />
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="confirm-password"
                  autocomplete="off"
                  placeholder="Password"
                  name="confirm-password"
                />
              </div>
              <div class="form-group">
                <span v-for="user in users[1]" :key="user.id">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        name="roles[]" />
                      {{ user }}
                      <i class="input-frame"></i
                    ></label>
                  </div>
                </span>
              </div>
              <v-button class="btn btn-primary mr-2">Submit</v-button>
              <router-link :to="{ name: 'userList' }" class="btn btn-light"
                >Cancel</router-link
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";

export default {
  data: () => ({
    form: new Form({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    }),
    users: [],
  }),

  created() {
    fetch("/api/users/" + this.$route.query.id)
      .then((response) => response.json())
      .then((res) => {
        this.users = res;
        this.form.name = res[0].name;
        this.form.email = res[0].email;
      });
  },
  methods: {
    async update() {
      await this.form.patch("/api/users/" + this.$route.query.id);
      this.$router.push({ name: "userList" });
    },
  },
};
</script>
