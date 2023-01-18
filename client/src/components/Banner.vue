<template>
    <div class="banner">
        <div class="bannerContent" v-bind:style="{ backgroundImage : `url(https://image.tmdb.org/t/p/original${result.value.backdrop_path})`, backgroundSize: 'cover',backgroundPosition:'center'}" >
            <h1>{{result.value.name}}</h1>
            <h2>{{result.value.overview}}</h2>
        </div>
    </div>
</template>


<script setup>
import { reactive } from "vue";
import { onMounted } from "@vue/runtime-core";

const result = reactive({value: []});

onMounted( async () => {
    await fetchMovies();
    console.log(result.value)
})


const fetchMovies = async () => {
    return fetch(`https://api.themoviedb.org/3/discover/tv?api_key=4d3df75e4b4f46885d6f1504e09d1808&with_networks=213&language=fr`)
    .then(response => response.json())
    .then(data => result.value = data.results[Math.floor(Math.random() * data.results.length)]);
}

</script>



<style scoped>
.banner{
    height: 550px;
    color: var(--color-white);
}

.bannerContent{
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