import { createRouter, createWebHistory } from "vue-router";
import MovieView from "../views/MovieView.vue";
import HomeView from "../views/HomeView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import SessionCinema from "../views/SessionCinema.vue";
import SessionsCinema from "../views/SessionsCinema.vue";

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
      path: "/cinema/session/new",
      name: "new-session",
      component: SessionCinema,
    },

    {
      path: "/cinema/session",
      name: "cinema-session",
      component: SessionsCinema,
    },
  ],
});

export default router;
