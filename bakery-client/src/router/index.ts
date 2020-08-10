import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import { AuthenticationRoutes } from '@/views/authentication/routes/authentication.routes';
import { AccountRoutes } from '@/views/account/routes/account.routes';
import HomeComponent from '@/views/home/home.component';
import { ApiAuth, CoreService } from '@/sdk';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'Home',
    component: HomeComponent
  },
  ...AuthenticationRoutes,
  ...AccountRoutes
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  // Hide snackbar
  CoreService.Instance.AlertMode = false;

  // Get current user from cookie.
  const isUserLoggedIn =
    ApiAuth.Instance.SessionValue && !!ApiAuth.Instance.SessionValue!.Id;
  const isNonAuthRoute = ['Login', 'Signup'].includes(to.name!);
  const isStaticRoute = ['Home'].includes(to.name!);

  // Perform Authentication
  if (isStaticRoute) {
    next();
  } else if (!isUserLoggedIn && isNonAuthRoute) {
    next();
  } else if (isUserLoggedIn && isNonAuthRoute) {
    next({ name: 'Products' });
  } else if (!isUserLoggedIn && !isNonAuthRoute) {
    next({ name: 'Login' });
  } else {
    next();
  }
});

export default router;
