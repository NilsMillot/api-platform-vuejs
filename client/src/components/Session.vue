<template>

    <div class="row mt-4">
            <div class="card m-2 shadow-sm card-global">
                <div class="card-body m-2">
                    <div class="d-flex">
                        <div><img class="movie-picture" :src="`https://image.tmdb.org/t/p/original${result.value.backdrop_path}`"></div> 
                        <div>
                            <div class="mx-4">
                                <h4 class="card-title">{{result.value.title}}</h4>
                                <h5 class="card-subtitle mb-2 text-muted">Le Grand Rex</h5>
                                <!-- <p class="card-subtitle mb-2 text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo excepturi recusandae accusamus corporis tempore, similique voluptatibus dolorem aperiam, expedita aliquam ipsum, exercitationem modi quidem ipsa nihil sit vero harum cumque?</p> -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="session mt-4">
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
                        <a href="/reservation" class="card-link">
                            <div class="card card-datetime">
                                <h5>date</h5>
                                <h6>heure</h6>
                                <p>VF</p>
                            </div>
                        </a>
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
