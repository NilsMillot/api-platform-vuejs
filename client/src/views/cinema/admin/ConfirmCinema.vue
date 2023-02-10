<template>
    <div class="container mt-5">
        <div class="row">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th scope="col">Cinéma</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="cinema in cinemas" :key="cinema.id">
                        <td>{{ cinema.name }}</td>
                        <td>
                            <button class="btn-sm btn-danger me-2" @click="confirmCinema(cinema.id)">Confirmer</button>
                            <button class="btn-sm btn-danger" @click="deleteCinema(cinema.id)">Supprimer</button>
                        </td>
                    </tr>
                </tbody> 
            </table>
        </div>
    </div>  
</template>

<script setup>

import { onMounted, ref } from "vue";

const cinemas = ref([]);

const getCinemas = async () => {
    return fetch(`${import.meta.env.VITE_API_SERVER_URL}/users`, {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    })
        .then((response) => response.json())
        .then((data) => {
            cinemas.value = data["hydra:member"].filter(
          (x) => x.roles.includes("ROLE_CINEMA") && x.status == 0
        );
        });
};

const confirmCinema = async (id) => {
    const requestOptions = {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
        status: "1",
    }),
  };
  fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${id}`,
    requestOptions
  ).then((response) => console.log(response.json()));
};

const deleteCinema = async (id) => {
    const requestOptions = {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
        status: "-1",
    }),
  };
  fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${id}`,
    requestOptions
  ).then((response) => console.log(response.json()));
};

onMounted(async () => {
    await getCinemas();
});
</script>


<style scoped>

</style>