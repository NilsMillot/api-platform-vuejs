<script setup>
import { provide, ref, onMounted } from "vue";
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";

const currentUserEmail = ref("");
const currentUserRoles = ref([]);
const isCurrentUserLoggedIn = ref(false);

onMounted(async () => {
  fetchCurrentUserInfos();
});

const fetchCurrentUserInfos = async () => {
  if (localStorage.getItem("token")) {
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
  }
};

provide("currentUserEmail", currentUserEmail);
provide("currentUserRoles", currentUserRoles);
provide("isCurrentUserLoggedIn", isCurrentUserLoggedIn);
</script>

<template>
  <header>
    <Navbar />
  </header>
  <RouterView @trigger-fetch-current-user="fetchCurrentUserInfos" />
</template>

<style scoped></style>
