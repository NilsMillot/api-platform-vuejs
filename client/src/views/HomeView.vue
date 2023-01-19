<script setup>
import Banner from '../components/Banner.vue';
import List from '../components/List.vue';
import MovieCard from "./MovieCard.vue";
import {watch, reactive, ref} from 'vue'

const search = ref("");
const result = reactive({value:[]})

watch(search, async (newSearch) => {
  await fetch(`https://api.themoviedb.org/3/search/multi?api_key=4d3df75e4b4f46885d6f1504e09d1808&query=${newSearch}&language=fr`)
    .then(response => response.json())
    .then(data => result.value = data.results);
  
})
</script>
<template>
  <main>
    <Banner/>
    <div class="container input-group mb-3 mt-5 w-50">
      <input type="text" v-model="search" class="form-control" placeholder="Recherchez un film, un artiste...">
    </div>

    <div v-if="!search">
      <List title="Tendances actuelles" url="https://api.themoviedb.org/3/trending/all/week?api_key=4d3df75e4b4f46885d6f1504e09d1808" />
      <List title="Programmes originaux" url="https://api.themoviedb.org/3/discover/tv?api_key=4d3df75e4b4f46885d6f1504e09d1808&with_networks=213&language=fr"  />
      <List title="Films d'action" url="https://api.themoviedb.org/3/discover/movie?with_genres=28&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  />
      <!-- <List title="Films d'horreur" url="https://api.themoviedb.org/3/discover/movie?with_genres=27&language=fr&api_key=4d3df75e4b4f46885d6f1504e09d1808"  /> -->
    </div>

    <div v-else>
      <div>
        <div class="row mt-5">
            <h2 class="mx-3">{{result.value?.length}} Résultat(s)</h2>
            <div class="list">
            <div v-for="(item, index) in result.value" :key=index >
                <div class="block">
                    <img v-if="item.backdrop_path" class="listElements" :src="`https://image.tmdb.org/t/p/original${item.backdrop_path}`" >
                    <img v-else class="listElements" src="../assets/movie.jpg" >
                </div>
            </div>
            </div>
        </div>
      </div>
    </div>
    <!-- <Suspense fallback="Loading...">
      <MovieCard />
    </Suspense> -->
  </main>
</template>


<style scoped>
input {
  border-radius: 15px;
  border:1px solid var(--color-black);
  padding-left:2em;
  background-color: #ffffff30;
}
h2{
    font-size:16px;
    color: var(--color-white);
}

.list{

    display: flex;
    overflow-x: scroll;
    padding: 20px;
}

.listElements{

    width: 11.5rem;
    max-height: 100px;
    object-fit: cover;
    border-radius: 4px;
    transition: all 1s;

}


.listElements:hover{
    transform: scale(1.05);
}

.block {

    width: 11.5rem;
    max-height: 100px;
    margin-right: 10px;
    position: relative;
}

.list::-webkit-scrollbar{
    display: none;
}

</style>