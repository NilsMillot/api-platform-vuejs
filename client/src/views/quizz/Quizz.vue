<script setup>
import {inject, onMounted, ref} from "vue";
import router from "@/router";

const currentUser = inject("currentUser");
const quizz = ref(null);
const questions = ref([]);
const message = ref('');
const shouldOfuscate = ref(false);

const getQuizz = async () => {
  const quizzId = router.currentRoute.value.params.id;
  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/single_quizz/${quizzId}`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
  );

  if (response.status === 404) {
    shouldOfuscate.value = true;
    message.value = "Ce quizz n'existe pas";
  } else {
    shouldOfuscate.value = false;
  }

  const data = await response.json();
  return data;
};

const sendAnswers = async () => {
  const answers = questions.value.map(question => {
    return {
      questionId: question.id,
      answer: question.userAnswer
    }
  })

  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizz_results`,
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          quizzId: quizz.value.id,
          answers
        }),
      }
  );
  const data = await response.json();

  if (response.status === 400 && data["hydra:description"] === "The input data is misformatted.") {
    message.value = "Vos réponses ne sont pas valides, vérifiez les avant de pouvoir envoyer";
  } else {
    message.value = data.message;
  }
};

onMounted(async () => {
  quizz.value = await getQuizz();
  questions.value = quizz.value.questions.map(question => {
    return {
      ...question,
      userAnswer: null
    }
  })
});

</script>

<template>
  <div class="container" v-if="quizz">
    <h1 class="text-center text-white mb-5">{{ quizz.name }}</h1>
    <div v-for="question in questions" :key="question.id" class="card bg-dark mb-3">
      <div class="card-header text-white">{{ question.name }}</div>
      <div class="card-body text-white">
        <div>
          <div class="form-check">
            <input class="form-check-input" type="radio" :name="`question${question.id}`" :id="`question${question.id}`" :value="1" v-model="question.userAnswer">
            <label class="form-check-label" :for="`question${question.id}`">{{ question.firstAnswer }}</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" :name="`question${question.id}`" :id="`question${question.id}`" :value="2" v-model="question.userAnswer">
            <label class="form-check-label" :for="`question${question.id}`">{{ question.secondAnswer }}</label>
          </div>
        </div>
      </div>
    </div>
    <span class="message">{{ message }}</span>
    <div class="text-center" v-if="!shouldOfuscate">
      <button @click="sendAnswers" class="btn btn-cinemax-primary">Envoyer les réponses</button>
    </div>
  </div>
</template>

<style scoped>
.form-check-input {
  cursor: pointer;
}

.message {
  color: white;
}
</style>
