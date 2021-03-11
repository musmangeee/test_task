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
            <router-link :to="{ name: 'roleList' }">Roles</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create Role
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Role Form</h6>
            <form
              class="forms-sample"
              @submit.prevent="roleCreate"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="role_name">Role Name</label>
                <input
                  v-model="form.role_name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('role_name') }"
                  id="role_name"
                  autocomplete="off"
                  placeholder="Role Name"
                  name="role_name"
                />
                <has-error :form="form" field="role_name" />
              </div>
              <div class="form-group">
                <label for="role_name">Permissions</label> <br />
                <span v-for="permission in permissions" :key="permission.id">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input
                        v-model="form.permission"
                        type="checkbox"
                        :class="{ 'is-invalid': form.errors.has('permission') }"
                        class="form-check-input"
                        name="permission[]"
                        value="" />

                      {{ permission.name }}
                      <i class="input-frame"></i
                    ></label>
                  </div>
                </span>
              </div>
              <v-button class="btn btn-primary mr-2">Submit</v-button>
              <router-link :to="{ name: 'roleList' }" class="btn btn-light"
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

export default {
  middleware: "auth",

  data: () => ({
    form: new Form({
      role_name: "",
      permission: [],
    }),
    permissions: [],
  }),
  created() {
    fetch("api/permissions")
      .then((response) => response.json())
      .then((res) => {
        this.permissions = res;
      });
  },
  methods: {
    async roleCreate() {
      await this.form.post("/api/roles");
      this.$router.push({ name: "roleList" });
    },
  },
};
</script>
