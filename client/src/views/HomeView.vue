<script setup>
import Banner from '../components/Banner.vue';
import List from '../components/List.vue';
import MovieCard from "./MovieCard.vue";
</script>
<template>
  <main>
    <Banner/>
    <List title="Tendances actuelles" url="https://api.themoviedb.org/3/trending/all/week?api_key=4d3df75e4b4f46885d6f1504e09d1808" />
    <List title="Programmes originaux" url="https://api.themoviedb.org/3/discover/tv?api_key=4d3df75e4b4f46885d6f1504e09d1808&with_networks=213&language=fr"  />
    <List title="Films d'action" url="https://api.themoviedb.org/3/discover/movie?with_genres=28&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  />
    <List title="Films d'horreur" url="https://api.themoviedb.org/3/discover/movie?with_genres=27&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  />
    <!-- <Suspense fallback="Loading...">
      <MovieCard />
    </Suspense> -->
  </main>
</template>
