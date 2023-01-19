<script setup>
import Seance from '../../components/Seance.vue';
import SeanceBanner from '../../components/SeanceBanner.vue';
import {onUpdated, reactive, ref} from 'vue'
const result = reactive({value:[]})
onUpdated( async () => {
  await fetchMovies();
})


const fetchMovies = async () => {
    return fetch(`https://api.themoviedb.org/3/search/movie?api_key=4d3df75e4b4f46885d6f1504e09d1808&query=${search.value}`)
    .then(response => response.json())
    .then(data => result.value = data.results);
};

</script>

<template>
  <main>
    <div class="container mt-2">
      <div class="d-flex title">
          <h1 class="flex-shrink-0">Séances</h1>
          <p class="flex-grow-1 ms-2 m-auto fs-5">- Toutes nos séances</p>
      </div>
      <SeanceBanner/>
      <Seance/>
      </div>
  </main>
</template>


<style scoped>

.title {
  color: var(--color-white);
}
</style>