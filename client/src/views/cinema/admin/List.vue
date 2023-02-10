<template>
  <div class="container m-5">
        <table class="table p-5 tab">
          <thead>
            <tr>
              <th scope="col">SEANCE</th>
              <th scope="col">DATE</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(session, index) in sessions.value" :key="index">
              <td>{{ session.movie_title }}</td>
              <td>{{ session.session_datetime.split("T")[0] }}</td>
              <td>
                <button class="btn btn-danger btn-sm" @click="() => this.$router.push({path: '/cinema/session/edit/' + session.id})">Modifier</button>
                <button
                  class="btn btn-danger btn-sm mx-2"
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

const email = ref(null)

const handleDelete = (id) => { 
  const requestOptions = {
    method: "DELETE",
    headers: {Authorization: `Bearer ${localStorage.getItem("token")}`},
  };
  fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/session/delete/${id}`,
    requestOptions
  ).then((response) => response.json().then( (data) => console.log(data)));
};

onMounted(async () => {
  await getUser();
  await fetchSessions();

});

const getUser = async () => {
  const requestOptions = {
    method: "GET",
    headers: { 
      Authorization: `Bearer ${localStorage.getItem("token")}`
    },
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/me`,
    requestOptions
  ).then((response) => response.json()
  .then((data) => email.value = data.email)
  )
};

const fetchSessions = async () => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/movie_screenings`)
    .then((response) => response.json())
    .then(
      (data) =>
        (sessions.value = data["hydra:member"].filter(
          (x) => new Date(x.session_datetime) > new Date() && x.creator.email == email.value
        ))

      
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
