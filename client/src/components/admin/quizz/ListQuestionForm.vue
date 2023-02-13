<template>
  <div class="container m-5">
    <table class="table p-5 tab">
      <thead>
        <tr>
          <th scope="col">Questions</th>
          <th scope="col">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(question, index) in questions.value" :key="index">
          <td>{{ question.name }}</td>
          <td>
            <button @click="$emit('deleteQuestion', question.id)" class="btn btn-sm btn-cinemax-primary mx-2">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { reactive,onMounted } from "vue";

const props = defineProps({
    questions:Object,
})

const emit = defineEmits({
  deleteQuestion: true,
});

</script>

<style scoped>
.tab {
  background-color: #2f2f2f;
  color: white;
  padding: 200px !important;
}
</style>
