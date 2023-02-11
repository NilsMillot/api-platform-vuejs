<script setup>
import { provide, onMounted, reactive } from "vue";
import { RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";

const currentUser = reactive({});

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
    const userFetched = await response.json();
    currentUser.id = userFetched.id;
    currentUser.email = userFetched.email;
    currentUser.roles = userFetched.roles;
    currentUser.name = userFetched.name;
    currentUser.adress = userFetched.adress;
  }
};

provide("currentUser", currentUser);
</script>

<template>
  <header>
    <Navbar />
  </header>
  <RouterView @trigger-fetch-current-user="fetchCurrentUserInfos" />
</template>

<style scoped></style>
