<script setup>
import Banner from '../components/Banner.vue';
import List from '../components/List.vue';
import MovieCard from "./MovieCard.vue";
import {onUpdated, reactive, ref} from 'vue'

const search = ref("");
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
    <Banner/>


    <div class="container input-group mb-3 mt-5 w-50">
      <input type="text" v-model="search" class="form-control" placeholder="Recherchez un film...">
    </div>
    <List title="Tendances actuelles" url="https://api.themoviedb.org/3/trending/all/week?api_key=4d3df75e4b4f46885d6f1504e09d1808" />
    <List title="Programmes originaux" url="https://api.themoviedb.org/3/discover/tv?api_key=4d3df75e4b4f46885d6f1504e09d1808&with_networks=213&language=fr"  />
    <List title="Films d'action" url="https://api.themoviedb.org/3/discover/movie?with_genres=28&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  />
    <List title="Films d'horreur" url="https://api.themoviedb.org/3/discover/movie?with_genres=27&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  />
    <!-- <Suspense fallback="Loading...">
      <MovieCard />
    </Suspense> -->
  </main>
</template>


<style scoped>
input {
  border-radius: 15px;
}

</style>