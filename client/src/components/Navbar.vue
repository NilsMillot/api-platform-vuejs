<template>
  <nav class="navbar navbar-expand-lg navbar-dark px-5">
    <a class="navbar-brand logo" href="/">CINEMAX</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Découvrir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/session">Cinéma</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Quizz</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>

        <li class="nav-item" v-if="currentUserRoles?.includes('ROLE_ADMIN')">
          <a class="nav-link" href="/admin">Admin</a>
        </li>

        <li class="nav-item" v-if="currentUserRoles?.includes('ROLE_CINEMA')">
          <a class="nav-link" href="#">Mes projections</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item" v-show="!isCurrentUserLoggedIn">
          <a class="nav-link" href="/register">Inscription</a>
        </li>
        <li class="nav-item" v-show="!isCurrentUserLoggedIn">
          <a class="nav-link" href="/login">Connexion</a>
        </li>

        <li class="nav-item" v-show="isCurrentUserLoggedIn">
          <a class="nav-link" href="#" @click="handleDisconnect"
            >Deconnexion ({{ currentUserEmail }})</a
          >
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup>
import { onMounted, ref } from "vue";
const currentUserEmail = ref("");
const currentUserRoles = ref([]);
const isCurrentUserLoggedIn = ref(false);

onMounted(async () => {
  const response = await fetch(`${import.meta.env.VITE_API_SERVER_URL}/me`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  });
  const currentUser = await response.json();
  if (currentUser.roles) {
    isCurrentUserLoggedIn.value = true;
  }
  currentUserRoles.value = currentUser.roles;
  currentUserEmail.value = currentUser.email;
});

const handleDisconnect = () => {
  localStorage.removeItem("token");
  isCurrentUserLoggedIn.value = false;
  location.href = "/login";
};
</script>

<style scoped>
.logo {
  color: var(--color-red);
}

nav {
  background-color: var(--color-grey);
}

nav div a {
  color: var(--color-white);
  font-size: 14px;
}

nav a:hover {
  color: var(--color-red);
}
</style>
