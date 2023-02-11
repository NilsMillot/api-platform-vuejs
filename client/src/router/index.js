import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/auth/Login.vue";
import RegisterView from "../views/auth/Register.vue";
import ForgetPasswordView from "../views/auth/ForgetPassword.vue";
import NewPasswordView from "../views/auth/NewPassword.vue";
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
import ConfirmCinemaAdmin from "../views/cinema/admin/ConfirmCinema.vue";
import QuizzListView from "../views/quizz/QuizzList.vue";
import NewSessionAdmin from "../views/admin/session/New.vue";
import ListSessionAdmin from "../views/admin/session/List.vue";
import EditSessionAdmin from "../views/admin/session/Edit.vue";
import AdminView from "../views/admin/AdminView.vue";
import AdminUsersView from "../views/admin/users/UsersView.vue";
import AdminUserView from "../views/admin/users/UserView.vue";



import AdminNewQuizzView from "../views/admin/quizz/NewQuizzView.vue"
import AdminListQuizzView from "../views/admin/quizz/ListQuizzView.vue";
import AdminEditQuizzView from "../views/admin/quizz/EditQuizzView.vue";
import AdminFormQuizzView from "../views/admin/quizz/FormQuizzView.vue";
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
      path: "/new-password",
      name: "new-password",
      component: NewPasswordView,
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
      query: { id: Number },
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
      path: "/admin",
      name: "admin",
      component: AdminView,
    },

    {
      path: "/admin/users",
      name: "admin-users",
      component: AdminUsersView,
    },

    // admin users with id
    {
      path: "/admin/users/:id",
      name: "admin-users-id",
      query: { id: Number },
      component: AdminUserView,
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
      query: { id: Number },
      component: EditSessionAdmin,
    },
    {
      path: "/admin/cinema/confirm",
      name: "admin-cinema-confirm",
      component: ConfirmCinemaAdmin,
    },

    {
      path: "/admin/quizz/new",
      name: "admin-quizz-new",
      component: AdminNewQuizzView,
    },

    {
      path: "/admin/quizz/list",
      name: "admin-quizz-list",
      component: AdminListQuizzView,
    },
    {
      path: "/admin/quizz/edit/:id",
      name: "admin-quizz-edit",
      query: { id: Number },
      component: AdminEditQuizzView,
    },

    {
      path: "/admin/quizz/:id/form",
      name: "admin-quizz-form",
      query: { id: Number },
      component: AdminFormQuizzView,
    },

    {
      path: "/quizz-list",
      name: "quizz-list",
      component: QuizzListView,
    },
    {
      path: "/:catchAll(.*)",
      name: "Not Found",
      component: NotFoundView,
    },
  ],
});

export default router;
