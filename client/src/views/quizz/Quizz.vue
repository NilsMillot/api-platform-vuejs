<script setup>
import {onMounted, ref} from "vue";
import router from "@/router";

const quizz = ref(null);

const getQuizz = async () => {
  const quizzId = router.currentRoute.value.params.id;
  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs/${quizzId}`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
  );
  const data = await response.json();
  console.log(data);
  return data;
};

onMounted(async () => {
  quizz.value = await getQuizz();
});

</script>

<template>
  <div class="container" v-if="quizz">
    <h1 class="text-center text-white mb-5">{{ quizz.name }}</h1>
    <div v-for="question in quizz.questions" :key="question.id" class="card bg-dark mb-3">
      <div class="card-header text-white">{{ question.name }}</div>
      <div class="card-body text-white">
        <form>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="question1Option1" value="option1">
            <label class="form-check-label" for="question1Option1">{{ question.firstAnswer }}</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="question1Option2" value="option2">
            <label class="form-check-label" for="question1Option2">{{ question.secondAnswer }}</label>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-cinemax-primary">Envoyer les réponses</button>
    </div>
  </div>
</template>

<style scoped>
.form-check-input {
  cursor: pointer;
}
</style>
