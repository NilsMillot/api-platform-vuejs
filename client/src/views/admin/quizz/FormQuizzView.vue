<template>
  <div class="container" v-if="!shouldOfuscate">
    <div class="row">
      <div v-if="message != ''" class="alert alert-dark mt-2" role="alert">
        {{ message }}
      </div>
      <div class="col-md-6">
        <div class="card card-form shadow-sm">
          <form @submit.prevent="handleSubmit">
            <div>
              <h3 class="pt-3">Créer une question</h3>
              <hr />
            </div>
            <div class="card-body">
              <div class="form-group mt-3">
                <input
                  type="text"
                  placeholder="Nom de la question"
                  class="form-control"
                  required
                  v-model="question.name"
                />
              </div>
              <div class="d-flex justify-content-between flex-wrap">
                <div class="form-group mt-3">
                  <input
                    type="text"
                    placeholder="Réponse 1"
                    class="form-control"
                    v-model="question.firstAnswer"
                    required
                  />
                </div>
                <div class="form-group mt-3">
                  <input
                    type="text"
                    placeholder="Réponse 2"
                    class="form-control"
                    v-model="question.secondAnswer"
                    required
                  />
                </div>
              </div>
              <div class="form-group mt-3">
                <select v-model="question.correctAnswer" class="form-select">
                  <option value="1">Réponse 1</option>
                  <option value="2">Réponse 2</option>
                </select>
              </div>

              <div class="d-flex justify-content-center">
                <button class="btn btn-sm btn-cinemax mt-4" type="submit">
                  <span>Enregistrer</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <ListQuestion @deleteQuestion="deleteQuestion" :questions="questions" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref, inject, watchEffect } from "vue";
import ListQuestion from "../../../components/admin/quizz/ListQuestionForm.vue";
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

const question = reactive({
  name: "",
  firstAnswer: "",
  secondAnswer: "",
  correctAnswer: 1,
});

const $route = useRoute();
const router = useRouter();

const questions = reactive({ value: [] });
const message = ref("");

onMounted(async () => {
  await fetchQuestions();
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

const deleteQuestion = async (id) => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/questions/${id}`,
      {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.ok) {
      message.value = "La question a bien été supprimée.";
      let found = questions.value.findIndex((e) => e.id == id);
      questions.value.splice(found, 1);
    } else {
      const data = await response.json();
      message.value = data["hydra:description"];
    }
  } catch (error) {
    console.log(error);
  }
};

const handleSubmit = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/questions`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify({
          name: question.name,
          firstAnswer: question.firstAnswer,
          secondAnswer: question.secondAnswer,
          correctAnswer: parseInt(question.correctAnswer),
          quizz: `/quizzs/${$route.params.id}`,
        }),
      }
    );
    if (!response.ok) {
      const data = await response.json();
      message.value = data["hydra:description"];
      throw new Error("Une erreur est survenue dans le formulaire.");
    } else {
      const data = await response.json();
      questions.value.push(data);
      message.value = "La question a bien été créé.";
    }
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped>
.card-form {
  margin: 150px auto auto;
  padding: 20px;
  background-color: var(--color-black);
  color: var(--color-white);
  border-radius: 10px;
}

.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
</style>
