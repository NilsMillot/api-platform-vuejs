<script setup>
// TODO: Movie will be a prop passed from the home view and not a call like this
const data = await fetch(
  `https://api.themoviedb.org/3/movie/550?api_key=${
    import.meta.env.VITE_TMDB_API_KEY
  }`
);
const movie = await data.json();
const poster_fetched = await fetch(
  `https://image.tmdb.org/t/p/w500${movie.poster_path}`
);
movie.poster_path = poster_fetched.url;
const { title, poster_path } = movie;
console.log(movie);
</script>

<template>
  <div class="card" style="width: 18rem">
    <!-- <img class="card-img-top" src="..." alt="Card image cap" /> -->
    <!-- Pass the movie data to img -->
    <img v-bind:alt="title" v-bind:src="poster_path" class="card-img-top" />
  </div>
</template>
