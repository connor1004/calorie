import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);

// configure router
const router = new VueRouter({
  mode: 'history',
  routes, // short for routes: routes
  linkActiveClass: 'active',
  scrollBehavior: (to, from ,savedPosition) => {
    if (savedPosition) {
      return savedPosition;
    }
    if (to.hash) {
      return { selector: to.hash };
    }
    return { x: 0, y: 0 };
  }
});


// https://router.vuejs.org/guide/advanced/meta.html
// https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
router.beforeEach(async (to, from, next) => {
  // From the docs link above:
  // First, each route object in the routes configuration is called a route record.
  // Route records may be nested.
  // Therefore when a route is matched, it can potentially match more than one route record.
  // So here we check if the route has a meta field that has requiresAuth
  // If yes -> check for token and next()
  // If no -> redirect to login
  let isAuthenticated = localStorage.getItem("access_token");

  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.

    if (isAuthenticated) {
      next();
    } else {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    }
  } else {
    if (isAuthenticated) {
      next({
        path: "/dashboard"
      });
    } else {
      next();
    }
  }
});

export default router;
