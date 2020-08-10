import { RouteConfig } from 'vue-router';
import LoginComponent from '../login/login.component';
import SignupComponent from '../signup/signup.component';

export const AuthenticationRoutes: Array<RouteConfig> = [
  {
    path: '/login',
    name: 'Login',
    component: LoginComponent
  },
  {
    path: '/signup',
    name: 'Signup',
    component: SignupComponent
  }
];
