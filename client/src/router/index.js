import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/auth/Login.vue'
import RegisterView from '../views/auth/Register.vue'
import ForgetPasswordView from '../views/auth/ForgetPassword.vue'
import UserAccountView from '../views/auth/UserAccount.vue'
import MovieView from "../views/MovieView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import New from "../views/cinema/admin/New.vue";
import List from "../views/cinema/admin/List.vue";
import BookingView from "../views/cinema/BookingView.vue";

import NewCinemaView from "../views/admin/cinema/New.vue";
import NewUserView from "../views/admin/user/NewUser.vue";
import NewSessionView from "../views/admin/session/NewSession.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/forget-password',
      name: 'forget-password',
      component: ForgetPasswordView
    },
    {
      path: '/user-account',
      name: 'user-account',
      component: UserAccountView
    },
    {
      path: "/session",
      name: "session",
      component: SessionView,
    },
    {
      path: "/movie",
      name: "movie",
      component: MovieView,
    },
    {
      path: "/cinema/session/new",
      name: "new-session",
      component: New,
    },
    {
      path: "/cinema/session",
      name: "cinema-session",
      component: List,
    },
    {
      path: "/booking",
      name: "booking",
      component: BookingView,
    },
    {
      path: "/admin/cinema/new",
      name: "admin-cinema-new",
      component: NewCinemaView,
    },

    {
      path: "/admin/user/new",
      name: "admin-user-new",
      component: NewUserView,
    },

    {
      path: "/admin/session/new",
      name: "admin-session-new",
      component: NewSessionView,
    },
  ],
});

export default router;
