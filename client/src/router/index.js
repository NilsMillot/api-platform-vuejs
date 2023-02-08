import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/auth/Login.vue";
import RegisterView from "../views/auth/Register.vue";
import ForgetPasswordView from "../views/auth/ForgetPassword.vue";
import UserAccountView from "../views/auth/UserAccount.vue";
import EnableAccountView from "../views/auth/EnableAccount.vue";
import MovieView from "../views/MovieView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import New from "../views/cinema/admin/New.vue";
import List from "../views/cinema/admin/List.vue";
import EditSessionCinema from "../views/cinema/admin/Edit.vue";
import BookingView from "../views/cinema/BookingView.vue";
import SuccessView from "../views/payment/Success.vue";
import NotFoundView from "../views/NotFoundView.vue";


import NewSessionAdmin from "../views/admin/session/New.vue";
import ListSessionAdmin from "../views/admin/session/List.vue";
import EditSessionAdmin from "../views/admin/session/Edit.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
      query: { message: String },
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
    },
    {
      path: "/forget-password",
      name: "forget-password",
      component: ForgetPasswordView,
    },
    {
      path: "/user-account",
      name: "user-account",
      component: UserAccountView,
    },
    {
      path: "/enable-account/:id",
      name: "enable-account",
      query: { token: String },
      component: EnableAccountView,
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
      path: "/cinema/session/list",
      name: "cinema-session-list",
      component: List,
    },
    {
      path: "/cinema/session/edit/:id",
      name: "cinema-session-edit",
      query: {id:Number},
      component: EditSessionCinema,
    },
    {
      path: "/booking",
      name: "booking",
      component: BookingView,
    },
    {
      path: "/payment/success",
      name: "payment",
      component: SuccessView,
    },

    {
      path: "/admin/session/new",
      name: "admin-session-new",
      component: NewSessionAdmin,
    },

    {
      path: "/admin/session/list",
      name: "admin-session-list",
      component: ListSessionAdmin,
    },

    {
      path: "/admin/session/edit/:id",
      name: "admin-session-edit",
      query: {id:Number},
      component: EditSessionAdmin,
    },



    {
      path: "/:catchAll(.*)",
      name: "Not Found",
      component: NotFoundView,
    },
  ],
});

export default router;
