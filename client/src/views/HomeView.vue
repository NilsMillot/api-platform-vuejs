<script setup>
import Banner from '../components/Banner.vue';
import MovieCard from "./MovieCard.vue";
</script>
<template>
  <main>
    <Banner/>
    <span>Welcome to CINEMAX !</span>
    <Suspense fallback="Loading...">
      <MovieCard />
    </Suspense>
  </main>
</template>
