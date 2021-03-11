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
            <router-link :to="{ name: 'permissionList' }"
              >Permissions</router-link
            >
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Create Permission
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Permission Form</h6>
            <form
              class="forms-sample"
              @submit.prevent="permissionCreate"
              @keydown="form.onKeydown($event)"
            >
              <div class="form-group">
                <label for="permission_name">Permission Name</label>
                <input
                  v-model="form.permission_name"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('permission_name') }"
                  id="permission_name"
                  autocomplete="off"
                  placeholder="Permission Name"
                  name="permission_name"
                />
                <has-error :form="form" field="permission_name" />
              </div>

              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <router-link
                :to="{ name: 'permissionList' }"
                class="btn btn-light"
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
      permission_name: "",
    }),
  }),

  methods: {
    async permissionCreate() {
      await this.form.post("/api/permissions");
      this.$router.push({ name: "permissionList" });
    },
  },
};
</script>
