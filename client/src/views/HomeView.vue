<script setup>
import { onUpdated, reactive, ref } from "vue";
import Banner from "../components/Banner.vue";
import List from "../components/List.vue";

import {
  getUrlDiscoverMovieFromGenre,
  getUrlDiscoverTVWithNetwork,
  getUrlTrendingAllWeek,
} from "../utils/tmdbCalls";

const search = ref("");
const result = reactive({ value: [] });
onUpdated(async () => {
  await fetchMovies();
});

const fetchMovies = async () => {
  return fetch(
    `https://api.themoviedb.org/3/search/movie?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&query=${search.value}`
  )
    .then((response) => response.json())
    .then((data) => (result.value = data.results));
};
</script>
<template>
  <main>
    <Banner />

    <div class="container input-group mb-3 mt-5 w-50">
      <input
        type="text"
        v-model="search"
        class="form-control"
        placeholder="Recherchez un film..."
      />
    </div>
    <List title="Tendances actuelles" :url="`${getUrlTrendingAllWeek()}`" />
    <List
      title="Programmes originaux"
      :url="`${getUrlDiscoverTVWithNetwork(213)}`"
    />
    <List title="Films d'action" :url="`${getUrlDiscoverMovieFromGenre(28)}`" />
    <List
      title="Films d'horreur"
      :url="`${getUrlDiscoverMovieFromGenre(27)}`"
    />
  </main>
</template>

<style scoped>
input {
  border-radius: 15px;
}
</style>
