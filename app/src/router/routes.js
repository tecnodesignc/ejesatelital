const routes = [
  {
    path: '/',
    meta: {requireAuth: true},
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'app.home',
        component: () => import('pages/Index.vue')
      }
    ],
  },
  {
    path: '/auth',
    meta: {requireAuth: false},
    name: 'auth',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: '/auth/login',
        name: 'auth-login',
        component: () => import('src/modules/user/pages/auth/Login.vue')
      },
      {
        path: '/auth/register',
        name: 'auth-register',
        component: () => import('src/modules/user/pages/auth/Register.vue')
      },
      {
        path: '/auth/reset-password',
        name: 'auth-reset-password',
        component: () => import('src/modules/user/pages/auth/Recover.vue')
      },
      {
        path: '/auth/complete-password',
        name: 'auth-complete-password',
        component: () => import('src/modules/user/pages/auth/Reset.vue')
      }
    ]
  },
  {
    path: '/users',
    meta: {
      requireAuth: true
    },
    name: 'users',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/users',
        name: 'user.index',
        component: () => import('src/modules/user/pages/users/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/users/create',
        name: 'user.create',
        component: () => import('src/modules/user/pages/users/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/users/edit/:id',
        name: 'user.edit',
        component: () => import('src/modules/user/pages/users/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/roles',
    meta: {
      requireAuth: true
    },
    name: 'role',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/roles',
        name: 'role.index',
        component: () => import('src/modules/user/pages/roles/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/roles/create',
        name: 'role.create',
        component: () => import('src/modules/user/pages/roles/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/roles/edit/:id',
        name: 'role.edit',
        component: () => import('src/modules/user/pages/roles/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue'),
    meta: {requireAuth: false},
  }
]

export default routes
