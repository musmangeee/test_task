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
          <li class="breadcrumb-item active" aria-current="page">Roles</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
        <router-link
          :to="{ name: 'roleCreate' }"
          class="btn btn-primary btn-icon-text"
        >
          <i class="btn-icon-prepend" data-feather="plus"></i>
          Create Role
        </router-link>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Roles</h6>
            <p class="card-description">All the roles are listed here.</p>
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Permissions</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="role in roles" :key="role.id">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>

                    <td>
                      <div v-for="role in role.permissions" :key="role.id">
                        {{ role.name }}
                      </div>
                    </td>

                    <td>
                      {{ moment(role.created_at).startOf("hour").fromNow() }}
                    </td>
                    <td>
                      {{ moment(role.updated_at).startOf("hour").fromNow() }}
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <router-link
                          :to="'roleEdit/?id=' + role.id"
                          class="btn btn-success"
                          >Edit</router-link
                        >

                        <button
                          class="btn btn-danger"
                          @click="deleteRole(role.id)"
                        >
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      roles: [],
      moment: moment,
    };
  },
  created() {
    fetch("api/roles")
      .then((response) => response.json())
      .then((res) => {
        this.roles = res;
      });
  },
  methods: {
    deleteRole(id) {
      fetch(`api/roles/${id}`, { method: "DELETE" }).then((response) => {
        let i = this.roles.map((data) => data.id).indexOf(id);
        this.roles.splice(i, 1);
      });
    },
  },
};
</script>
