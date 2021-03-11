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
          <li class="breadcrumb-item active" aria-current="page">
            Permissions
          </li>
        </ol>
      </nav>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
        <router-link
          :to="{ name: 'permissionCreate' }"
          class="btn btn-primary btn-icon-text"
        >
          <i class="btn-icon-prepend" data-feather="plus"></i>
          Create Permission
        </router-link>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Permissions</h6>
            <p class="card-description">All the permissions are listed here.</p>
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Permission Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="permission in permissions" :key="permission.id">
                    <td>{{ permission.id }}</td>
                    <td>{{ permission.name }}</td>
                    <td>
                      {{
                        moment(permission.created_at).startOf("hour").fromNow()
                      }}
                    </td>
                    <td>
                      {{
                        moment(permission.updated_at).startOf("hour").fromNow()
                      }}
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <router-link
                          :to="'permissionEdit/?id=' + permission.id"
                          class="btn btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-danger"
                          @click="deletePermission(permission.id)"
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
      permissions: [],
      moment: moment,
    };
  },
  created() {
    fetch("api/permissions")
      .then((response) => response.json())
      .then((res) => {
        this.permissions = res;
      });
  },
  methods: {
    deletePermission(id) {
      fetch(`api/permissions/${id}`, { method: "DELETE" }).then((response) => {
        let i = this.permissions.map((data) => data.id).indexOf(id);
        this.permissions.splice(i, 1);
      });
    },
  },
};
</script>
