<script setup>
import Session from "../../components/Session.vue";
import HeaderBanner from "../../components/HeaderBanner.vue";
</script>

<template>
  <main>
    <HeaderBanner title="Séances" img="./src/assets/cinema.jpeg" />
    <div class="container mt-2">
      <Session />
    </div>
  </main>
</template>

<style scoped></style>
