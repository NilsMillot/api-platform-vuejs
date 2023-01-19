<template>

    <div class="row mt-4">
            <div class="card m-2 shadow-sm card-global">
                <div class="card-body d-flex m-2">
                    <div class="d-flex">
                        <div><img class="movie-picture" :src="`https://image.tmdb.org/t/p/original${result.value.backdrop_path}`"></div> 
                        <div>
                            <div style="margin:20px;">
                                <h4 class="card-title">Title</h4>
                                <h6 class="card-subtitle mb-2 text-muted">Cinéma</h6>
                            </div>
                            <div class="seance">
                                <a href="/reservation" class="card-link">
                                    <div class="card m-2 card-datetime">
                                        <h5>date</h5>
                                        <h6>heure</h6>
                                        <p>VF</p>
                                    </div>
                                </a>
                                <a href="/reservation" class="card-link">
                                    <div class="card m-2 card-datetime">
                                        <h5>date</h5>
                                        <h6>heure</h6>
                                        <p>VF</p>
                                    </div>
                                </a>
                                <a href="/reservation" class="card-link">
                                    <div class="card m-2 card-datetime">
                                        <h5>date</h5>
                                        <h6>heure</h6>
                                        <p>VF</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { reactive } from 'vue';

const result = reactive({value : []})

onMounted( async () => {
    await fetchMovies();

})

const fetchMovies = ( async () => {
    return fetch(`https://api.themoviedb.org/3/movie/550?api_key=4d3df75e4b4f46885d6f1504e09d1808`)
    .then(response => response.json())
    .then(data => result.value = data);
})

</script>


<style scoped>
.card-global{
    width: 100%;
    height: auto;
    border-radius: 10px;
    background-color: #181818;
    color: var(--color-white);
    transition: all 1s;
    box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
}
.movie-picture{
    width: 250px;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    transition: all 1s;
}

.card-datetime{
    display: flex;
    height: 100px;
    width: 150px;
    padding: 12px;
    border-radius: 6px;
    background-color: #2f2f2f;
    color: var(--color-white);
    transition: all 1s;
    box-shadow: 0 0 5px 0 rgba(0,0,0,0.5);
    text-decoration: none;
    font-size: 12px;
}
.seance{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    width: 100%;
}
.card-link{
    text-decoration: none;
    margin-left: 10px;
}

</style>
