<template>
  <div>
    <nav class="sidebar">
      <div class="sidebar-header">
        <router-link :to="{ name: 'home' }" class="sidebar-brand">
          Lead<span>Gorilla</span>
        </router-link>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <template v-for="item in links[userRole]">
            <li :key="item.index" class="nav-item nav-category">
              {{ item.name }}
            </li>
            <li
              :key="innerItem.index"
              class="nav-item"
              v-for="innerItem in item.children"
            >
              <router-link :to="{ name: innerItem.to }" class="nav-link">
                <!-- <box-icon size="1.2x" class="custom-class"></box-icon> -->
                <span style="padding-left: 7px">{{ innerItem.name }}</span>
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import {
  AirplayIcon,
  AtSignIcon,
  ActivityIcon,
  BoxIcon,
  ShieldIcon,
  LockIcon,
  UsersIcon,
} from "vue-feather-icons";
export default {
  components: {
    AirplayIcon,
    ActivityIcon,
    BoxIcon,
    ShieldIcon,
    LockIcon,
    UsersIcon,
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
    }),
    userRole() {
      return this.user[0].roles[0].name + "Links";
    },
  },
  data: function () {
    return {
      links: {
        adminLinks: [
          {
            name: "Main",
            children: [
              {
                name: "Dashboard",
                to: "home",
              },
            ],
          },
          {
            name: "Manage",
            children: [
              // {
              //   name: "Roles",
              //   to: "roleList",
              // },
              // {
              //   name: "Premission",
              //   to: "permissionList",
              // },
              {
                name: "Users",
                to: "userList",
              },
              {
                name: "Send Mail",
                to: "sendMail",
              },
              {
                name: "Mailed Users",
                to: "mailUser",
              },
            ],
          },
        ],
        userLinks: [
          {
            name: "Main",
            children: [
              {
                name: "User Manager",
                to: "user",
              },
            ],
          },
          {
            name: "Manage",
            children: [
              {
                name: "Profile",
                to: "profile",
              },
            ],
          },
        ],
      },
    };
  },
};
</script>