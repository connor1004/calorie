import DashboardLayout from '../views/Layout/DashboardLayout.vue';
import AuthLayout from '../views/Auth/AuthLayout.vue';

import NotFound from '../views/NotFoundPage.vue';

const routes = [
  {
    path: '/',
    redirect: 'My Food Entries',
    component: DashboardLayout,
    children: [
      {
        path: '/dashboard',
        name: 'My Food Entries',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "demo" */ '../views/MyFoodEntries.vue'),
        meta: {
          requiresAuth: true,
        }
      },
      {
        path: '/daily-food-consumption',
        name: 'Daily Food Consumption',
        component: () => import(/* webpackChunkName: "demo" */ '../views/DailyFoodConsumption.vue'),
        meta: {
          requiresAuth: true,
        }
      },
      {
        path: '/all-food-entries',
        name: 'All Food Entries',
        component: () => import(/* webpackChunkName: "demo" */ '../views/AllFoodEntries.vue'),
        meta: {
          requiresAuth: true,
        }
      },
      {
        path: '/report',
        name: 'Report',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Report.vue'),
        meta: {
          requiresAuth: true,
        }
      },
    ]
  },
  {
    path: '/',
    redirect: 'login',
    component: AuthLayout,
    children: [
      {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Auth/Login.vue')
      },
      {
        path: '/register',
        name: 'register',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Auth/Register.vue')
      },
      { path: '*', component: NotFound }
    ]
  }
];

export default routes;
