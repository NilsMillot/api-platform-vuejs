<script setup>
import Booking from '../../components/Booking.vue';
import {onUpdated, reactive, ref} from 'vue'

</script>

<template>
    <div class="container mt-2">
      
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