import { createRouter, createWebHistory } from "vue-router";
import MovieView from "../views/MovieView.vue";
import HomeView from "../views/HomeView.vue";
import SessionView from "../views/cinema/SessionView.vue";
import New from "../views/cinema/admin/New.vue";
import List from "../views/cinema/admin/List.vue";

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
      component: New,
    },
    {
      path: "/cinema/session",
      name: "cinema-session",
      component: List,
    },
  ],
});

export default router;
