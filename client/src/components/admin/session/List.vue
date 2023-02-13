<template>
  <div class="container m-5">
     <div v-if="message != ''" class="alert alert-dark mt-2" role="alert">
        {{ message }}
      </div>
      <div class="d-flex justify-content-end mb-5">
        <router-link to="/admin/session/new" class="btn btn-sm btn-cinemax-primary">Ajouter une séance</router-link>
      </div>
        <table class="table p-5 tab">
          <thead>
            <tr>
              <th scope="col">CINEMA</th>
              <th scope="col">SEANCE</th>
              <th scope="col">DATE</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(session, index) in sessions.value" :key="index">
              <td>{{ session.creator.name }}</td>
              <td>{{ session.movie_title }}</td>
              <td>{{ session.session_datetime.split("T")[0] }}</td>
              <td>
                 <router-link :to="'/admin/session/edit/'+ session.id" class="btn btn-sm btn-cinemax-primary">Modifier</router-link>
                <button
                  class="btn btn-cinemax-primary btn-sm mx-2"
                  @click="handleDelete(session.id)"
                >
                  Supprimer
                </button>
              </td>
            </tr>
          </tbody>
        </table>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "@vue/runtime-core";

const sessions = reactive({ value: [] });
const message = ref("");

const handleDelete = async (id) => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/session/delete/${id}`,
      {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (!response.ok) {
      const data = await response.json();
      message.value = data.message;
      throw new Error("Une erreur est survenue dans le formulaire.");
    } else {
      let found = sessions.value.find((x) => x.id == id);
      sessions.value.splice(sessions.value.indexOf(found), 1);
      message.value = "La séance a bien été supprimée.";
    }
  } catch (error) {
    console.log(error);
  }
};


onMounted(async () => {
  await fetchSessions();

});

const fetchSessions = async () => {
  const requestOptions = {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/movie_screenings`,
    requestOptions
  ).then((response) =>
    response
      .json()
      .then(
        (data) =>
          (sessions.value = data["hydra:member"].filter(
            (x) =>
              new Date(x.session_datetime) > new Date() &&
              x.status == 1
          ))
      )
  );
};


</script>

<style scoped>

.tab{
  background-color: #2f2f2f;
  color:white;
  padding:200px !important;
}
  
</style>
