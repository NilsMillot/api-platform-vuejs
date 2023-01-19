import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import ReservationView from "../views/cinema/ReservationView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/session",
      name: "session",
      component: SessionView,
    },
    {
      path: "/reservation",
      name: "reservation",
      component: ReservationView,
    },
  ],
});

export default router;
