<script setup>
import { reactive, ref, onMounted } from "vue";
import {
  getImageFromSrc,
  getUrlDiscoverTVWithNetwork,
} from "../utils/tmdbCalls";

const result = reactive({ value: [] });
const imageBackdropPath = ref("");

onMounted(async () => {
  await fetchMovies();
  if (result.value.backdrop_path) {
    imageBackdropPath.value = getImageFromSrc(result.value.backdrop_path);
  }
});

const fetchMovies = async () => {
  return fetch(getUrlDiscoverTVWithNetwork(213))
    .then((response) => response.json())
    .then(
      (data) =>
        (result.value =
          data.results[Math.floor(Math.random() * data.results.length)])
    );
};
</script>

<template>
  <div class="banner">
    <div
      class="bannerContent"
      v-bind:style="{
        backgroundImage: `url(${imageBackdropPath})`,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
      }"
    >
      <h1>{{ result.value.name }}</h1>
      <h2>{{ result.value.overview }}</h2>
    </div>
  </div>
</template>

<style scoped>
.banner {
  height: 550px;
  color: var(--color-white);
}

.bannerContent {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  padding-left: 30px;
  height: 100%;
}

.bannerContent h1 {
  text-transform: uppercase;
  font-size: 2em;
  font-weight: 800;
  margin: 0;
}

.bannerContent h2 {
  font-size: 1.1em;
  width: 25rem;
}
</style>
