import {RouteRecordRaw} from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('pages/Index.vue')
      }
    ],
  },
  {
    path: '/auth',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: '/auth/login',
        component: () => import('src/modules/user/pages/auth/Login.vue')
      },
      {
        path: '/auth/register',
        component: () => import('src/modules/user/pages/auth/Register.vue')
      },
      {
        path: '/auth/reset-password',
        component: () => import('src/modules/user/pages/auth/Recover.vue')
      },
      {
        path: '/auth/complete-password',
        component: () => import('src/modules/user/pages/auth/Reset.vue')
      }
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue'),
  },
];

export default routes;
