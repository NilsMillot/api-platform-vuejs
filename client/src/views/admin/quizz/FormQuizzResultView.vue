<template>
  <div class="container mt-5" v-if="!shouldOfuscate">
    <h1>Résultats pour le quizz</h1>
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">Utilisateurs</th>
          <th scope="col">Score</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(value, index) in results.value" :key="index">
          <td>{{ value.participant.email }}</td>
          <td>{{ value.score }} / {{ questions.value.length }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { inject, watchEffect, ref, onMounted, reactive } from "vue";
import { useRoute, useRouter } from "vue-router";

const shouldOfuscate = ref(true);
const currentUser = inject("currentUser");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_ADMIN")) {
      shouldOfuscate.value = false;
    } else if (
      currentUser.roles?.includes("ROLE_USER") ||
      currentUser.roles?.includes("ROLE_CINEMA")
    ) {
      location.href = "/";
    }
  } else {
    location.href = "/";
  }
});

const $route = useRoute();
const router = useRouter();

const results = reactive({ value: [] });
const questions = reactive({ value: [] });

onMounted(async () => {
  await fetchQuestions();
  await fetchResults();
});

const fetchQuestions = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/questions`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.ok) {
      const data = await response.json();
      questions.value = data["hydra:member"].filter(
        (x) => x.quizz.id == $route.params.id
      );
    } else {
      const data = await response.json();
      console.log(data);
      throw new Error("Erreur");
    }
  } catch (error) {
    console.log(error);
  }
};

const fetchResults = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizz-results`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.ok) {
      const data = await response.json();
      results.value = data["hydra:member"].filter(
        (x) => x.quizz.id == $route.params.id
      );
    } else {
      const data = await response.json();
      throw new Error("Erreur");
    }
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped>
h1 {
  color: white;
}
</style>
