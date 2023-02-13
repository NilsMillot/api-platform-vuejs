<template>
  <div>
    <h1 v-if="shouldOfuscate">Vous n'avez pas accès à cette page</h1>
    <div class="card card-admin shadow-sm" v-else>
      <div>
        <h3 class="pt-3">Admin</h3>
        <hr />
      </div>
      <div class="d-flex flex-wrap justify-content-center">
        <router-link class="btn mt-4 btn-cinemax" to="/admin/users"
          >Utilisateurs</router-link
        >
        <router-link class="btn mt-4 btn-cinemax" to="/admin/session/list"
          >Séances</router-link
        >
        <router-link class="btn mt-4 btn-cinemax" to="/admin/quizz/new"
          >Quiz</router-link
        >
        <router-link class="btn mt-4 btn-cinemax" to="/admin/sales"
        >Commandes de films</router-link
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import { inject, ref, watchEffect } from "vue";
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
</script>

<style scoped>
h1 {
  text-align: center;
  color: white;
  margin-top: 200px;
}
.card-admin {
  width: 70%;
  height: 100%;
  margin: 50px;
  padding: 20px;
  background-color: #2f2f2f;
  color: var(--color-white);
  box-shadow: 20px;
}
.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
  width: 200px;
  margin: 20px;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
</style>
