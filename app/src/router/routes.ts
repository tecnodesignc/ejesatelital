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
    path: 'auth/',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: 'login',
        component: () => import('modules/user/page/Login.vue')
      },
      {
        path: 'register',
        component: () => import('modules/user/page/Register.vue')
      },
      {
        path: 'reset-password',
        component: () => import('modules/user/page/ResetPassword.vue')
      },
      {
        path: 'complete-password',
        component: () => import('modules/user/page/CompletePassword.vue')
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
