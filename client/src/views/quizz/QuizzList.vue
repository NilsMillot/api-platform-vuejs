<script setup>
import {onMounted, ref} from "vue";

const activeQuizzs = ref([]);

const getActiveQuizzList = async () => {
  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
  );
  const data = await response.json();
  const quizzList = data["hydra:member"];

  const activeQuizzList = quizzList.filter(quizz => {
    const endDate = new Date(quizz.endDate);
    const now = new Date();
    return endDate > now;
  });

  return activeQuizzList;
};

onMounted(async () => {
  activeQuizzs.value = await getActiveQuizzList();
});

</script>

<template>
  <div class="container my-5">
    <h1 class="text-center text-white mb-5">Liste de Quizz</h1>
    <div v-if="activeQuizzs !== null && activeQuizzs.length === 0" class="text-center">
      <h3 class="text-white">Aucun quizz n'est disponible pour le moment</h3>
    </div>
    <ul class="list-group" v-if="activeQuizzs !== null && activeQuizzs.length > 0">
      <li v-for="quizz in activeQuizzs" :key="quizz.id" class="list-group-item d-flex justify-content-between align-items-center">
        {{ quizz.name }}
        <router-link :to="`/quizz/${quizz.id}`" class="btn btn-cinemax-primary">Jouer</router-link>
      </li>
    </ul>
  </div>
</template>

<style>
.container {
  background-color: #222222;
  padding: 50px;
}

.btn-danger {
  background-color: #e50914;
  border-color: #e50914;
}

.list-group-item {
  background-color: #333333 !important;
  color: white !important;
  border-color: #e50914;
}

.list-group-item:hover {
  background-color: #e50914;
  color: white;
}
</style>
