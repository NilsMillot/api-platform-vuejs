<script setup>
import Session from '../../components/Session.vue';
import SessionsBanner from '../../components/SessionsBanner.vue';
import {onUpdated, reactive, ref} from 'vue'




</script>

<template>
  <main>
    <div class="container mt-2">
      <div class="d-flex title mt-4 mb-3">
          <h1 class="flex-shrink-0">Séances</h1>
          <p class="flex-grow-1 ms-2 m-auto fs-6">- Toutes nos séances</p>
      </div>
      <hr>
      <SessionsBanner/>
      <Session/>
    </div>
  </main>
</template>


<style scoped>

.title {
  color: var(--color-white);
}

.title h1 {
  font-size: 30px;
}
</style>