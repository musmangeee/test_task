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
            <p class="card-description">All the users are listed here.</p>
            <div class="table-responsive">
              <table id="dataTableExample" class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Avatar</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>
                      <img
                        :src="'/images/users/' + user.l_avatar"
                        alt="image"
                      />
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      <div v-for="user in user.roles" :key="user.id">
                        {{ user.name }}
                      </div>
                    </td>
                    <td class="text-center">
                      <toggle-button
                        @change="onChangeEventHandler(user, $event)"
                        :labels="{ checked: 'Active', unchecked: 'Deactive' }"
                        :value="user.status === 1 ? true : false"
                      />
                    </td>
                    <td>
                      {{ moment(user.created_at).startOf("hour").fromNow() }}
                    </td>
                    <td>
                      {{ moment(user.updated_at).startOf("hour").fromNow() }}
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <router-link
                          :to="'userEdit/?id=' + user.id"
                          class="btn btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-danger"
                          @click="deleteUser(user.id)"
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
      status: 0,
    };
  },
  created() {
    fetch("api/users")
      .then((response) => response.json())
      .then((res) => {
        this.users = res;
        console.log(res);
      });
  },
  methods: {
    // !! Delete
    deleteUser(id) {
      fetch(`api/users/${id}`, { method: "DELETE" }).then((response) => {
        let i = this.users.map((data) => data.id).indexOf(id);
        this.users.splice(i, 1);
      });
    },
    // !!
    onChangeEventHandler(user, event) {
      axios
        .put(`/api/changeStatus/${user.id}`)
        .then((response) => {
          console.log(response);
          let value = event.value;
          console.log(value);
        })
        .catch((response) => {
          console.log("error");
        });
    },
  },
};
</script>
