import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import SeanceView from "../views/cinema/SeanceView.vue";
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
      path: "/seance",
      name: "seance",
      component: SeanceView,
    },
    {
      path: "/reservation",
      name: "reservation",
      component: ReservationView,
    },
  ],
});

export default router;
