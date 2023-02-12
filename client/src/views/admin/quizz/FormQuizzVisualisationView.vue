<template>
  <div class="container mt-5">
    <h1 class="text-center text-white mb-5">Votre Quiz : {{ quizz.value.name }}</h1>
    <div
      v-for="question in questions.value"
      :key="question.id"
      class="card bg-dark mb-3"
    >
      <div class="card-header text-white">{{ question.name }}</div>
      <div class="card-body text-white">
        <div class="d-flex">
          <div class="form-group me-5">
            <label for="">Réponse 1</label>
            <input
              class="form-control"
              :value="question.firstAnswer"
              disabled
            />
          </div>
          <div class="form-group me-5">
            <label for="">Réponse 2</label>
            <input
              class="form-control"
              :value="question.secondAnswer"
              disabled
            />
          </div>

          <div class="form-group">
            <label for="">Réponse attendue</label>
            <input
              class="form-control"
              :value="
                question.correctAnswer == 1
                  ? question.firstAnswer
                  : question.secondAnswer
              "
              disabled
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, reactive, ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const $route = useRoute();
const router = useRouter();
const questions = reactive({ value: [] });
const quizz = reactive({ value: [] });

onMounted(async () => {
  await fetchQuestions();
  await getQuizz();
 
});



const getQuizz = async () => {
  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs/${$route.params.id}`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
  );
  const data = await response.json();
  quizz.value = data;
};

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
      throw new Error("Erreur");
    }
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped></style>
