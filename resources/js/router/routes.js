function page(path) {
  return () => import( /* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [

  {
    path: '/',
    name: 'login',
    component: page('auth/login.vue')
  },

  {
    path: '/register',
    name: 'register',
    component: page('auth/register.vue')
  },

  {
    path: '/home',
    name: 'home',
    component: page('home.vue')
  },
  // {
  //   path: '/permissionList',
  //   name: 'permissionList',
  //   component: page('permissions/permissionList.vue')
  // },
  // {
  //   path: '/permissionCreate',
  //   name: 'permissionCreate',
  //   component: page('permissions/permissionCreate.vue')
  // },
  // {
  //   path: '/permissionEdit',
  //   name: 'permissionEdit',
  //   component: page('permissions/permissionEdit.vue')
  // },
  {

    path: '/userList',
    name: 'userList',
    component: page('users/userList.vue')
  },
  {
    path: '/userCreate',
    name: 'userCreate',
    component: page('users/userCreate.vue')
  },
  {
    path: '/userEdit',
    name: 'userEdit',
    component: page('users/userEdit.vue')
  },
  // {
  //   path: '/roleList',
  //   name: 'roleList',
  //   component: page('roles/roleList.vue')
  // },
  // {
  //   path: '/roleCreate',
  //   name: 'roleCreate',
  //   component: page('roles/roleCreate.vue')
  // },
  // {
  //   path: '/roleEdit',
  //   name: 'roleEdit',
  //   component: page('roles/roleEdit.vue')

  // },

  {
    path: '/sendMail',
    name: 'sendMail',
    component: page('mails/sendMail.vue')
  },
  {
    path: '/mailUser',
    name: 'mailUser',
    component: page('mails/mailList.vue')
  },
  {
    path: '/profile',
    name: 'profile',
    component: page('users/profile.vue')
  },
  {
    path: '*',
    component: page('errors/404.vue')
  }
]
