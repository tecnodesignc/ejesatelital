
const routes = [
  {
    path: '/',
    meta: {requireAuth: true },
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name:'app.home',
        component: () => import('pages/Index.vue')
      }
    ],
  },
  {
    path: '/auth',
    meta: {requireAuth: false},
    name:'auth',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: '/auth/login',
        name:'auth-login',
        component: () => import('src/modules/user/pages/auth/Login.vue')
      },
      {
        path: '/auth/register',
        name:'auth-register',
        component: () => import('src/modules/user/pages/auth/Register.vue')
      },
      {
        path: '/auth/reset-password',
        name:'auth-reset-password',
        component: () => import('src/modules/user/pages/auth/Recover.vue')
      },
      {
        path: '/auth/complete-password',
        name:'auth-complete-password',
        component: () => import('src/modules/user/pages/auth/Reset.vue')
      }
    ]
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue'),
    meta: {requireAuth: false },
  }
]

export default routes
