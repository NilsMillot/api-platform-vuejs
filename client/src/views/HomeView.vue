<script setup lang="ts">
import MovieCard from "./MovieCard.vue";
</script>

<template>
  <main>
    <span>Welcome to CINEMAX !</span>
    <!-- TODO: Remove this suspens and pass the movie as a prop -->
    <Suspense fallback="Loading...">
      <MovieCard />
    </Suspense>
  </main>
</template>
