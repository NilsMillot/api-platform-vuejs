<template>
    <div>
        <div class="row mt-5">
            <h2 class="mx-3">{{props.title}}</h2>
            <div class="list">
            <div v-for="(item, index) in result.value" :key=index >
                <div class="block">
                    <img class="listElements" :src="`https://image.tmdb.org/t/p/original${item.poster_path}`" >
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue"
import { reactive } from 'vue';

const props = defineProps({
    title : String,
    url : String
})

const result = reactive({value : []})

onMounted( async () => {
    await fetchMovies();

})
const fetchMovies = ( async () => {
    return fetch(props.url)
    .then(response => response.json())
    .then(data => result.value = data.results);
})

</script>


<style scoped>

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
