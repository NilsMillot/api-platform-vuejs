<script setup>

import Reservation from '../../components/Reservation.vue';
</script>

<template>
    <main>
    <div class="container mt-2">
      <div class="text-center title">
          <h1 class="flex-shrink-0">Sélectionnez vos places</h1>
      </div>
      <Reservation/>
    </div>
  </main>
</template>

<style scoped>
.title {
  color: var(--color-white);
}
</style>