<template>
  <NewQuizzForm v-if="!shouldOfuscate" />
</template>

<script setup>
import { inject, watchEffect, ref } from "vue";
import NewQuizzForm from "../../../components/admin/quizz/NewQuizzForm.vue";

const shouldOfuscate = ref(true);
const currentUser = inject("currentUser");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_ADMIN")) {
      shouldOfuscate.value = false;
    } else if (
      currentUser.roles?.includes("ROLE_USER") ||
      currentUser.roles?.includes("ROLE_CINEMA")
    ) {
      location.href = "/";
    }
  } else {
    location.href = "/";
  }
});
</script>
