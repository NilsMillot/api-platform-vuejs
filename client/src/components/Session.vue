<template>
    <div>
        <div class="row mt-4" v-for="(movie,i) in movies" :key="i">
                <div class="card m-2 shadow-sm card-global">
                    <div class="card-body m-2">
                        <div class="d-flex">
                            <div><img class="movie-picture" :src="getImageFromSrc(movie.details.backdrop_path)"></div> 
                            <div>
                                <div class="mx-4">
                                    <h4 class="card-title">{{movie.details.title}}</h4>
                                    <!-- <h5 class="card-subtitle mb-2 text-muted">Le Grand Rex</h5> -->
                                    <p class="card-subtitle mb-2 text-muted">{{movie.details.overview}}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session mt-4">
                            <a :href="'/booking?id=' + session.id" class="card-link" v-for="(session,i) in movie.sessions" :key="i">
                                <div class="card card-datetime">
                                    <h6>{{session.sessionDatetime.split("T")[0]}}</h6>
                                    <h6>{{session.sessionDatetime.split("T")[1].substr(0,5)}}</h6>
                                    <h6>VF</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { reactive,ref } from 'vue';
import {
    getImageFromSrc,
} from "../utils/tmdbCalls";

const result = reactive({value : []})
const movie = reactive({value : []})
const movies = ref([])

onMounted( async () =>{
    await fetchSessions();

    // Date supérieur > NOW
    result.value = result.value.filter(i => new Date(i.sessionDatetime) > new Date());
    // Remplacer
    result.value = result.value.filter(i => i.creator == "/users/1");

    // Tableau de film unique
    let unique =  result.value.filter((item, index, self) => self.findIndex(t => t.movieId === item.movieId) === index);

    for (let i = 0; i < unique.length; i++){
        await fetchMovie(unique[i].movieId);
        let sessions = result.value.filter( j => j.movieId == unique[i].movieId);
        movies.value.push( {
            "details" : movie.value,
            "sessions" : sessions
        });
    }
   
})

const fetchMovie = async (id) => {
    
    return fetch(`https://api.themoviedb.org/3/movie/${id}?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&language=fr`)
    .then((response) => response.json())
    .then((data) => {movie.value = data});
}

const fetchSessions = async () => {
    return fetch('https://localhost/movie_screenings')
    .then((response) => response.json())
    .then((data) => (result.value = data['hydra:member']));
}
</script>


<style scoped>

.input-search {
  border-radius: 15px;
  border: 1px solid var(--color-black);
  padding-left: 2em;
  background-color: #ffffff30;
}
.card-global{
    width: 100%;
    height: auto;
    border-radius: 10px;
    background-color: #181818;
    color: var(--color-white);
}
.movie-picture{
    width: 200px;
    object-fit: cover;
    border-radius: 5px;
}

.card-datetime{
    display: flex;
    height: 100px;
    width: 150px;
    padding: 12px;
    border-radius: 5px;
    background-color: #2f2f2f;
    color: var(--color-white);
    text-decoration: none;
    font-size: 12px;
}
.session{
    display: flex;
    overflow-x: scroll;
}
.card-link{
    text-decoration: none;
}

</style>
