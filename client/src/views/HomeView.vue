<script setup>
import { reactive, ref, watch } from "vue";
import Banner from "../components/Banner.vue";
import List from "../components/List.vue";
import SearchBar from "../components/SearchBar.vue";

import {
  getUrlDiscoverMovieFromGenre,
  getImageFromSrc,
  getUrlMovieBestRatedMovie,
} from "../utils/tmdbCalls";

const search = ref("");
const result = reactive({ value: [] });

const updateSearch = (e) => {
  search.value = e.target.value;
};

watch(search, async (newSearch) => {
  await fetch(
    `https://api.themoviedb.org/3/search/movie?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&query=${newSearch}&language=fr`
  )
    .then((response) => response.json())
    .then(
      (data) =>
        (result.value = data.results?.filter(
          (item) => item.backdrop_path && item.poster_path
        ))
    );
});
</script>
<template>
  <main>
    <Banner />

    <div class="container input-group mb-3 mt-5 w-50"></div>

    <SearchBar
      @customEvent="updateSearch"
      placeholder="Recherchez un film..."
    />

    <div v-if="!search" class="ListsPropositions">
      <List title="Les mieux notés" :url="`${getUrlMovieBestRatedMovie()}`" />
      <List
        title="Films d'action"
        :url="`${getUrlDiscoverMovieFromGenre(28)}`"
      />
      <List
        title="Films d'horreur"
        :url="`${getUrlDiscoverMovieFromGenre(27)}`"
      />
    </div>

    <div v-else class="ListsPropositions">
      <div>
        <div class="row mt-5">
          <h2 class="mx-3">{{ result.value?.length }} Résultat(s)</h2>
          <div class="list">
            <div v-for="(item, index) in result.value" :key="index">
              <a :href="`/movie?id=${item.id}`" class="block">
                <img
                  class="listElements"
                  :src="`${getImageFromSrc(
                    item.backdrop_path || item.poster_path
                  )}`"
                />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
input {
  border-radius: 15px;
  border: 1px solid var(--color-black);
  padding-left: 2em;
  background-color: #ffffff30;
}
h2 {
  font-size: 16px;
  color: var(--color-white);
}

.list {
  display: flex;
  overflow-x: scroll;
  padding: 20px;
}

.listElements {
  width: 14rem;
  object-fit: cover;
  border-radius: 4px;
  transition: all 1s;
}

.listElements:hover {
  transform: scale(1.2);
  z-index: 10;
}

.block {
  width: 11.5rem;
  max-height: 100px;
  margin-right: 10px;
  position: relative;
}

.list::-webkit-scrollbar {
  display: none;
}

.ListsPropositions {
  width: 97vw;
}
</style>
