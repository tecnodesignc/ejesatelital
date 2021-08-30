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
        path: '/users/:id/edit',
        name: 'user.edit',
        component: () => import('src/modules/user/pages/users/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/profile',
    meta: {
      requireAuth: true
    },
    name: 'profile',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/personal',
        name: 'profile.personal',
        component: () => import('src/modules/user/pages/profile/Personal'),
        meta: {
          requireAuth: true
        },
      },
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
        path: '/roles/:id/edit',
        name: 'role.edit',
        component: () => import('src/modules/user/pages/roles/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/company',
    meta: {
      requireAuth: true
    },
    name: 'company',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/company',
        name: 'company',
        component: () => import('src/modules/company/_pages/account/front/Company'),
        meta: {
          requireAuth: true
        },
      },
    ]
  },
  {
    path: '/company/account-type',
    meta: {
      requireAuth: true
    },
    name: 'company.account-type',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/company/account-type',
        name: 'company.account-type.index',
        component: () => import('src/modules/company/_pages/accountType/Index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/account-type/create',
        name: 'company.account-type.create',
        component: () => import('src/modules/company/_pages/accountType/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/account-type/:id/edit',
        name: 'company.account-type.edit',
        component: () => import('src/modules/company/_pages/accountType/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/company/account',
    meta: {
      requireAuth: true
    },
    name: 'company.account',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/company/account',
        name: 'company.account.index',
        component: () => import('src/modules/company/_pages/account/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/account/create',
        name: 'company.account.create',
        component: () => import('src/modules/company/_pages/account/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/account/:id/edit',
        name: 'company.account.edit',
        component: () => import('src/modules/company/_pages/account/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/company/contact',
    meta: {
      requireAuth: true
    },
    name: 'company.contact',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/company/contact',
        name: 'company.contact.index',
        component: () => import('src/modules/company/_pages/contact/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/contact/create',
        name: 'company.contact.create',
        component: () => import('src/modules/company/_pages/contact/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/company/contact/:id/edit',
        name: 'company.contact.edit',
        component: () => import('src/modules/company/_pages/contact/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/vehicle/brand',
    meta: {
      requireAuth: true
    },
    name: 'vehicle.brand',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/vehicle/brand',
        name: 'vehicle.brand.index',
        component: () => import('src/modules/vehicle/_pages/brand/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/vehicle/brand/create',
        name: 'vehicle.brand.create',
        component: () => import('src/modules/vehicle/_pages/brand/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/vehicle/brand/:id/edit',
        name: 'vehicle.brand.edit',
        component: () => import('src/modules/vehicle/_pages/brand/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/vehicle/vehicles',
    meta: {
      requireAuth: true
    },
    name: 'vehicle.vehicle',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/vehicle/vehicle',
        name: 'vehicle.vehicle.index',
        component: () => import('src/modules/vehicle/_pages/vehicle/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/vehicle/vehicle/create',
        name: 'vehicle.vehicle.create',
        component: () => import('src/modules/vehicle/_pages/vehicle/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/vehicle/vehicle/:id/edit',
        name: 'vehicle.vehicle.edit',
        component: () => import('src/modules/vehicle/_pages/vehicle/edit.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/polls',
    meta: {
      requireAuth: true
    },
    name: 'poll',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/polls',
        name: 'polls.index',
        component: () => import('src/modules/polls/_pages/poll/index.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/polls/create',
        name: 'polls.create',
        component: () => import('src/modules/polls/_pages/poll/create.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/polls/:id/edit',
        name: 'polls.edit',
        component: () => import('src/modules/polls/_pages/poll/edit.vue'),
        meta: {
          requireAuth: true
        },
      },
      {
        path: '/polls/fill',
        name: 'polls.fill',
        component: () => import('src/modules/polls/_pages/front/Index.vue'),
        meta: {
          requireAuth: true
        }
      },
      {
        path: '/polls/question/:id/fill',
        name: 'polls.questions.fill',
        component: () => import('src/modules/polls/_pages/front/question/list.vue'),
        meta: {
          requireAuth: true
        },
      }
    ]
  },
  {
    path: '/History',
    meta: {
      requireAuth: true
    },
    name: 'history',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '/history/:id/view',
        name: 'history.view',
        component: () => import('src/modules/history/_pages/view.vue'),
        meta: {
          requireAuth: true
        },
      },
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
