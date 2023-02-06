<script setup>

import { onMounted } from "vue";
import { useRoute } from "vue-router";

onMounted(async () => {
  const { params } = useRoute();
  const { id } = params;
  const token = new URLSearchParams(window.location.search).get("token");

  await enableAccount(id, token);
});
const enableAccount = async (id, token) => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/enable_account/${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ token: token }),
  })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
      });
};
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="content col-md-6 m-auto">
        <div class="card card-body my-5">
          <h2 class="text-center">Compte Activé</h2>
          <p class="text-center">Votre compte a été activé. Vous pouvez vous connecter.</p>
          <div class="text-center">
            <router-link to="/login" class="btn btn-cinemax-primary">Se Connecter</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .container {
    margin-top: 100px;
  }
  .content, .card {
    background-color: #1a1a1a;
    color: #fff;
  }
</style>
