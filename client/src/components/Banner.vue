<script setup>
import { reactive, ref, onMounted, watch } from "vue";
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

watch(result, async (newResult) => {
  if (newResult.value) {
    await fetch(
      `https://api.themoviedb.org/3/tv/${newResult.value.id}/videos?api_key=${
        import.meta.env.VITE_TMDB_API_KEY
      }&language=en-US`
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.results.length > 0) {
          const trailer = data.results.find(
            (item) =>
              (item.type === "Trailer" ||
                item.type === "Teaser" ||
                item.type === "Clip" ||
                item.type === "Featurette") &&
              item.site === "YouTube"
          );
          if (trailer) {
            newResult.value.trailer = trailer.key;
          }
        }
      });
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
        'background-image':
          'linear-gradient(to right, rgba(0,0,0,1) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%), url(' +
          imageBackdropPath +
          ')',
        backgroundSize: 'cover',
        backgroundPosition: 'center',
      }"
    >
      <h1>{{ result.value.name }}</h1>
      <h2>{{ result.value.overview }}</h2>
      <a
        class="btn btn-cinemax-primary"
        v-if="result.value.trailer"
        target="_blank"
        :href="`https://youtube.com/watch?v=${result.value.trailer}`"
        >A découvrir</a
      >
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
