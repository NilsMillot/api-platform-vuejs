<template>
  <div class="container mt-5">
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th scope="col">NOM</th>
          <th scope="col">DATE DE FIN</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(value, index) in quizz.value" :key="index">
          <td>{{ value.name }}</td>
          <td>{{ value.endDate.split("T")[0] }}</td>
          <td>
            <router-link
              :to="{ path: '/admin/quizz/edit/' + value.id }"
              class="btn btn-cinemax btn-sm me-2"
              >Modifier</router-link
            >
            <router-link
              :to="{ path: '/admin/quizz/' + value.id + '/form' }"
              class="btn btn-cinemax btn-sm me-2"
              >Question</router-link
            >

             <router-link
              :to="{ path: '/admin/quizz/' + value.id + '/visualisation' }"
              class="btn btn-cinemax btn-sm me-2"
              >Voir</router-link
            >
             <router-link
              :to="{ path: '/admin/quizz/' + value.id + '/results' }"
              class="btn btn-cinemax btn-sm me-2"
              >Résultats</router-link
            >
            <button v-if="value.status == 0"
              class="btn btn-cinemax btn-sm"
              @click="handlePublish(value.id)"
            >
              Publier
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";
import HeaderBanner from "../../../components/HeaderBanner.vue";

const quizz = reactive({ value: [] });


onMounted(async () => {
  await fetchQuizz();
});

const fetchQuizz = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizzs`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.ok) {
      const data = await response.json();
      quizz.value = data["hydra:member"];
    } else {
      const data = await response.json();
      throw new Error("Erreur");
    }
  } catch (error) {
    console.log(error);
  }
};

const handlePublish = async (id) => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/quizz/publish/${id}`,
      {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        body: JSON.stringify({
          status: 1,
        }),
      }
    );
    if (response.ok) {
      let found = quizz.value.findIndex( (e) => e.id == id );
      quizz.value[found].status = 1;
    } else {
      const data = await response.json();
    }
  } catch (error) {
    console.log(error);
  }
};
</script>

<style scoped>
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
