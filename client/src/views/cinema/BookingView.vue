<script setup>
import Booking from '../../components/Booking.vue';
import {onUpdated, reactive, ref} from 'vue'

</script>

<template>
    <div class="container mt-2">
      <div class="d-flex title text-center mt-4 mb-3">
          <h1 class="flex-shrink-0">Sélectionnez vos places</h1>
      </div>
      <hr>
      <Booking/>
    </div>
</template>


<style scoped>

.title {
  color: var(--color-white);
  justify-content: center;
  font-size: 20px;
}
</style>