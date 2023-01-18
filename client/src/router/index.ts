import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/auth/Login.vue'
import RegisterView from '../views/auth/Register.vue'
import ForgetPasswordView from '../views/auth/ForgetPassword.vue'
import UserAccountView from '../views/auth/UserAccount.vue'

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
  ]
})

export default router;
