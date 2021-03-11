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
          <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
        <router-link
          :to="{ name: 'userCreate' }"
          class="btn btn-primary btn-icon-text"
        >
          <i class="btn-icon-prepend" data-feather="plus"></i>
          Create User
        </router-link>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Users</h6>
            <p class="card-description">
              All the mailed users are listed here.
            </p>
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      {{ user.status === 1 ? "Registered" : "Not Registered" }}
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
import { ToggleButton } from "vue-js-toggle-button";
import axios from "axios";
export default {
  components: {
    ToggleButton,
    axios,
  },
  data() {
    return {
      moment: moment,
      users: [],
      status: "",
    };
  },
  created() {
    fetch("api/mailed-users")
      .then((response) => response.json())
      .then((res) => {
        this.users = res;
      });
  },
  methods: {},
};
</script>

