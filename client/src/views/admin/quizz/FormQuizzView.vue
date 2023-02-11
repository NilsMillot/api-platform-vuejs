<template>
  <div class="container">
    <div class="row">
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
          <List />
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "@vue/reactivity";
import List from '../quizz/ListQuizzView.vue';

import { useRoute, useRouter } from "vue-router";

const question = reactive({
  name: "",
  firstAnswer: "",
  secondAnswer: "",
  correctAnswer: 1,
});

const message = ref("");


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
            quizz : `/quizzs/1`
        }),
      }
    );
    if (!response.ok) {
      const data = await response.json();
      console.log(data);
     
    //   message.value =
    //     "Veuillez remplir tous les champs. La date doit être supérieur à celle d'aujourd'hui";
      throw new Error("Une erreur est survenue dans le formulaire.");
    } else {
      
    //   message.value = "Votre quizz a bien été créé.";
    //   quizz = reactive({
    //     name: "",
    //     date: "",
    //   });
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
