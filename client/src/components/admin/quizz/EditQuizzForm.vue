<template>
  <div class="container">
    <div class="row">
      <div v-if="message != ''" class="alert alert-dark mt-2" role="alert">
        {{ message }}
      </div>

      <div class="d-flex justify-content-end mt-5">
        <router-link to="/admin/quizz/list" class="btn-sm btn btn-cinemax"
          >Voir les Quiz</router-link
        >
      </div>
      <div class="card card-quizz shadow-sm">
        <form @submit.prevent="handleSubmit">
          <div>
            <h3 class="pt-3">Modifier un QUIZ</h3>
            <hr />
          </div>
          <div class="card-body">
            <div class="form-group mt-3">
              <input
                type="text"
                placeholder="Nom"
                class="form-control"
                v-model="quizz.name"
                required
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="date"
                class="form-control"
                required
                v-model="quizz.date"
              />
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
  </div>
</template>

<script setup>
import { watch, reactive, ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const $route = useRoute();
const router = useRouter();

let quizz = reactive({
  name: "",
  date: "",
});

const message = ref("");

onMounted(async () => {
  const { params } = useRoute();
  const { id } = params;
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs/${id}`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (!response.ok) {
       
      router.push("/admin/quizz/list");
      throw new Error("Une erreur est survenue.");
    } else {
      const data = await response.json();
      quizz.name = data.name;
      quizz.date = data.endDate.split("T")[0];
    }
  } catch (error) {
    console.log(error);
  }
});

const handleSubmit = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs/${$route.params.id}`,
      {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify({
          endDate: quizz.date,
          name: quizz.name,
        }),
      }
    );
    if (!response.ok) {
      const data = await response.json();
      console.log(data);
      message.value = data['hydra:description'];
      throw new Error("Une erreur est survenue dans le formulaire.");
    } else {
      message.value = "Votre quizz a bien été modifié.";
    }
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped>
.card-quizz {
  width: 450px;
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
