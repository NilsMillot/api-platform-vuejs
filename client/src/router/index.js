import { createRouter, createWebHistory } from "vue-router";
import MovieView from "../views/MovieView.vue";
import HomeView from "../views/HomeView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import BookingView from "../views/cinema/BookingView.vue";

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
      path: "/movie",
      name: "movie",
      component: MovieView,
    },
    {
      path: "/booking",
      name: "booking",
      component: BookingView,
    },
  ],
});

export default router;
