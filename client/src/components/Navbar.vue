<template>
  <nav class="navbar navbar-expand-lg navbar-dark px-5">
    <router-link class="navbar-brand logo" to="/">CINEMAX</router-link>
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
          <router-link class="nav-link" to="/">Découvrir</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/session">Cinéma</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" to="/quizz-list">Quizz</router-link>
        </li>

        <li class="nav-item" v-if="currentUser?.roles?.includes('ROLE_ADMIN')">
          <router-link class="nav-link" to="/admin">Admin</router-link>
        </li>

        <li class="nav-item" v-if="currentUser?.roles?.includes('ROLE_CINEMA')">
          <router-link class="nav-link" to="#">Mes projections</router-link>
        </li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item" v-show="!currentUser?.roles">
          <router-link class="nav-link" to="/register">Inscription</router-link>
        </li>
        <li class="nav-item" v-show="!currentUser?.roles">
          <router-link class="nav-link" to="/login">Connexion</router-link>
        </li>

        <li class="nav-item" v-show="currentUser?.roles">
          <router-link class="nav-link" to="/user-account"
            >Mon profil</router-link
          >
        </li>
        <li class="nav-item" v-show="currentUser?.roles">
          <router-link class="nav-link" to="#" @click="handleDisconnect"
            >Deconnexion ({{ currentUser.email }})</router-link
          >
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup>
import { inject } from "vue";

const currentUser = inject("currentUser");

const handleDisconnect = () => {
  localStorage.removeItem("token");
  currentUser.roles = null;
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
